<?
class HomeController extends MainController{
    public function index(){
        $this->title = 'Home';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        //$modelo = $this->load_model('associacoes/imagens-adm-model');
        $this->factory->model('img');
        $modelo = $this->factory->chamarFabricas();
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH.'/views/_includes/menu.php';
        require ABSPATH.'/views/home/home-view.php';
        require ABSPATH.'/views/_includes/footer.php';
    }   
}
?>