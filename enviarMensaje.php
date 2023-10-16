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

    $url = 'https://whapi.io/api/send';
    $data = [
        "app" => [
            "id" => '51961498695',
            "time" => '1654728819',
            "data" => [
                "recipient" => [
                    "id" => '51'.$info_pasaje->celular
                ],
                "message" => [[
                    "time" => '1654728819',
                    "type" => 'text',
                    "value" => 'Estimado(a) *'.strtoupper($info_pasaje->nombres).' '.strtoupper($info_pasaje->apellido_paterno).' '.strtoupper($info_pasaje->apellido_materno).'* Recuerde que su pasaje: *'.strtoupper($info_pasaje->informacion)
                ]]
            ]
        ]
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
    header('Location: agregarPasaje.php?codigo='.$info_pasaje->id_info_pasaje);
?>