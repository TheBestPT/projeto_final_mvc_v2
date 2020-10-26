<?php
class ImagensAdmModel extends ItemsModel
{
    public $table_name = 'imagem';
    public $idTable = 'idImagem';
    public $urlName = 'associacoes/admimages';
    public $form = 'insere_img';
    public $haveImage = true;
    public $action = true;

    public function __construct($db = false, $controller = null)
    {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
        parent::__construct($this->table_name, $this->idTable, $this->urlName, $this->form, $this->haveImage, $this->action, $this->db, $this->controller);
    }

    public function get_images_by_id($id = 0){
        if($id!=0){
            $query = $this->db->query('SELECT * FROM imagem WHERE idAssoc = '.$id);
            return $query->fetchAll();
        }
        return [];
    }


}