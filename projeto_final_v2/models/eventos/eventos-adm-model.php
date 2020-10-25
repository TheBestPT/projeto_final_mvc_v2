<?php
class EventosAdmModel extends ItemsModel implements IteratorInterface {

    public $table_name = 'eventos';
    public $idTable = 'idEvento';
    public $urlName = 'evento';
    public $form = 'insere_evento';
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

    public function list_by_id_eventos_assoc($id = 0){
        if($id != 0){
            $query = $this->db->query('SELECT * FROM associaeventos WHERE idEvento = '.$id);
            return $query->fetchAll();
        }
    }

    public function list_by_id_eventos($id){
        if($id != 0){
            $query = $this->db->query('SELECT * FROM associacao WHERE idAssoc = '.$id);
            return $query->fetchAll();
        }
        return false;
    }
    public function insere_evento(){
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['insere_evento'])) {
            return;
        }
        if (chk_array($this->parametros, 0) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, 1))) {
            return;
        }
        unset($_POST['insere_evento']);
        //print_r($_POST);
        $query = $this->db->insert('associaeventos', $_POST);
        //print_r($_POST);
        $socios = $this->getSociosAssoc($_POST['idAssoc']);
        //print_r($socios);
        foreach ($socios as $item){
            $evento = $_POST['idEvento'];
            $query2 = $this->db->query('INSERT INTO inscricoes (idEvento, idSocio) VALUES ('.$evento.', '.$item['idSocio'].')');
        }

        if ($query && $query2) {
            $this->form_msg = '<p class="success">Evento atualizada com sucesso!</p>';
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
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
