<?php
class AssociacoesAdmModel extends ItemsModel implements IteratorInterface {
    public $table_name = 'associacao';
    public $idTable = 'idAssoc';
    public $urlName = 'associacoes';
    public $form = 'insere_assoc';
    public $haveImage = false;
    public $action = false;
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

    public function obterQuotasById($id = 0, $str = ""){
        $query = "";
        if($id!=0){
            $query = $this->db->query('SELECT * FROM quotas WHERE idSocio = '.$id);
            $data = $query->fetch();
            return $data[$str];
        }
        return 'Sem quotas';
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
?>