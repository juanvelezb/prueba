<?php
include 'bd/conexion.php';
// Permitir los métodos GET, POST, PUT, DELETE y OPTIONS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
// Permitir ciertos encabezados en las solicitudes
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['t1']) && isset($_POST['t2'])) {
    verificar($conn, $_POST['t1'], $_POST['t2']);
   }//cerrar if
}
function verificar($conn, $u , $c) {
    $sentencia = $conn->prepare("SELECT rol FROM token WHERE usuario = :u and contrasena = :c");
    $sentencia->bindParam(':u', $u, PDO::PARAM_STR);
    $sentencia->bindParam(':c', $c, PDO::PARAM_STR);
    ejecutarConsulta($sentencia);
}

function ejecutarConsulta($sentencia) {

    $sentencia->execute();
    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    if ($resultado) {
        echo json_encode(['data' => $resultado], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['error' => 'usuario o contraseña inconrrecta'], JSON_UNESCAPED_UNICODE);
    }
} 
//cerrar
?>