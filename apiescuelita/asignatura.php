<?php
include 'bd/conexion.php';
// Permitir los métodos GET(consulta), POST(guardar), PUT(editar), DELETE(eliminar) y OPTIONS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejo de parametros GET
    if (isset($_GET['ida'])) {
        obtenerPorIda($conn, $_GET['ida']);
    } elseif (isset($_GET['asi'])) {
        obtenerAsi($conn, $_GET['asi']);
    }elseif(isset($_GET['page'])){
        obtenerTodas($conn, $_GET['page']);
    }else{
        echo json_encode(['error' => 'Parametros Incorrecto.'], JSON_UNESCAPED_UNICODE);
    }
}

function obtenerPorIda($conn, $ida) {
    $sentencia = $conn->prepare("SELECT * FROM asignaturas WHERE idasignatura = :ida");
    $sentencia->bindParam(':ida', $ida , PDO::PARAM_INT);
    ejecutarConsulta($sentencia);
}
function obtenerAsi($conn, $asi) {
    $sentencia = $conn->prepare("SELECT * FROM asignaturas WHERE asignatura = :asi");
    $sentencia->bindParam(':asi', $asi, PDO::PARAM_STR);
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
        $sentencia = $conn->prepare("SELECT * FROM asignaturas LIMIT 50 OFFSET :offset");
        $sentencia->bindParam(':offset', $offset, PDO::PARAM_INT);
        ejecutarConsulta($sentencia);
    }else{
        echo json_encode(['error' => 'No es dato de pagina correcto.'], JSON_UNESCAPED_UNICODE);
    } 
}
?>
