<?php
verifyPath();
$id_assoc = 0;
if(chk_array($this->parametros, 0))
    $id_assoc = chk_array($this->parametros, 0);
else
    header('location: '.HOME_URI.'associacoes/adm');
$adm_uri = HOME_URI.'/associacoes/admassoc/'.$id_assoc.'/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
echo $modelo->form_confirma;
$admin_quota_uri = HOME_URI.'/associacoes/assocquotas/';
$modelo->insere_items();
$modelo->obter_items();
$modelo->delete_items();
?>
<h1>Editar Socios:</h1>
<form method="post" action="" enctype="multipart/form-data">
    <table class="form-table">
        <tr>
            <td>
                Nome: <br>
                <input type="text" name="nome" value="<? echo htmlentities(chk_array($modelo->form_data, 'nome'));?>" />
            </td>
        </tr>
        <tr>
            <td>
                Email: <br>
                <input type="text" name="email" value="<? echo htmlentities(chk_array($modelo->form_data, 'email'));?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?
                echo $modelo->form_msg;
                ?>
                <input type="submit" value="Save"/>
            </td>
        </tr>
    </table>
    <input type="hidden" name="insere_soc" value="1"/>
</form>
<a href="<? echo HOME_URI.'/noticias/adm/'.$id_assoc?>">New noticia</a>
<div class="wrap">
    <?
    $lista = $modelo->getSociosAssoc($id_assoc);
    //print_r($modelo->lista);
    ?>
    <h1>Lista de socios da associação: <? echo $modelo->get_assoc_by_id($id_assoc); ?></h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $assoc):
        //$count = 0;
        //for($modelo->first(); !$modelo->isDone();$modelo->next()):?>
            <?//echo $count++;?>
            <?//if($modelo->currentItem()['idAssoc'] == $id_assoc):?>
                <tr>
                    <td><? echo $assoc['nome'];?></td>
                    <td><? echo $assoc['email'];?></td>
                    <td>
                        <a href="<? echo $edit_uri.$assoc['idSocio'];?>" >Editar:</a>
                        &nbsp;&nbsp;
                        <a href="<? echo $delete_uri.$assoc['idSocio'];?>" >Delete:</a>
                        &nbsp;&nbsp;
                        <a href="<? echo $admin_quota_uri.$assoc['idSocio'];?>" >Quotas:</a>
                    </td>
                </tr>
            <?//endif;?>
        <? endforeach;
        //endfor;?>
        </tbody>
    </table>
</div>
