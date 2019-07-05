<!DOCTYPE html>

<?php
include_once '../lib/ControlAcceso.Class.php';

if (!(ControlAcceso::verificaPermiso(PermisosSistema::PERMISO_CREAR_FORMULARIOS) || ControlAcceso::verificaPermiso(PermisosSistema::PERMISO_ADMINISTRAR_GESTORES))) {
    ControlAcceso::redireccionar();
}

require_once '../modelo/BDConexion.Class.php';
require_once '../modelo/Usuario.Class.php';

$usuario = new Usuario($_SESSION['usuario']->id);

if ($usuario->esAdministradorDeGestores()) {
    $query = "" .
            "SELECT * " .
            "FROM " . BDCatalogoTablas::BD_TABLA_FORMULARIO;
} else {
    $query = "" .
            "SELECT * " .
            "FROM " . BDCatalogoTablas::BD_TABLA_FORMULARIO . " " .
            "WHERE `idCreador` = {$_SESSION['usuario']->id}";
}

$formularios = BDConexion::getInstancia("bdFormularios")->query($query);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../lib/bootstrap-4.1.1-dist/css/bootstrap.css" />
        <link rel="stylesheet" href="../lib/open-iconic-master/font/css/open-iconic-bootstrap.css" />

        <!-- Hojas de estilo requeridas por el sistema Colibrí -->
        <link rel="stylesheet" href="../lib/jquery-ui-1.12.1/jquery-ui.css">
        <link rel="stylesheet" href="../gui/css/colibri.css" />

        <script type="text/javascript" src="../lib/JQuery/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="../lib/bootstrap-4.1.1-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../lib/jquery-ui-1.12.1/jquery-ui.min.js"></script>

        <title><?php echo Constantes::NOMBRE_SISTEMA; ?> - Gestor de formularios</title>
    </head>
    <body>
        <?php include_once '../gui/navbar.php'; ?>

        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3>Gestor de formularios</h3>
                </div>
                <div class="card-body">
                    <p>Aquí podrá ver y gestionar todos los formularios en el sistema que estén bajo su responsabilidad.<br/>Por favor tenga en cuenta que sólo podrá modificar formularios que no registren respuestas y que estén deshabilitados.</p>

                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><span class="oi oi-magnifying-glass"></span></div>
                        </div>

                        <input class="form-control" id="filtrarFormularios" placeholder="Puede filtrar formularios por su título">
                    </div>
                    <br/>

                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="table-info">
                                <th scope="col">Título del formulario</th>
                                <th scope="col">Fecha de creación</th>
                                <th scope="col">Respuestas registradas</th>
                                <th scope="col">Estado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody id="listaFormularios">
                            <?php while ($formulario = $formularios->fetch_assoc()) { ?>

                                <tr>
                                    <td style="vertical-align: middle;"><?= $formulario['titulo']; ?></td>
                                    <td style="vertical-align: middle;"><?= $formulario['fechaCreacion']; ?></td>
                                    <td style="vertical-align: middle;">
                                        
                                        <?php
                                        $cantidadRespuestas = $formulario['cantidadRespuestas'];
                                        
                                        echo $cantidadRespuestas;
                                        ?>
                                        
                                    </td>
                                    <td style="vertical-align: middle;">
                                        
                                        <?php
                                        $formularioHabilitado = $formulario['estaHabilitado'];
                                        $fechaApertura = $formulario['fechaApertura'];
                                        $fechaCierre = $formulario['fechaCierre'];

                                        if ($formularioHabilitado == 0) {
                                        ?>
                                        
                                            <span class="estado-deshabilitado">DESHABILITADO</span>

                                        <?php
                                        } else if (($fechaApertura != "" && date("Y-m-d") < $fechaApertura) || ($fechaCierre != "" && date("Y-m-d") > $fechaCierre)) {
                                            $estaOculto = true;
                                        ?>

                                            <span class="estado-habilitado">HABILITADO</span><span class="estado-oculto" title="Esto significa que, si bien este formulario está habilitado, su fecha de apertura/cierre impide el acceso al mismo.">OCULTO</span>

                                        <?php } else { ?>

                                            <span class="estado-habilitado">HABILITADO</span>

                                        <?php } ?>

                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        
                                        <?php
                                        if ($formularioHabilitado == 0) {
                                            if ($cantidadRespuestas == 0 && ControlAcceso::verificaPermiso(PermisosSistema::PERMISO_CREAR_FORMULARIOS)) {
                                        ?>

                                            <a class="btn btn-outline-warning" href="formulario.modificar.php?id=<?= $formulario['idFormulario']; ?>" style="margin-bottom: 2px;" title="Modificar este formulario.">
                                                <span class="oi oi-pencil"></span>
                                            </a>    

                                        <?php
                                            }
                                        } else {
                                            if (!$estaOculto) {
                                        ?>
                                        
                                            <a class="btn btn-light" href="formulario.ver.php?id=<?= $formulario['idFormulario']; ?>" style="margin-bottom: 2px;" target="_blank" title="Visitar este formulario.">
                                                <span class="oi oi-eye"></span>
                                            </a>
                                            
                                        <?php
                                            }
                                        }
                                        ?>
                                        
                                        <a class="btn btn-outline-info" href="formulario.ver.detalles.php?id=<?= $formulario['idFormulario']; ?>" style="margin-bottom: 2px;" title="Ver más detalles acerca de este formulario.">
                                            <span class="oi oi-zoom-in"></span>
                                        </a>

                                        <?php if ($formularioHabilitado == 0) { ?>

                                            <a class="btn btn-outline-success" href="formulario.modificar.estado.php?id=<?= $formulario['idFormulario']; ?>&estado=1" style="margin-bottom: 2px;" title="Habilitar este formulario.">
                                                <span class="oi oi-check"></span>
                                            </a>

                                        <?php } else { ?>

                                            <a class="btn btn-outline-dark" href="formulario.modificar.estado.php?id=<?= $formulario['idFormulario']; ?>&estado=0" style="margin-bottom: 2px;" title="Deshabilitar este formulario.">
                                                <span class="oi oi-x"></span>
                                            </a>

                                        <?php } ?>

                                        <?php if (ControlAcceso::verificaPermiso(PermisosSistema::PERMISO_ELIMINAR_FORMULARIOS)) { ?>

                                            <a class="btn btn-outline-danger" href="formulario.eliminar.php?id=<?= $formulario['idFormulario']; ?>" style="margin-bottom: 2px;" title="Eliminar este formulario.">
                                                <span class="oi oi-trash"></span>
                                            </a>

                                        <?php } ?>

                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <?php if (ControlAcceso::verificaPermiso(PermisosSistema::PERMISO_CREAR_FORMULARIOS)) { ?>
                        <a class="btn btn-success" href="formulario.crear.php">
                            <span class="oi oi-plus"></span> Nuevo formulario
                        </a>
                    <?php } ?>
                    
                    <?php if ($usuario->esAdministradorDeGestores()) { ?>
                        <a class="btn btn-secondary" href="formulario.gestor.pendientes.php" title="Ver todos los formularios que todavía requieren ser habilitados.">
                            <span class="oi oi-task"></span> Gestionar formularios pendientes
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php include_once '../gui/footer.php'; ?>
    </body>

    <script type="text/javascript">
        $("#filtrarFormularios").keyup(function () {
            var palabraClave, listaFormularios;
            palabraClave = this.value.toUpperCase();
            listaFormularios = $("#listaFormularios").find("tr");

            for (var i = 0; i < listaFormularios.length; i++) {
                var tituloFormulario = listaFormularios[i].getElementsByTagName("td")[0].textContent;

                if (tituloFormulario.toUpperCase().indexOf(palabraClave) > -1) {
                    listaFormularios[i].style.display = "";
                } else {
                    listaFormularios[i].style.display = "none";
                }
            }
        });

        /* Se habilitan los tooltips de jQuery. */
        $(document).tooltip({
            show: {
                effect: "fade",
                delay: 0,
                duration: 275
            }
        });
    </script>

</html>
