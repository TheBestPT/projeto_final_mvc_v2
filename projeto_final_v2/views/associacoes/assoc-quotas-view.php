<?php
verifyPath();
$id_soc = 0;
if(chk_array($this->parametros, 0))
    $id_soc = chk_array($this->parametros, 0);
else
    header('location: '.HOME_URI.'associacoes/adm');
$adm_uri = HOME_URI.'/associacoes/assocquotas/'.$id_soc.'/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
$modelo->insere_items();
$modelo->obter_items();
$modelo->delete_items();
?>
<h1>Criar e editar quotas:</h1>
<form method="post" action="" enctype="multipart/form-data">
    <table class="form-table">
        <tr>
            <td>
                Preco: <br>
                <input type="text" name="preco" value="<? echo htmlentities(chk_array($modelo->form_data, 'preco'));?>" />
            </td>
        </tr>
        <tr>
            <td>
                Data Comeco: <br>
                <input name="dataComeco" type="text" value="<? echo htmlentities(chk_array($modelo->form_data, 'dataComeco')); ?>">
            </td>
        </tr>
        <tr>
            <td>
                Data Termino: <br>
                <input name="dataTermino" type="text" value="<? echo htmlentities(chk_array($modelo->form_data, 'dataTermino')); ?>">
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
    <input type="hidden" name="idSocio" value="<? echo $id_soc;?>">
    <input type="hidden" name="insere_quota" value="1"/>
</form>

<div class="wrap">
    <?
    $lista = $modelo->getQuotas($id_soc);
    ?>
    <h1>Lista de quotas da associação: <? echo $modelo->getSocName($id_soc) ?></h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Preço</th>
            <th>Data Comeco</th>
            <th>Data Termino</th>
            <th>Pagamento</th>
            <th>Edit Quotas</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $quotas): ?>
            <tr>
                <td><? echo $quotas['preco'];?></td>
                <td><? echo $quotas['dataComeco'];?></td>
                <td><? echo $quotas['dataTermino'];?></td>
                <td><? if($quotas['pago'] == 0) echo "Não pago"; else echo "Pago";?></td>
                <td>
                    <a href="<? echo $edit_uri.$quotas['idQuota'];?>" >Editar:</a>
                    &nbsp;&nbsp;
                    <a href="<? echo $delete_uri.$quotas['idQuota'];?>" >Delete:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>


