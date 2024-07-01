<?php
include 'bd/conexion.php';
// Permitir los métodos GET, POST, PUT, DELETE y OPTIONS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Permitir ciertos encabezados en las solicitudes
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejo de parametros GET
    if (isset($_GET['idd'])) {
        obtenerPorIdd($conn, $_GET['idd']);
    } elseif (isset($_GET['ide'])) {
        obtenerIde($conn, $_GET['ide']);
    }elseif(isset($_GET['name'])){
        obtenerName($conn, $_GET['name']);
    }elseif(isset($_GET['tel'])){
        obtenerTel($conn, $_GET['tel']);
    }elseif(isset($_GET['mail'])){
        obtenerMail($conn, $_GET['mail']);
    }elseif(isset($_GET['esp'])){
        obtenerEsp($conn, $_GET['esp']);
    }elseif(isset($_GET['status'])){
        obtenerEstado($conn, $_GET['status']);
    }elseif(isset($_GET['page'])){
        obtenerTodas($conn, $_GET['page']);
    }else{
        echo json_encode(['error' => 'Parametros Incorrecto.'], JSON_UNESCAPED_UNICODE);
    }
}

function obtenerPorIdd($conn, $idd) {
    $sentencia = $conn->prepare("SELECT * FROM docentes WHERE iddocente = :idd");
    $sentencia->bindParam(':idd', $idd , PDO::PARAM_INT);
    ejecutarConsulta($sentencia);
}
function obtenerIde($conn, $ide) {
    $sentencia = $conn->prepare("SELECT * FROM docentes WHERE identificacion = :ide");
    $sentencia->bindParam(':ide', $ide, PDO::PARAM_STR);
    ejecutarConsulta($sentencia);
}
function obtenerName($conn, $name) {
    $sentencia = $conn->prepare("SELECT * FROM docentes  WHERE nombres LIKE CONCAT(:name , '%')");
    $sentencia->bindParam(':name', $name, PDO::PARAM_STR);
    ejecutarConsulta($sentencia);
}
function obtenerTel($conn, $tel) {
    $sentencia = $conn->prepare("SELECT * FROM docentes WHERE telefono = :tel");
    $sentencia->bindParam(':tel', $tel, PDO::PARAM_STR);
    ejecutarConsulta($sentencia);
}
function obtenerMail($conn, $mail) {
    $sentencia = $conn->prepare("SELECT * FROM docentes WHERE correo = :mail");
    $sentencia->bindParam(':mail', $mail, PDO::PARAM_STR);
    ejecutarConsulta($sentencia);
}
function obtenerEsp($conn, $esp) {
    $sentencia = $conn->prepare("SELECT * FROM docentes WHERE especialidad = :esp");
    $sentencia->bindParam(':esp', $esp, PDO::PARAM_STR);
    ejecutarConsulta($sentencia);
}

function obtenerEstado($conn, $status) {
    $sentencia = $conn->prepare("SELECT * FROM docentes WHERE estado = :status");
    $sentencia->bindParam(':status', $status    , PDO::PARAM_STR);
    ejecutarConsulta($sentencia);
}

function ejecutarConsulta($sentencia) {
    $sentencia->execute();
    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    if ($resultado) {
        echo json_encode(['data' => $resultado], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['error' => 'No se encontraron Datos. Fijese Bien'], JSON_UNESCAPED_UNICODE);
    }
}

function obtenerTodas($conn, $page) {
    if ($page > 0){
        $offset = ($page - 1) * 50;
        $sentencia = $conn->prepare("SELECT * FROM docentes LIMIT 50 OFFSET :offset");
        $sentencia->bindParam(':offset', $offset, PDO::PARAM_INT);
        ejecutarConsulta($sentencia);
    }else{
        echo json_encode(['error' => 'No es dato de pagina correcto.'], JSON_UNESCAPED_UNICODE);
    } 
}     
?>
