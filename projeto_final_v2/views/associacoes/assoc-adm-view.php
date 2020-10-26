<?if(!defined('ABSPATH')) exit;?>
<?
$adm_uri = HOME_URI.'/associacoes/adm/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
$admin_assoc_uri = HOME_URI.'/associacoes/admassoc/';
$admin_images_uri = HOME_URI.'/associacoes/admimages/';
$admin_assoc_eventos = HOME_URI.'/associacoes/eventosassoc/';
?>

<div class="wrap">
    <h1>Cria Associações</h1>
    <?
    echo $modelo->form_confirma;
    $modelo->insere_items();
    $modelo->obter_items();
    $modelo->delete_items();
    ?>
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
                    Morada: <br>
                    <input type="text" name="morada" value="<? echo htmlentities(chk_array($modelo->form_data, 'morada'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Numero de contribuinte: <br>
                    <input type="text" name="numContribuinte" value="<? echo htmlentities(chk_array($modelo->form_data, 'numContribuinte'));?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Telefone: <br>
                    <input type="text" name="telefone" value="<?
                    echo htmlentities(chk_array($modelo->form_data, 'telefone'));
                    ?>"/>
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
        <input type="hidden" name="insere_assoc" value="1"/>
    </form>

    <h1>Lista de Associações</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Morada</th>
            <th>Numero Contribuinte</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        <?for($modelo->first(); !$modelo->isDone();$modelo->next()):?>
            <tr>
                <td><a href="<? echo HOME_URI.'/associacoes/index/'.$modelo->currentItem()['idAssoc'];?>"><? echo $modelo->currentItem()['idAssoc'];?></a></td>
                <td><? echo $modelo->currentItem()['nome']; ?></td>
                <td><? echo $modelo->currentItem()['telefone']; ?></td>
                <td><? echo $modelo->currentItem()['morada']; ?></td>
                <td><? echo $modelo->currentItem()['numContribuinte']; ?></td>
                <td>
                    <a href="<? echo $edit_uri.$modelo->currentItem()['idAssoc'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$modelo->currentItem()['idAssoc'];?>" >Delete:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $admin_assoc_uri.$modelo->currentItem()['idAssoc'];?>" >Administrar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $admin_images_uri.$modelo->currentItem()['idAssoc'];?>" >Adicionar imagem:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $admin_assoc_eventos.$modelo->currentItem()['idAssoc'];?>" >Reutilizar eventos:</a>
                </td>
            </tr>
        <?endfor;?>
        </tbody>
    </table>
</div>