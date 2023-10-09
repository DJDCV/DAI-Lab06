<?php
    print_r($_POST);
    if(!isset($_POST['codigo'])){
        header('Location: index.php?mensaje=error');
    }
    include 'model/conexion.php';
    $codigo = $_POST['codigo'];
    $nombres = $_POST["txtNombres"];
    $ap_paterno = $_POST["txtApPaterno"];
    $ap_materno = $_POST["txtApMaterno"];
    $dni = $_POST["txtDni"];
    $fecha_nacimiento = $_POST["txtFechaNacimiento"];
    $celular = $_POST["txtCelular"];
    $correo = $_POST["txtCorreo"];
    
    $sentencia = $bd->prepare("UPDATE info_pasaje SET nombres = ?, apellido_paterno = ?, apellido_materno = ?, dni = ?,fecha_nacimiento = ?,celular = ?, correo = ? where id = ?;");
    $resultado = $sentencia->execute([$nombres, $ap_paterno, $ap_materno, $dni, $fecha_nacimiento, $celular, $correo, $codigo]);

    if ($resultado === TRUE) {
        header('Location: index.php?mensaje=editado');
    } else {
        header('Location: index.php?mensaje=error');
        exit();
    }
