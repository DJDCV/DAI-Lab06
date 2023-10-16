<?php
//print_r($_POST);
if (empty($_POST["txtInformacion"])) {
    header('Location: index.php');
    exit();
}

include_once 'model/conexion.php';
$informacion = $_POST["txtInformacion"];
$codigo = $_POST["codigo"];


$sentencia = $bd->prepare("INSERT INTO pasaje(informacion,id_info_pasaje) VALUES (?,?);");
$resultado = $sentencia->execute([$informacion, $codigo ]);

if ($resultado === TRUE) {
    header('Location: agregarPasaje.php?codigo='.$codigo);
} 