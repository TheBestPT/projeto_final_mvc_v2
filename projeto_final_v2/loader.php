<?
//EVITA QUE USER ACEDA AO FICHEIRO DIRETAMENTE
if(!defined('ABSPATH'))exit;

//inicia a sessao
session_start();

//Verifica o modo debug
if(!defined('DEBUG') || DEBUG === false){
    //esconde todos os erros
    error_reporting(0);
    ini_set("display_errors",0);
}else{
    //mostra todos os erros
    //echo "ola";
    error_reporting(E_ALL);
    ini_set("display_errors",1);
}


//Funcoes globais
require_once ABSPATH.'/functions/global-fucntions.php';

//Carrega a aplicacao
$system = new System();


?>