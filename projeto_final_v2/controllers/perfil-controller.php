<?php
class PerfilController extends MainController{
    public $login_required = true;
    public $permissions_required = 'perfil';


    public function me(){
        $this->title = 'Perfil';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        print_r($parametros);
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }


        $modelo = $this->load_model('socio-register/socio-register-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/perfil/perfil-soc-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}
