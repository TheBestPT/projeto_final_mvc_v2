<?php
class FabricaModels implements FactoryMethod{
    public $model;
    public $db;
    public $controller;
    /*public function __construct($model = 'assoc'){
        $this->model = $model;
    }*/
    public function __construct($db = false, $controller = null)
    {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
    }

    public function chamarFabricas()
    {
        $model = null;
        switch ($this->model){
            case 'assoc_adm':
                $model = $this->load_model('associacoes/associacoes-adm-model');
                break;
            case 'sepecify_adm':
                $model = $this->load_model('associacoes/socios-adm-model');
                break;
        }
        return $model;
    }

    public function model($model){
        $this->model = $model;
    }

    public function load_model($model_name = false) {
        // Um ficheiro deverá ser enviado
        if (!$model_name)
            return;
        // Garante que o nome do modelo tenha letras minúsculas
        $model_name = strtolower($model_name);
        // Inclui o ficheiro
        $model_path = ABSPATH . '/models/' . $model_name . '.php';
        // Verifica se o ficheiro existe
        if (file_exists($model_path)) {
            // Inclui o ficheiro
            require_once $model_path;
            // Remove os caminhos do ficheiro (se tiver algum)
            $model_name = explode('/', $model_name);
            // Captura o final do caminho(nome do modelo)
            $model_name = end($model_name);
            // Remove caracteres inválidos do nome do ficheiro
            $model_name = preg_replace('/[^a-zA-Z0-9]/is', '', $model_name);
            // Verifica se a classe existe
            if (class_exists($model_name)) {
                // Retorna um objeto da classe
                return new $model_name($this->db, $this);
            }
            return;
        } // load_model
    }
}
