<!DOCTYPE html>

<?php
include_once '../lib/ControlAcceso.Class.php';
ControlAcceso::requierePermiso(PermisosSistema::PERMISO_ROLES);

include_once '../modelo/BDConexion.Class.php';

$DatosFormulario = $_POST;

BDConexion::getInstancia()->autocommit(false);
BDConexion::getInstancia()->begin_transaction();

$query = "DELETE FROM " . BDCatalogoTablas::BD_TABLA_ROL_PERMISO . " "
        . "WHERE id_rol = {$DatosFormulario["id"]}";

$consulta = BDConexion::getInstancia()->query($query);
if (!$consulta) {
    BDConexion::getInstancia()->rollback();
    //arrojar una excepcion
    die(BDConexion::getInstancia()->errno);
}

$query = "DELETE FROM " . BDCatalogoTablas::BD_TABLA_USUARIO_ROL . " "
        . "WHERE id_rol = {$DatosFormulario["id"]}";

$consulta = BDConexion::getInstancia()->query($query);
if (!$consulta) {
    BDConexion::getInstancia()->rollback();
    //arrojar una excepcion
    die(BDConexion::getInstancia()->errno);
}

$query = "DELETE FROM " . BDCatalogoTablas::BD_TABLA_ROL . " "
        . "WHERE id = {$DatosFormulario["id"]}";
$consulta = BDConexion::getInstancia()->query($query);
if (!$consulta) {
    BDConexion::getInstancia()->rollback();
    //arrojar una excepcion
    die(BDConexion::getInstancia()->errno);
}
BDConexion::getInstancia()->commit();
BDConexion::getInstancia()->autocommit(true);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../lib/bootstrap-4.1.1-dist/css/bootstrap.css" />
        <link rel="stylesheet" href="../lib/open-iconic-master/font/css/open-iconic-bootstrap.css" />
        <script type="text/javascript" src="../lib/JQuery/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="../lib/bootstrap-4.1.1-dist/js/bootstrap.min.js"></script>
        <title><?php echo Constantes::NOMBRE_SISTEMA; ?> - Eliminar Rol</title>

    </head>
    <body>
        <?php include_once '../gui/navbar.php'; ?>
        <div class="container">
            <p></p>
            <div class="card">
                <div class="card-header">
                    <h3>Eliminar Rol</h3>
                </div>
                <div class="card-body">
                    <?php if ($consulta) { ?>
                        <div class="alert alert-success" role="alert">
                            Operación realizada con éxito.
                        </div>
                    <?php } ?>   
                    <?php if (!$consulta) { ?>
                        <div class="alert alert-danger" role="alert">
                            Ha ocurrido un error.
                        </div>
                    <?php } ?>
                    <hr />
                    <h5 class="card-text">Opciones</h5>
                    <a class="btn btn-primary" href="roles.php">
                        <span class="oi oi-account-logout"></span> Salir
                    </a>
                </div>
            </div>
        </div>
        <?php include_once '../gui/footer.php'; ?>
    </body>
</html>
