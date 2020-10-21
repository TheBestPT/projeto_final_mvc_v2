<?php
class SociosAdmModel extends ItemsModel{
    public $table_name = 'socios';
    public $idTable = 'idSocio';
    public $urlName = 'admassoc';
    public $form = 'insere_soc';
    public $haveImage = false;
    public $action = true;
    public function __construct($db = false, $controller = null)
    {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
        parent::__construct($this->table_name, $this->idTable, $this->urlName, $this->form, $this->haveImage, $this->action, $this->db, $this->controller);
    }

}