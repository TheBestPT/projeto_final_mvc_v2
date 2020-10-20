<?php
abstract class ItemsAbstract extends MainModel{
    public $posts_por_pagina = 5;
    public function __construct($db = false, $controller = null){
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
    }

    public function obter_items() {
        //print_r($this->parametros);
        if(chk_array($this->parametros, 3) != 'soc' && chk_array($this->parametros, 3) != 'qo'){
            $this->updateItem();
        }elseif(chk_array($this->parametros, 3) == 'soc')
            $this->updateItemUrl('socios', 'idSocio', 'insere_soc', chk_array($this->parametros, 2));
        elseif(chk_array($this->parametros, 3) == 'qo')
            $this->updateItemUrl('quotas', 'idQuota', 'insere_quota', chk_array($this->parametros, 2));
    }

    public function updateItem(){
        if (chk_array($this->parametros, 0) != 'edit') {
            return;
        }

        if (!is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        // Configura o ID da projeto
        $assoc_id = chk_array($this->parametros, 1);
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST[$this->insere_form()])) {
            unset($_POST[$this->insere_form()]);

            $query = $this->db->update($this->table_name(), $this->id_table(), $assoc_id, $_POST);

            if ($query) {
                $this->form_msg = '<p class="success">projeto atualizado com sucesso!</p>';
            }
        }
        $query = $this->db->query(
            'SELECT * FROM '.$this->table_name().' WHERE '.$this->id_table().' = ? LIMIT 1', array($assoc_id)
        );
        $fetch_data = $query->fetch();

        if (empty($fetch_data)) {
            return;
        }

        $this->form_data = $fetch_data;
    }

    public function updateItemUrl($tableName, $idTable, $insere, $id){
        if (chk_array($this->parametros, 1) != 'edit') {
            return;
        }

        if (!is_numeric(chk_array($this->parametros, 2))) {
            return;
        }
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST[$insere])) {
            unset($_POST[$insere]);
            print_r($_POST);
            $query = $this->db->update($tableName, $idTable, $id, $_POST);
            if ($query) {
                $this->form_msg = '<p class="success">projeto atualizado com sucesso!</p>';
            }
        }
        $query = $this->db->query(
            'SELECT * FROM '.$tableName.' WHERE '.$idTable.' = ? LIMIT 1', array($id)
        );
        $fetch_data = $query->fetch();

        if (empty($fetch_data)) {
            return;
        }

        $this->form_data = $fetch_data;
    }

    public function listar_items(){
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

    public function insere_items(){
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST[$this->insere_form()])) {
            return;
        }
        if (chk_array($this->parametros, 0) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, 1))) {
            return;
        }
        unset($_POST[$this->insere_form()]);
        if($this->haveImage()){
            $imagem = $this->upload_imagem();
            if (!$imagem) {
                return;
            }
            // Insere a imagem em $_POST
            $_POST['imagem'] = $imagem;
        }
        $query = $this->db->insert($this->table_name(), $_POST);

        if ($query) {
            $this->form_msg = '<p class="success">Noticia atualizada com sucesso!</p>';
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }

    public function delete_items($parametros = array()){
        if(chk_array($this->parametros, 3) != 'soc' && chk_array($this->parametros, 3) != 'qo' && chk_array($this->parametros, 3) != 'img' && chk_array($this->parametros, 4) != 'ev')
            $this->delete_items_not_sepecified();
        elseif(chk_array($this->parametros, 3) == 'soc')
            $this->delete_items_url('socios', 'idSocio', chk_array($this->parametros, 3));
        elseif(chk_array($this->parametros, 3) == 'qo')
            $this->delete_items_url('quotas', 'idQuota', chk_array($this->parametros, 3));
        elseif(chk_array($this->parametros , 3) == 'img')
            $this->delete_items_url('imagem', 'idImagem', chk_array($this->parametros, 3));
        else
            $this->delete_items_url('associaeventos', 'idEvento', chk_array($this->parametros, 4));
    }

    public function delete_items_not_sepecified(){
        if(chk_array($this->parametros, 0) != 'del')
            return;

        if(!is_numeric(chk_array($this->parametros, 1)))
            return;

        if(!is_numeric(chk_array($this->parametros, 2)) != 'confirma'){
            $mensagem='<p class="alert">Tem Mesmo certeza que quer apagar o  projeto</p>';
            $mensagem.='<p><a href="'.$_SERVER['REQUEST_URI'] .'/confirma/">Sim</a> |';
            $mensagem .='<a href="'. HOME_URI .'/'.$this->url_name().'/adm">Não</a></p>';
            return $mensagem;
        }

        $projeto_id = (int) chk_array($this->parametros, 1);
        $query = $this->db->delete($this->table_name(), $this->id_table(), $projeto_id);
        //redireciona para a pagina de administrcao de projetos
        echo '<meta http-equiv="Refresh" content="0; url = '.HOME_URI.'/'.$this->url_name().'/adm">';
        echo '<script type="text/javascript">window.location.href = "'.HOME_URI.'/'.$this->url_name().'/adm/" </script>';
    }

    public function delete_items_url($tableName = "", $idTable = "", $whatDelete = ""){
        if(chk_array($this->parametros, 1) != 'del')
            return;

        if(!is_numeric(chk_array($this->parametros, 2)))
            return;
        $projeto_id = (int) chk_array($this->parametros, 2);
        switch ($whatDelete){
            case 'soc':
                $query = $this->db->delete($tableName, $idTable, $projeto_id);
                header('location: http://localhost/projeto_final/associacoes/admassoc/'.chk_array($this->parametros, 0));
                break;
            case 'qo':
                $query = $this->db->delete($tableName, $idTable, $projeto_id);
                header('location: http://localhost/projeto_final/associacoes/assocquotas/'.chk_array($this->parametros, 0));
                break;
            case 'img':
                $query = $this->db->delete($tableName, $idTable, $projeto_id);
                header('location: http://localhost/projeto_final/associacoes/admimages/'.chk_array($this->parametros, 0));
                break;
            case 'ev':
                $query = $this->db->query('DELETE FROM '.$tableName.' WHERE '.$idTable.' = '.chk_array($this->parametros, 2).' AND idAssoc = '.chk_array($this->parametros, 3));
                $query2 = $this->db->query('DELETE FROM inscricoes WHERE '.$idTable.' = '.chk_array($this->parametros, 2));
                header('location: http://localhost/projeto_final/associacoes/eventosassoc/'.chk_array($this->parametros, 0));
                break;
        }
    }

    public function getAll($table_name = ''){
        if($table_name != ''){
            $query = $this->db->query('SELECT * FROM '.$table_name);
            return $query->fetchAll();
        }
    }

    public function getSoc(){
        $query =  $this->db->query('SELECT * FROM socios');
        return $query->fetchAll();
    }

    public function getSocName($id = 0){
        $query =  $this->db->query('SELECT * FROM socios WHERE idSocio = '.$id);
        $data = $query->fetch();
        return $data['nome'];
    }


    public function paginacao(){
    }


    public function upload_imagem(){
        if(empty($_FILES['projeto_imagem']) && empty($_FILES['imagem'])){
            echo "ola5";
            return;
        }
        $imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : $_FILES['projeto_imagem'];
        $nome_imagem = strtolower($imagem['name']);
        $ext_imagem = explode('.', $nome_imagem);
        $ext_imagem = end($ext_imagem);
        $nome_imagem = preg_replace('/[^a-zA-Z0-9]/', '', $nome_imagem);
        $nome_imagem .= '_'.mt_rand().'.'.$ext_imagem;

        $tipo_imagem = $imagem['type'];
        $tmp_imagem = $imagem['tmp_name'];
        $erro_imagem = $imagem['error'];
        $tamanho_imagem = $imagem['size'];

        $permitir_tipos = array(
            'imagem/bmp',
            'image/x-windows-bmp',
            'image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/png'
        );

        if(!in_array($tipo_imagem, $permitir_tipos)){
            $this->form_msg = '<p class="error">deve enviar uma imagem nos formatos jpeg, gif, png</p>';
            return;
        }

        if(!move_uploaded_file($tmp_imagem, UP_ABSPATH.'/'.$nome_imagem)){
            $this->form_msg = '<p class="error">Erro ao enviar imagem</p>';
            return;
        }

        return $nome_imagem;
    }

    public function get_assoc(){
        $query = $this->db->query('SELECT * FROM associacao');
        return $query->fetchAll();
    }

    public function get_assoc_by_id($id = 0){
        if($id != 0) $query = $this->db->query('SELECT * FROM associacao WHERE idAssoc = '.$id);
        if(!empty($query)) {
            $data = $query->fetch();
            return $data['nome'];
        }
        return "Sem associação";
    }

    public function getSociosAssoc($id = 0){
        $query = $this->db->query('SELECT * FROM socios WHERE idAssoc = '.$id);
        return $query->fetchAll();
    }





    abstract function insere_form();

    abstract function table_name();

    abstract function id_table();

    abstract function url_name();

    abstract function haveImage();
}