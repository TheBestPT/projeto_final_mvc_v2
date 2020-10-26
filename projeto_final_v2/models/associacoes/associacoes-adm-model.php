<?php
class AssociacoesAdmModel extends ItemsModel {
    public $table_name = 'associacao';
    public $idTable = 'idAssoc';
    public $urlName = 'associacoes/adm';
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


}
?>