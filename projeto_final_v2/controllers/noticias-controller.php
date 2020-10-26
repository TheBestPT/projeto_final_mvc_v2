<?php
class NoticiasController extends MainController{
    public $login_required = true;
    public $permissions_required = 'gerir-noticias';
    public function index(){
        $this->title = "Noticias";

        $this->factory->model('noticias');
        $modelo = $this->factory->chamarFabricas();
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/noticias/noticias_view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm(){
        $this->title = "Noticias ADM";
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }
        $this->factory->model('noticias');
        $modelo = $this->factory->chamarFabricas();
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/noticias/noticias-adm-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>
