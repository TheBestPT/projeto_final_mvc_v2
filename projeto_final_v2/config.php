<?
//Configuracao geral
//caminho para a rais
define('ABSPATH', dirname(__FILE__));

//caminho para a pasta de _uploads
define('UP_ABSPATH', ABSPATH.'/views/_uploads');

//URL da home
define('HOME_URI', 'http://localhost/projeto_final');

//Nome do host da base de dados
define('HOSTNAME', 'localhost');

//Nome da BD
define('DB_NAME', 'projeto_final_mvc');

//Utilizador do BD
define('DB_USER', 'root');

//Password da conexão PDO
define('DB_PASSWORD', '');

//Charset da conexão PDO
define('DB_CHARSET', 'utf8');

//Desenvolvedor, modifique o valor para true
define('DEBUG', true);

//Carrega o loader, que vai carregar a aplicacao inteira
require_once ABSPATH.'/loader.php';
?>