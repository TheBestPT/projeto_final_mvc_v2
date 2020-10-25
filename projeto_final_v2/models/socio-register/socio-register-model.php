<?php
    class SocioRegisterModel{

        public $form_data;
        public $form_msg;
        public $db;
        public $posts_por_pagina = 5;

        public function __construct($db = false){
            $this->db = $db;
        }

        public function validate_register_form(){
            $this->form_data = array();
            if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST)){
                foreach($_POST as $key => $value){
                    $this->form_data[$key] = $value;
                    if(empty($value)){
                        $this->form_msg = '<p class="form_error"> There are empty fields. Data has not been sent.</p>';
                        return;
                    }
                }
            }else{
                return;
            }

            if(empty($this->form_data)){
                return;
            }

            $db_check_user = $this->db->query('SELECT * FROM `socios` WHERE `login` = ?', array(chk_array($this->form_data, 'login')));

            if(!$db_check_user){
                $this->form_msg = '<p class="form_error"> Internal error.</p>';
                return;
            }
            $imagem = $this->upload_imagem();
            if (!$imagem) {
                return;
            }
            $_POST['imagem'] = $imagem;

            $fetch_user = $db_check_user->fetch();

            $user_id = $fetch_user['idSocio'];

            $password_hash = new PasswordHash(8, FALSE);

            $password = $password_hash->HashPassword($this->form_data['password']);
            if(preg_match('/[^0-9A-Za-z\,\.\-\_\S]/is',$this->form_data['socio_permissions'])){
                $this->form_msg = '<p class="form_error"> Use just letters, numbers and a comma for permissions</p>';
                return;
            }

            $permissions = array_map('trim',explode(',', $this->form_data['socio_permissions']));

            $permissions = array_unique($permissions);

            $permissions = array_filter($permissions);

            $permissions = serialize($permissions);



            if($user_id){
                $query = $this->db->update('socios','idSocio',$user_id,array(
                    'password' => $password,
                    'email' => chk_array($this->form_data, 'email'),
                    'login' => chk_array($this->form_data, 'login'),
                    'nome' => chk_array($this->form_data,'nome'),
                    'socio_session_id' => md5(time()),
                    'socio_permissions' => $permissions,
                    'idAssoc' => chk_array($this->form_data,'idAssoc')
                    ));

                if(!$query){
                    $this->form_msg = '<p class="form_error"> Internal Error. Data has not been sent.</p>';
                    return;
                }else{
                    $this->form_msg = '<p class="form_success"> User successfully updated.</p>';
                    return;
                }

            }else{
                //print_r($_POST);
                $query = $this->db->insert('socios', array(
                    'login' => chk_array($this->form_data,'login'),
                    'password' => $password,
                    'email' => chk_array($this->form_data, 'email'),
                    'nome' => chk_array($this->form_data,'nome'),
                    'imagem' => $imagem,
                    'socio_session_id' => md5(time()),
                    'socio_permissions' => $permissions,
                    'idAssoc' => chk_array($this->form_data,'idAssoc')
                    ));

                if(!$query){
                    $this->form_msg = '<p class="form_error"> Internal Error. Data has not been sent.</p>';
                    return;
                }else{
                    $this->form_msg = '<p class="form_success"> User successfully created.</p>';
                    return;
                }
                
            }
        }

        public function get_register_form($user_id = false){
            $s_user_id = false;

            if(!empty($user_id)){
                $s_user_id = (int) $user_id;
            }

            if(empty($s_user_id)){
                return;
            }

            $query = $this->db->query('SELECT * FROM `socios` WHERE `idSocio` = ?', array($s_user_id));

            if(!$query){
                $this->form_msg = '<p class="form_error"> User não existe. </p>';
                return;
            }

            $fetch_userdata = $query->fetch();

            if(empty($fetch_userdata)){
                $this->form_msg = '<p class="form_error"> User do not exists. </p>';
                return;
            }

            foreach($fetch_userdata as $key => $value){
                $this->form_data[$key] = $value;
            }

            $this->form_data['password'] = null;

            $this->form_data['socio_permissions'] = unserialize($this->form_data['socio_permissions']);

            $this->form_data['socio_permissions'] = implode(',', $this->form_data['socio_permissions']);
            
        }


        
        public function del_user($parametros = array()){

            $user_id = null;

            if(chk_array($parametros, 0) == 'del'){
                echo '<p class="alert"> Tem certeza que deseja apagar este registo? </p>';
                echo '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma"> Sim</a> | <a href="' . HOME_URI . '/socio-register">Não</a></p>';

                if(is_numeric(chk_array($parametros, 1)) && chk_array($parametros, 2) == 'confirma'){
                    $user_id = chk_array($parametros, 1);
                }
            }

            if(!empty($user_id)){
                $user_id = (int) $user_id;

                $query = $this->db->delete('socios', 'idSocio', $user_id);

                echo '<script type="text/javascript">window.location.href="' . HOME_URI . '/socio-register/";</script>';
                return;
            }
        }

        public function get_user_list(){
            $query = $this->db->query('SELECT * FROM `socios` ORDER BY idSocio DESC');
            if (!$query){
                return array();
            }
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

        public function get_assoc(){
            $query = $this->db->query('SELECT * FROM associacao');
            return $query->fetchAll();
        }

        public function get_soc_by_id($id = 0){
            $query = $this->db->query('SELECT * FROM socios WHERE idSocio = '.$id);
            return $query->fetch();
        }

        public function getQuotas($id = 0){
            if($id!=0){
                $query = $this->db->query('SELECT * FROM quotas WHERE idSocio = '.$id);
                return $query->fetchAll();
            }
        }

        public function getSocName($id = 0){
            $query =  $this->db->query('SELECT * FROM socios WHERE idSocio = '.$id);
            $data = $query->fetch();
            return $data['nome'];
        }

        public function pay($parametros = array()){

            $idQuota = null;

            if(chk_array($parametros, 1) == 'pay'){
                if(is_numeric(chk_array($parametros, 2))){
                    $idQuota = chk_array($parametros, 2);
                }
            }

            if(!empty($idQuota)){
                $idQuota = (int) $idQuota;

                $query = $this->db->update('quotas', 'idQuota', $idQuota, array("pago" => 1));

                header('location: '.HOME_URI.'/perfil/me/'.chk_array($parametros, 0));
                return;
            }
        }

        public function cancelarEvento($parametros = array()){

            $idEvento = null;
            $idSoc = null;
            if(chk_array($parametros, 1) == 'can'){
                if(is_numeric(chk_array($parametros, 2))){
                    $idEvento = chk_array($parametros, 2);
                    $idSoc = chk_array($parametros, 0);
                }
            }

            if(!empty($idEvento) && !empty($idSoc)){
                $idEvento = (int) $idEvento;
                $idSoc = (int) $idSoc;
                    $query = $this->db->query('DELETE FROM inscricoes WHERE idEvento = '.$idEvento.' AND idSocio = '.$idSoc);

                header('location: '.HOME_URI.'/perfil/me/'.chk_array($parametros, 0));
                return;
            }
        }

        public function listar_eventos($parametros = array()){
            $id = $where = $query_limit = null;

            if (is_numeric(chk_array($parametros, 0))) {

                $id = array(chk_array($parametros, 0));

                $where = " WHERE a.idAssoc = ? ";
            }

            $pagina = !empty($parametros[1]) ? $parametros[1] : 1;
            $pagina--;

            $posts_por_pagina = $this->posts_por_pagina;

            $offset = $pagina * $posts_por_pagina;
            if (empty($this->sem_limite)) {
                $query_limit = " LIMIT $offset,$posts_por_pagina ";
            }

            $query = $this->db->query('SELECT a.idAssoc, e.idAssoc, e.idEvento, k.idEvento, k.titulo, k.evento, k.imagem, s.idAssoc, i.idEvento, i.idSocio FROM socios s INNER JOIN associacao a ON s.idAssoc = a.idAssoc INNER JOIN associaeventos e ON a.idAssoc = e.idAssoc INNER JOIN eventos k ON e.idEvento = k.idEvento INNER JOIN inscricao i ON k.idEvento = i.idEvento' . $where . ' ORDER BY s.idAssoc DESC ' . $query_limit, $id);

            return $query->fetchAll();
        }

        public function get_id_incricao($id){
            $query = $this->db->query('SELECT * FROM inscricoes WHERE idSocio = '.$id);
            return $query->fetchAll();
        }

        public function get_id_evento($id){
            $query = $this->db->query('SELECT * FROM eventos WHERE idEvento = '.$id);
            return $query->fetchAll();
        }


        public function upload_imagem(){
            if(empty($_FILES['projeto_imagem']) && empty($_FILES['imagem'])){
                echo "ola";
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


    }
?>