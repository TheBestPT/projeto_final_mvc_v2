<?
class AssociacoesController extends MainController{
    public $login_required = true;
    public $permissions_required = 'gerir-assoc';
    public function index(){
        $this->title = 'Associacoes';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        $modelo = $this->load_model('associacoes/associacoes-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/associacoes/assoc_view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm(){
        $this->title = 'Associacoes Adm';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }
        $modelo = $this->load_model('associacoes/associacoes-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/associacoes/assoc-adm-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function admassoc(){
        $this->title = 'Associacoes Specify Adm';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }
        $modelo = $this->load_model('associacoes/socios-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/associacoes/assoc_adm_specified_view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function assocquotas(){
        $this->title = 'Quotas';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }
        $modelo = $this->load_model('associacoes/quotas-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/associacoes/assoc-quotas-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function admimages(){
        $this->title = 'Associacoes Imagens';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }
        $modelo = $this->load_model('associacoes/imagens-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/associacoes/image_adm_view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function eventosassoc(){
        $this->title = 'Associacoes Eventos';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }
        $modelo = $this->load_model('associacoes/eventos-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/associacoes/eventos-assoc-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>