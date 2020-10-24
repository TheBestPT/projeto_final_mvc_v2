<?php
class QuotasAdmModel extends ItemsModel implements IteratorInterface {
    public $table_name = 'quotas';
    public $idTable = 'idQuota';
    public $urlName = 'assocquotas';
    public $form = 'insere_quota';
    public $haveImage = false;
    public $action = true;
    public $contador;
    public $lista = [];
    public function __construct($db = false, $controller = null)
    {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
        parent::__construct($this->table_name, $this->idTable, $this->urlName, $this->form, $this->haveImage, $this->action, $this->db, $this->controller);
        $this->lista = parent::listar_items();
        $this->contador = 0;
    }

    public function getQuotas($id = 0){
        if($id!=0){
            $query = $this->db->query('SELECT * FROM '.$this->table_name.' WHERE idSocio = '.$id);
            return $query->fetchAll();
        }
    }

    public function first(){
        $this->contador = 0;
    }

    public function next(){
        $this->contador++;
    }

    public function isDone(){
        return $this->contador == count($this->lista);
    }

    public function currentItem(){
        if($this->isDone()){
            $this->contador = count($this->lista)-1;
        }else if($this->contador < 0){
            $this->contador = 0;
        }
        return $this->lista[$this->contador];
    }
}