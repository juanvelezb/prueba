<?php
include 'bd/conexion.php';
// Permitir los métodos GET, POST, PUT, DELETE y OPTIONS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Permitir ciertos encabezados en las solicitudes
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejo de parametros GET
    if (isset($_GET['idal'])) {
        obtenerIdal($conn, $_GET['idal']);
    } elseif (isset($_GET['ide'])) {
        obtenerIde($conn, $_GET['ide']);
    }elseif(isset($_GET['mail'])){
        obtenerMail($conn, $_GET['mail']);
    }elseif(isset($_GET['peso'])){
        obtenerPeso($conn, $_GET['peso']);
    }elseif(isset($_GET['ancho'])){
        obtenerAncho($conn, $_GET['ancho']);
    }elseif(isset($_GET['largo'])){
        obtenerLargo($conn, $_GET['largo']);
    }elseif(isset($_GET['page'])){
        obtenerTodas($conn, $_GET['page']);
    }else{
        echo json_encode(['error' => 'Parametros Incorrecto.'], JSON_UNESCAPED_UNICODE);
    }
}
function obtenerIdal($conn, $idal) {
    $sentencia = $conn->prepare("SELECT * FROM alumnos WHERE idalumnos  = :idal");
    $sentencia->bindParam(':idal', $idal , PDO::PARAM_INT);
    ejecutarConsulta($sentencia);
}
function obtenerIde($conn, $ide) {
    $sentencia = $conn->prepare("SELECT * FROM alumnos WHERE identificacion = :ide");
    $sentencia->bindParam(':ide', $ide, PDO::PARAM_INT);
    ejecutarConsulta($sentencia);
}
function obtenerMail($conn, $mail) {
    $sentencia = $conn->prepare("SELECT * FROM alumnos  WHERE correo = :mail");
    $sentencia->bindParam(':mail', $mail, PDO::PARAM_STR);
    ejecutarConsulta($sentencia);
}
function obtenerTodas($conn, $page) {
    if ($page > 0){
        $offset = ($page - 1) * 50;
        $sentencia = $conn->prepare("SELECT * FROM alumnos LIMIT 50 OFFSET :offset");
        $sentencia->bindParam(':offset', $offset, PDO::PARAM_INT);
        ejecutarConsulta($sentencia);
    }else{
        echo json_encode(['error' => 'No es dato de pagina correcto.'], JSON_UNESCAPED_UNICODE);
    }  
}
function ejecutarConsulta($sentencia) {
    $sentencia->execute();
    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    if ($resultado) {
        echo json_encode(['data' => $resultado], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['error' => 'No se encontraron Datos en la base datos.'], JSON_UNESCAPED_UNICODE);
    }
}
?>
