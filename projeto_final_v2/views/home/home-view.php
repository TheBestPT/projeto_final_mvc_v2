<?
if(!defined('ABSPATH')) exit;
$assoc = $modelo->getAll('associacao');
?>

<div class="wrap">
    <h1>Imagens das nossas associções:</h1>
    <? foreach ($assoc as $name):?>
        <p>Imagem por: <? echo $name['nome'];?></p>
        <?$lista = $modelo->get_images_by_id($name['idAssoc']);?>
        <? foreach ($lista as $img):?>
            <img src="<?echo HOME_URI.'/views/_uploads/'.$img['imagem'];?>" width="300" height="300">
        <? endforeach;?>
    <? endforeach;?>
</div>