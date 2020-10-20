<?php
class EventosAdmModel extends ItemsAbstract{

    function insere_form()
    {
        return 'insere_evento';
    }

    function table_name()
    {
        return 'eventos';
    }

    function id_table()
    {
        return 'idEvento';
    }

    function url_name()
    {
        return 'evento';
    }

    function haveImage()
    {
        return true;
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

    /*public function listar_eventos(){//nao funciona e o codigo esta exatamente igual
        $id = $where = $query_limit = null;

        if(is_numeric(chk_array($this->parametros, 0))){
            $id = array(chk_array($this->parametros, 0));
            $where = ' WHERE a.idAssoc = ? ';
        }
        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;
        $pagina--;
        $posts_por_pagina = $this->posts_por_pagina;
        $offset = $pagina * $posts_por_pagina;
        if(empty($this->sem_limite)){
            $query_limit = " LIMIT $offset, $posts_por_pagina ";
        }
        $query = $this->db->query('SELECT a.idAssoc, e.idAssoc, e.idEvento, k.idEvento, k.titulo, k.evento FROM associacao a INNER JOIN associaeventos e ON a.idAssoc = e.idAssoc INNER JOIN eventos k ON e.idEvento = k.idEvento '.$where.' ORDER BY a.idAssoc DESC '.$query_limit, $id);
        print_r($query->fetchAll());
        $data = $query->fetchAll();
        return $data;
    }*/

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
        return "Sem associação";
    }

    public function get_eventos_nome(){
        $query = $this->db->query('SELECT * FROM eventos');
        return $query->fetchAll();
    }

    public function insere_evento(){
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['insere_even'])) {
            return;
        }
        if (chk_array($this->parametros, 0) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, 1))) {
            return;
        }
        unset($_POST['insere_even']);
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


}
