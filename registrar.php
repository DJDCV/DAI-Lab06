<?php
if (empty($_POST["oculto"]) || empty($_POST["txtNombres"]) || empty($_POST["txtApPaterno"]) || empty($_POST["txtApMaterno"]) || empty($_POST["txtDni"]) || empty($_POST["txtFechaNacimiento"]) || empty($_POST["txtCelular"]) || empty($_POST["txtCorreo"])) {
    header('Location: index.php?mensaje=falta');
    exit();
}

include_once 'model/conexion.php';
$nombres = $_POST["txtNombres"];
$ap_paterno = $_POST["txtApPaterno"];
$ap_materno = $_POST["txtApMaterno"];
$dni = $_POST["txtDni"];
$fecha_nacimiento = $_POST["txtFechaNacimiento"];
$celular = $_POST["txtCelular"];
$correo = $_POST["txtCorreo"];

$sentencia = $bd->prepare("INSERT INTO info_pasaje(nombres,apellido_paterno,apellido_materno,dni,fecha_nacimiento,celular,correo) VALUES (?,?,?,?,?,?,?);");
$resultado = $sentencia->execute([$nombres, $ap_paterno, $ap_materno, $dni, $fecha_nacimiento, $celular, $correo]);

if ($resultado === TRUE) {
    header('Location: index.php?mensaje=registrado');
} else {
    header('Location: index.php?mensaje=error');
    exit();
}

