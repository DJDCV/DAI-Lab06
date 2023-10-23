<?php include 'template/header.php' ?>

<?php
include_once "model/conexion.php";
$codigo = $_GET['codigo'];

$sentencia = $bd->prepare("select * from info_pasaje where id = ?;");
$sentencia->execute([$codigo]);
$info_pasaje = $sentencia->fetch(PDO::FETCH_OBJ);
// Implementación del mensaje de confirmacion
session_start();
$confirmacion = isset($_SESSION['confirmacion']) ? $_SESSION['confirmacion'] : null;
unset($_SESSION['confirmacion']);

$sentencia_informacion = $bd->prepare("select * from pasaje where id_info_pasaje = ?;");
$sentencia_informacion->execute([$codigo]);
$informacion = $sentencia_informacion->fetchAll(PDO::FETCH_OBJ); 
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-4">

            <?php if ($confirmacion) : ?>
                <!-- Muestra el mensaje de confirmación -->
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $confirmacion; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    Ingresar datos del pasaje : <br><?php echo $info_pasaje->nombres.' '.$info_pasaje->apellido_paterno.' '.$info_pasaje->apellido_materno; ?>
                </div>
                <form class="p-4" method="POST" action="registrarPasaje.php">
                    <div class="mb-3">
                        <label class="form-label">Pasaje: </label>
                        <input type="text" class="form-control" name="txtInformacion" autofocus required>
                    </div>
                    <div class="d-grid">
                    <input type="hidden" name="codigo" value="<?php echo $info_pasaje->id; ?>"><P></P>
                        <input type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    Lista de Pasajes
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Pasaje</th>
                                <th scope="col" colspan="3">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($informacion as $dato) {
                            ?>
                                <tr>
                                    <td scope="row"><?php echo $dato->id; ?></td>
                                    <td><?php echo $dato->informacion; ?></td>
                                    <td><a class="text-primary" href="enviarMensaje.php?codigo=<?php echo $dato->id; ?>"><i class="bi bi-cursor"></i></a></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php' ?>