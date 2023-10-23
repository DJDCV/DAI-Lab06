<?php
if (!isset($_GET['codigo'])) {
    header('Location: index.php?mensaje=error');
    exit();
}

include 'model/conexion.php';
$codigo = $_GET['codigo'];

$sentencia = $bd->prepare("SELECT pas.informacion, pas.id_info_pasaje, inf.nombres , inf.apellido_paterno ,inf.apellido_materno,inf.dni, inf.fecha_nacimiento, inf.celular, inf.correo
  FROM pasaje pas 
  INNER JOIN info_pasaje inf ON inf.id = pas.id_info_pasaje 
  WHERE pas.id = ?;");
$sentencia->execute([$codigo]);
$info_pasaje = $sentencia->fetch(PDO::FETCH_OBJ);

$url = 'https://api.green-api.com/waInstance7103864954/SendMessage/2a67ae0e8e534be3b1d036d52d1b7959ed911b894f6e40d68d';
$data = [
    "chatId" => "51".$info_pasaje->celular."@c.us",
    "message" =>  'Estimado(a) '.strtoupper($info_pasaje->nombres).' '.strtoupper($info_pasaje->apellido_paterno).strtoupper($info_pasaje->apellido_materno).'  Información de su pasaje: '.strtoupper($info_pasaje->informacion).'*'
];
$options = array(
    'http' => array(
        'method'  => 'POST',
        'content' => json_encode($data),
        'header' =>  "Content-Type: application/json\r\n" .
            "Accept: application/json\r\n"
    )
);


    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    // Implementación del mensaje de confirmacion
    session_start();
    $_SESSION['confirmacion'] = 'El mensaje se envió con éxito a WhatsApp';    

    header('Location: agregarPasaje.php?codigo='.$info_pasaje->id_info_pasaje);
?>