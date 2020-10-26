<?if(!defined('ABSPATH')) exit;?>

<?
$asso = false;
if(is_numeric(chk_array($this->parametros, 0))){
    $id_assoc = chk_array($this->parametros, 0);
    $asso = $modelo->notAction();
    $adm_uri = HOME_URI.'/noticias/adm/'.$id_assoc.'/';
    $modelo->urlName .= '/'.$id_assoc.'/';
    //echo $modelo->action;
}else{
    $adm_uri = HOME_URI.'/noticias/adm/';
}
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
?>

<div class="wrap">
    <?
    $modelo->insere_items();
    $modelo->obter_items();
    $modelo->delete_items();
    ?>
    <h1>Criar e editar noticias:</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
                    Título: <br>
                    <input type="text" name="titulo" value="<? echo htmlentities(chk_array($modelo->form_data, 'titulo'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Notícia: <br>
                    <textarea name="noticia"><? echo htmlentities(chk_array($modelo->form_data, 'noticia'));?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Imagem: <br>
                    <input type="file" name="imagem" value=""/>
                </td>
            </tr>
            <tr>
                <? if(!$asso): ?>
                <td>
                    <label for="idAssoc">Escolhe a associação:</label>
                    <select name="idAssoc" id="idAssoc">
                        <?
                        $list_assoc = $modelo->get_assoc();
                        foreach ($list_assoc as $item):
                            ?>
                            <option name ="idAssocItem" value="<? echo htmlentities($item['idAssoc']); ?>"><? echo htmlentities($item['nome']); ?></option>
                        <? endforeach; ?>
                    </select>
                </td>
                <? else: ?>
                    <input type="hidden" name="idAssoc" value="<?echo $id_assoc;?>">
                <?endif;?>
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
        <input type="hidden" name="insere_noticia" value="1"/>
    </form>

    <?
    if ($asso) $modelo->lista = $modelo->getNoticiasById($id_assoc);
    ?>
    <h1>Lista de Noticias</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Noticia</th>
            <th>Imagem</th>
            <th>Associação</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>

        <? for($modelo->first(); !$modelo->isDone();$modelo->next()): ?>
            <tr>
                <td><a href="<? echo HOME_URI.'/noticias/index/'.$modelo->currentItem()['idNoticia'];?>"><? echo $modelo->currentItem()['idNoticia'];?></a></td>
                <td><? echo $modelo->currentItem()['titulo'];?></td>
                <td><? echo $modelo->currentItem()['noticia'];?></td>
                <td>
                    <p>
                        <img src="<?echo HOME_URI.'/views/_uploads/'.$modelo->currentItem()['imagem'];?>" width="30px">
                    </p>
                </td>
                <td><?php echo $modelo->get_assoc_by_id($modelo->currentItem()['idAssoc']);?></td>
                <td>
                    <a href="<? echo $edit_uri.$modelo->currentItem()['idNoticia'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$modelo->currentItem()['idNoticia'];?>" >Delete:</a>
                </td>
            </tr>
        <? endfor;?>
        </tbody>
    </table>
</div>