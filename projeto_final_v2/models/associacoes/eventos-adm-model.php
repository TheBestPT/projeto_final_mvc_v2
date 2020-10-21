<?php
class EventosAdmModel extends ItemsModel
{
    public $table_name = 'eventos';
    public $idTable = 'idEvento';
    public $urlName = 'eventosassoc';
    public $form = 'insere_even';
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

    public function get_eventos_nome(){
        $query = $this->db->query('SELECT * FROM eventos');
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
        $query = $this->db->query('SELECT a.idAssoc, e.idAssoc, e.idEvento, k.idEvento, k.titulo, k.evento, k.imagem FROM associacao a INNER JOIN associaeventos e ON a.idAssoc = e.idAssoc INNER JOIN eventos k ON e.idEvento = k.idEvento '.$where.' ORDER BY a.idAssoc DESC '.$query_limit, $id);
        return $query->fetchAll();
    }
}