<?php
verifyPath();
$id_assoc = 0;
if(chk_array($this->parametros, 0))
    $id_assoc = chk_array($this->parametros, 0);
else
    header('location: '.HOME_URI.'associacoes/adm');
$modelo->insere_items();
$modelo->delete_items();
$adm_uri = HOME_URI.'/associacoes/admimages/'.$id_assoc.'/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
?>
<h1>Escolher imagem para associção</h1>
<form method="post" action="" enctype="multipart/form-data">
    <input type="file" name="imagem" value="">
    <br>
    <input type="submit" value="Save">
    <input type="hidden" value="<? echo $id_assoc?>" name="idAssoc">
    <input type="hidden" name="insere_img" value="1">
</form>
<div class="wrap">
    <?
    $lista = $modelo->get_images_by_id($id_assoc);
    ?>
    <h1>Imagens da associação: <? echo $modelo->get_assoc_by_id($id_assoc);?></h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Imagem</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $img): ?>
            <tr>
                <td><img src="<?echo HOME_URI.'/views/_uploads/'.$img['titulo'];?>" width="300" height="300"></td>
                <td>
                    <a href="<? echo $delete_uri.$img['idImagem'];?>" >Apagar:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>

