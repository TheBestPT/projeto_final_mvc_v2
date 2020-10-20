<?php
class AssociacoesAdmModel extends ItemsAbstract {
    function insere_form()
    {
        return 'insere_assoc';
    }

    function table_name()
    {
        return 'associacao';
    }

    function id_table()
    {
        return 'idAssoc';
    }

    function url_name()
    {
        return 'associacoes';
    }

    function haveImage()
    {
        return false;
    }

    public function listarQuotas(){
        $id = $where = $query_limit = null;

        if(is_numeric(chk_array($this->parametros, 0))){
            $id = array(chk_array($this->parametros, 0));
            $where = ' WHERE idQuota = ? ';
        }

        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;
        $pagina--;
        $posts_por_pagina = $this->posts_por_pagina;
        $offset = $pagina * $posts_por_pagina;
        if(empty($this->sem_limite)){
            $query_limit = " LIMIT $offset, $posts_por_pagina ";
        }

        $query = $this->db->query('SELECT * FROM quotas ' . $where . ' ORDER BY idQuota DESC' . $query_limit, $id);
        return $query->fetchAll();
    }

    public function obterQuotasById($id = 0, $str = ""){
        $query = "";
        if($id!=0){
            $query = $this->db->query('SELECT * FROM quotas WHERE idSocio = '.$id);
            $data = $query->fetch();
            return $data[$str];
        }
        return 'Sem quotas';
    }

    public function inserir_quotas(){
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['insere_quota'])) {
            return;
        }
        if (chk_array($this->parametros, 1) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, 2))) {
            return;
        }
        //print_r($_POST);
        unset($_POST['insere_quota']);
        //print_r($dados);
        $query = $this->db->insert('quotas', $_POST);

        if ($query) {
            $this->form_msg = '<p class="success">Quota atualizada com sucesso!</p>';
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }

    public function inserir_img(){
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['insere_img'])) {
            return;
        }
        if (chk_array($this->parametros, 0) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, 1))) {
            return;
        }
        $imagem = $this->upload_imagem();
        if (!$imagem) {
            return;
        }
        unset($_POST['insere_img']);
        print_r($_POST);
        $_POST['titulo'] = $imagem;
        print_r($_POST);
        $query = $this->db->insert('imagem', $_POST);

        if ($query) {
            $this->form_msg = '<p class="success">Imagem atualizada com sucesso!</p>';
            header('location: '.HOME_URI.'/associacoes/admimages/'.$_POST['idAssoc']);
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }

    public function getQuotas($id = 0){
        if($id!=0){
            $query = $this->db->query('SELECT * FROM quotas WHERE idSocio = '.$id);
            return $query->fetchAll();
        }
    }

    public function get_images_by_id($id = 0){
        if($id!=0){
            $query = $this->db->query('SELECT * FROM imagem WHERE idAssoc = '.$id);
            return $query->fetchAll();
        }
    }
}
?>