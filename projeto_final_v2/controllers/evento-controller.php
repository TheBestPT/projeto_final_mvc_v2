<?php
class EventoController extends MainController{
    public $login_required = true;
    public $permissions_required = 'gerir-eventos';
    public function index(){
        $this->title = "Evento";

        $modelo = $this->load_model('eventos/eventos-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/eventos/eventos-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm(){
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }
        $this->title = "Eventos ADM";
        $modelo = $this->load_model('eventos/eventos-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/eventos/eventos-adm-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>