<?php
class EventosAdmModel extends ItemsModel {

    public $table_name = 'eventos';
    public $idTable = 'idEvento';
    public $urlName = 'evento/adm';
    public $form = 'insere_evento';
    public $haveImage = true;
    public $action = false;
    public $lista = [];
    public $contador;
    public function __construct($db = false, $controller = null){
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
        parent::__construct($this->table_name, $this->idTable, $this->urlName, $this->form, $this->haveImage, $this->action, $this->db, $this->controller);
        $this->lista = $this->listar_items();
        $this->contador = 0;
    }

}
