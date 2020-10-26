<?php
class EventosAssocModel extends ItemsModel{

    public $table_name = 'eventos';
    public $idTable = 'idEvento';
    public $urlName = 'evento';
    public $form = 'insere_evento';
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

    public function get_assoc_by_id_evento(){
        $id = $where = $query_limit = null;

        if(is_numeric(chk_array($this->parametros, 0))){
            $id = array(chk_array($this->parametros, 0));
            $where = ' WHERE '.$this->id_table().' = ? ';
        }

        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;
        $pagina--;
        $posts_por_pagina = $this->posts_por_pagina;
        $offset = $pagina * $posts_por_pagina;
        if(empty($this->sem_limite)){
            $query_limit = " LIMIT $offset, $posts_por_pagina ";
        }

        $query = $this->db->query('SELECT * FROM '.$this->table_name().' ' . $where . ' ORDER BY '.$this->id_table().' DESC' . $query_limit, $id);
        return $query->fetchAll();
    }

    public function listar_eventos(){
        $id = $where = $query_limit = null;

        if (is_numeric(chk_array($this->parametros, 0))) {
            $id = array(chk_array($this->parametros, 0));
            $where = " WHERE a.idAssoc = ? ";
        }
        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;
        $pagina--;
        $posts_por_pagina = $this->posts_por_pagina;
        $offset = $pagina * $posts_por_pagina;
        if (empty($this->sem_limite)) {
            $query_limit = " LIMIT $offset,$posts_por_pagina ";
        }
        $query = $this->db->query('SELECT a.idAssoc, e.idAssoc, e.idEvento, k.idEvento, k.titulo, k.evento, k.imagem, k.dataComeco, k.dataTermino FROM associacao a INNER JOIN associaeventos e ON a.idAssoc = e.idAssoc INNER JOIN eventos k ON e.idEvento = k.idEvento '.$where.' ORDER BY a.idAssoc DESC '.$query_limit, $id);
        return $query->fetchAll();
    }

    public function list_by_id_eventos_assoc($id = 0){
        if($id != 0){
            $query = $this->db->query('SELECT * FROM associaeventos WHERE idEvento = '.$id);
            return $query->fetchAll();
        }
        return [];
    }

    public function list_by_id_eventos($id){
        if($id != 0){
            $query = $this->db->query('SELECT * FROM associacao WHERE idAssoc = '.$id);
            return $query->fetchAll();
        }
        return "Sem associação";
    }

    public function get_eventos_nome(){
        $query = $this->db->query('SELECT * FROM eventos');
        return $query->fetchAll();
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
        $query = $this->db->insert('associaeventos', $_POST);
        $socios = $this->getSociosAssoc($_POST['idAssoc']);

        if ($query) {
            $this->form_msg = '<p class="success">Evento atualizada com sucesso!</p>';
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }

    public function delEvento(){
        if(chk_array($this->parametros, 1) != 'del')
            return;

        if(!is_numeric(chk_array($this->parametros, 2)))
            return;
        $query = $this->db->query('DELETE FROM associaeventos WHERE '.$this->idTable.' = '.chk_array($this->parametros, 2).' AND idAssoc = '.chk_array($this->parametros, 3));
        $query2 = $this->db->query('DELETE FROM inscricoes WHERE '.$this->idTable.' = '.chk_array($this->parametros, 2));
        header('location: http://localhost/projeto_final_v2/associacoes/eventosassoc/'.chk_array($this->parametros, 0));
    }
}
