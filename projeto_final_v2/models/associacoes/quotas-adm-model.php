<?php
class QuotasAdmModel extends ItemsModel {
    public $table_name = 'quotas';
    public $idTable = 'idQuota';
    public $urlName = 'associacoes/assocquotas';
    public $form = 'insere_quota';
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

    public function getQuotas($id = 0){
        if($id!=0){
            $query = $this->db->query('SELECT * FROM '.$this->table_name.' WHERE idSocio = '.$id);
            return $query->fetchAll();
        }
        return [];
    }
}