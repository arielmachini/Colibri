<!DOCTYPE html>

<?php
include_once '../lib/ControlAcceso.Class.php';
ControlAcceso::requierePermiso(PermisosSistema::PERMISO_ROLES);

include_once '../modelo/Rol.Class.php';

$id = $_GET["id"];

if ($id == PermisosSistema::IDROL_PUBLICO_GENERAL) {
    /* El rol "Público general" no debe ser eliminado. */
    ControlAcceso::redireccionar("roles.php");
    
    exit();
}

$Rol = new Rol($id);
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
            <form action="rol.eliminar.procesar.php" method="post">
                <div class="card">
                    <div class="card-header">
                        <h3>Eliminar Rol</h3>
                    </div>
                    <div class="card-body">
                        <p class="alert alert-warning ">
                            <span class="oi oi-warning"></span> ATENCIóN. Esta operación no puede deshacerse.
                        </p>
                        <p>¿Está seguro que desea eliminar el rol <strong><?= $Rol->getNombre(); ?></strong>?</p>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="id" class="form-control" id="id" value="<?= $Rol->getId(); ?>" >
                        <button type="submit" class="btn btn-outline-success">
                            <span class="oi oi-check"></span> Sí, deseo eliminar
                        </button>
                        <a class="btn btn-outline-danger" href="roles.php">
                            <span class="oi oi-x"></span> NO (Salir de esta pantalla)
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <?php include_once '../gui/footer.php'; ?>
    </body>
</html>