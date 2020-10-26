<?php
class ItemsModel extends MainModel implements IteratorInterface {
    public $posts_por_pagina = 5;

    public $table_name;
    public $idTable;
    public $urlName;
    public $form;
    public $haveImage;
    public $action;
    public function __construct($table_name, $idTable, $urlName, $form, $haveImage, $action, $db = false, $controller = null)
    {
        $this->table_name = $table_name;
        $this->idTable = $idTable;
        $this->urlName = $urlName;
        $this->form = $form;
        $this->haveImage = $haveImage;
        $this->action = $action;
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
    }

    public function obter_items() {
        $param = ($this->action) ? 1 : 0;
        if (chk_array($this->parametros, $param) != 'edit')
            return;

        if (!is_numeric(chk_array($this->parametros, ++$param)))
            return;

        $id = chk_array($this->parametros, $param);
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST[$this->form])) {
            unset($_POST[$this->form]);
            $query = $this->db->update($this->table_name, $this->idTable, $id, $_POST);
            if ($query) {
                $this->form_msg = '<p class="success">Item atualizado com sucesso!</p>';
                echo '<meta http-equiv="Refresh" content="0; url = '.HOME_URI.'/'.$this->urlName.'">';
                echo '<script type="text/javascript">window.location.href = "'.HOME_URI.'/'.$this->urlName.'</script>';
            }
        }
        $query = $this->db->query(
            'SELECT * FROM '.$this->table_name.' WHERE '.$this->idTable.' = ? LIMIT 1', array($id)
        );
        $fetch_data = $query->fetch();
        if (empty($fetch_data)) {
            return;
        }

        $this->form_data = $fetch_data;

    }

    public function listar_items(){
        $param = ($this->action) ? 1 : 0;
        $id = $where = $query_limit = null;
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(is_numeric(chk_array($this->parametros, 0)) && strpos($actual_link, 'index')){
            $id = array(chk_array($this->parametros, 0));
            $where = ' WHERE '.$this->idTable.' = ? ';
        }
        //nao fiz paginacao por isso e inutil
        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;
        $pagina--;
        $posts_por_pagina = $this->posts_por_pagina;
        $offset = $pagina * $posts_por_pagina;
        if(empty($this->sem_limite)){
            $query_limit = " LIMIT $offset, $posts_por_pagina ";
        }
        if($where != '')
            $query = $this->db->query('SELECT * FROM '.$this->table_name.' ' . $where . ' ORDER BY '.$this->idTable.' DESC' . $query_limit, $id);
        else
            $query = $this->db->query('SELECT * FROM '.$this->table_name.' ' . $where . ' ORDER BY '.$this->idTable.' DESC');
        return $query->fetchAll();

    }

    public function insere_items(){
        $param = ($this->action) ? 1 : 0;
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST[$this->form])) {
            return;
        }
        if (chk_array($this->parametros, $param) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, ++$param))) {
            return;
        }
        unset($_POST[$this->form]);
        if($this->haveImage){
            $imagem = $this->upload_imagem();
            if (!$imagem) {
                return;
            }
            // Insere a imagem em $_POST
            $_POST['imagem'] = $imagem;
        }
        foreach($_POST as $key => $value){
            if(empty($value)){
                $this->form_msg = '<p class="form_error"> There are empty fields. Data has not been sent.</p>';
                return;
            }
        }
        $query = $this->db->insert($this->table_name, $_POST);

        if ($query) {
            $this->form_msg = '<p class="success">Item atualizado com sucesso!</p>';
            header("Refresh:0");
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }

    public function delete_items(){
        $param = ($this->action) ? 1 : 0;
        //echo $param;
        if(chk_array($this->parametros, $param) != 'del'){
            return;
        }

        if(!is_numeric(chk_array($this->parametros, ++$param)))
            return;
        $projeto_id = (int) chk_array($this->parametros, $param);
        $query = $this->db->delete($this->table_name, $this->idTable, $projeto_id);
        echo '<meta http-equiv="Refresh" content="0; url = '.HOME_URI.'/'.$this->urlName.'">';
        echo '<script type="text/javascript">window.location.href = "'.HOME_URI.'/'.$this->urlName.'</script>';

    }

    public function getAll($table_name = ''){
        if($table_name != ''){
            $query = $this->db->query('SELECT * FROM '.$table_name);
            return $query->fetchAll();
        }
        return [];
    }

    public function getSoc(){
        $query =  $this->db->query('SELECT * FROM socios');
        return $query->fetchAll();
    }

    public function getSocName($id = 0){
        if($id != 0){
            $query =  $this->db->query('SELECT * FROM socios WHERE idSocio = '.$id);
            $data = $query->fetch();
            return $data['nome'];
        }
        return [];
    }


    public function paginacao(){
    }

    public function getItem($tableName = "", $idTable = 0, $idConfirm  =0){
            //if($tableName != "" && $idTable != 0 && $idConfirm != 0){
                $query = $this->db->query('SELECT * FROM '.$tableName.' WHERE '.$idTable.' = '.$idConfirm);
                //echo 'SELECT * FROM '.$tableName.' WHERE '.$idTable.' = '.$idConfirm;
                //print_r($query->fetchAll());
                return $query->fetchAll();
            //}
    }
    public function upload_imagem(){
        if(empty($_FILES['projeto_imagem']) && empty($_FILES['imagem'])){
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
        if($id != 0){
            $query = $this->db->query('SELECT * FROM socios WHERE idAssoc = '.$id);
            return $query->fetchAll();
        }
        return [];
    }

    public function notAction(){
        $this->action = ($this->action) ? false : true;
        return $this->action;
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
