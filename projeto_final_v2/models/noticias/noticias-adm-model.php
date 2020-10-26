<?php
class NoticiasAdmModel extends ItemsModel{
    public $table_name = 'noticias';
    public $idTable = 'idNoticia';
    public $urlName = 'noticias/adm';
    public $form = 'insere_noticia';
    public $haveImage = true;
    public $action = false;
    public $lista = [];
    public $contador;
    public function __construct($db = false, $controller = null)
    {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
        parent::__construct($this->table_name, $this->idTable, $this->urlName, $this->form, $this->haveImage, $this->action, $this->db, $this->controller);
        $this->lista = $this->listar_items();
        $this->contador = 0;
    }

    public function getNoticiasById($id = 0){
        if($id != 0){
            $query = $this->db->query('SELECT * FROM '.$this->table_name.' WHERE idAssoc = '.$id);
            return $query->fetchAll();
        }
        return [];
    }
}
?>