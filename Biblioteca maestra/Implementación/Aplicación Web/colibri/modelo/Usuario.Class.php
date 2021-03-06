<?php

include_once '../lib/BDCatalogoTablas.Class.php';
include_once 'BDObjetoGenerico.Class.php';
include_once 'Rol.Class.php';

class Usuario extends BDObjetoGenerico {

    protected $email;

    /**
     *
     * @var Rol[]
     */
    private $roles;

    function __construct($id = null) {
        parent::__construct($id, BDCatalogoTablas::BD_TABLA_USUARIO);
        $this->setRoles(BDCatalogoTablas::BD_TABLA_USUARIO_ROL, BDCatalogoTablas::BD_TABLA_ROL, "id_usuario", "id_rol", "Rol");
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    /**
     * 
     * @param type $tablaVinculacion
     * @param type $tablaElementos
     * @param type $idObjetoContenedor
     * @param type $atributoFKElementoColeccion
     * @param type $claseElementoColeccion
     * 
     */
    function setRoles($tablaVinculacion, $tablaElementos, $idObjetoContenedor, $atributoFKElementoColeccion, $claseElementoColeccion) {
        $this->setColeccionElementos($tablaVinculacion, $tablaElementos, $idObjetoContenedor, $atributoFKElementoColeccion, $claseElementoColeccion);
        $this->roles = $this->getColeccionElementos();
    }

    function getRoles() {
        return $this->roles;
    }

    /**
     * 
     * @param int $id
     * @return boolean
     */
    function buscarRolPorId($id) {
        foreach ($this->getRoles() as $RolUsuario) {
            if ($id == $RolUsuario->getId()) {
                return true;
            }
        }
        return false;
    }

    function esAdministradorDeGestores() {
        foreach ($this->getRoles() as $RolUsuario) {
            if ($RolUsuario->getNombre() === "Administrador de gestores de formularios") {
                return true;
            }
        }

        return false;
    }

    function esGestorDeFormularios() {
        foreach ($this->getRoles() as $RolUsuario) {
            if ($RolUsuario->getNombre() === "Gestor de formularios") {
                return true;
            }
        }

        return false;
    }

}
