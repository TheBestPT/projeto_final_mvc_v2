<?
class SocioRegisterController extends MainController{
    public $login_required = true;
    public $permissions_required = 'gerir-socios';
    public function index(){
        $this->title = 'Socio Register';
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }

        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();
        //$modelo = $this->load_model('socio-register/socio-register-model');
        $this->factory->model('user');
        $modelo = $this->factory->chamarFabricas();
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/socio-register/socio-register-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>