<?php
if(!defined('ABSPATH')) exit;
$id_assoc = 0;
if(is_numeric(chk_array($this->parametros, 0)))
    $id_assoc = chk_array($this->parametros, 0);
else
    header('location: '.HOME_URI.'associacoes/adm');
$adm_uri = HOME_URI.'/associacoes/eventosassoc/'.$id_assoc.'/';
$edit_uri = $adm_uri.'edit/';
$delete_uri = $adm_uri.'del/';
$modelo->insere_evento();
$modelo->delEvento();
?>
<h1>Reutilizar um evento ja existente</h1>
<form method="post" action="" enctype="multipart/form-data">
    <tr>
        <td>
            <label for="idEvento">Escolhe o evento:</label>
            <select name="idEvento" id="idEvento">
                <?
                $lista_event = $modelo->get_eventos_nome();
                foreach ($lista_event as $item):
                    ?>
                    <option name ="idEventoItem" value="<? echo htmlentities($item['idEvento']); ?>"><? echo htmlentities($item['titulo']); ?></option>
                <? endforeach; ?>
            </select>
        </td>

    </tr>


    <tr>
        <td><input type="submit" value="Save"></td>
        <input type="hidden" value="1" name="insere_evento">
        <input type="hidden" value="<? echo $id_assoc;?>" name="idAssoc">
    </tr>

</form>
<div class="wrap">
    <?
    $lista = $modelo->listar_eventos();
    ?>
    <h1>Lista de Eventos da associção <? echo $modelo->get_assoc_by_id($id_assoc); ?></h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Evento</th>
            <th>Data Comeco</th>
            <th>Data Termino</th>
            <th>Imagem</th>
            <th>Edicao</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $evento):?>
            <tr>
                <td><a href="<? echo HOME_URI.'/evento/index/'.$evento['idEvento'];?>"><? echo $evento['idEvento'];?></a></td>
                <td><? echo $evento['titulo'];?></td>
                <td><? echo $evento['evento'];?></td>
                <td><? echo $evento['dataComeco'];?></td>
                <td><? echo $evento['dataTermino'];?></td>
                <td>
                    <p>
                        <img src="<?echo HOME_URI.'/views/_uploads/'.$evento['imagem'];?>" width="30px">
                    </p>
                </td>
                <td>
                    <a href="<? echo $delete_uri.$evento['idEvento'].'/'.$evento['idAssoc'];?>" >Delete:</a>
                </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
</div>
