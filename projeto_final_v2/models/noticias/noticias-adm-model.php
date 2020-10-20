<?php
class NoticiasAdmModel extends ItemsModel {
    public $table_name = 'noticias';
    public $idTable = 'idNoticia';
    public $urlName = 'noticias';
    public $form = 'insere_noticia';
    public $haveImage = true;
    public $action = false;
    public function __construct($db = false, $controller = null)
    {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
        parent::__construct($this->table_name, $this->idTable, $this->urlName, $this->form, $this->haveImage, $this->action, $this->db, $this->controller);
    }
}
?>