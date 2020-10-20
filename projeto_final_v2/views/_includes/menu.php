<?
if(!defined('ABSPATH'))exit;
?>
<?
//if($this->login_required && !$this->logged_in)
     //return;
if($this->logged_in){
    echo "BemVindo: ".$this->user_name;
?>
<a href="<?echo HOME_URI;?>/login/delete">Logout</a>
<?}else{?>
<a href="<?echo HOME_URI;?>/login">Login</a>
<?}?>

<nav class="menu clearfix">
    <ul>
        <li><a href="<?echo HOME_URI;?>">Home</a></li>
        <li><a href="<?echo HOME_URI;?>/associacoes/">Associacoes</a></li>
        <li><a href="<?echo HOME_URI;?>/associacoes/adm">Associacoes Adm</a></li>
        <li><a href="<?echo HOME_URI;?>/noticias">Noticias</a></li>
        <li><a href="<?echo HOME_URI;?>/noticias/adm">Noticias Admin</a></li>
        <li><a href="<?echo HOME_URI;?>/evento">Eventos</a></li>
        <li><a href="<?echo HOME_URI;?>/evento/adm">Eventos Adm</a></li>
        <li><a href="<?echo HOME_URI;?>/socio-register">Register socio</a></li>
        <li><a href="<?echo HOME_URI;?>/perfil/me/<? echo $this->id_soc;?>">Perfil</a></li>
    </ul>
</nav>