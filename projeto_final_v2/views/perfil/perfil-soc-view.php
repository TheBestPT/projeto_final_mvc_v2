<?php
if(!defined('ABSPATH')) exit;
$id_soc = 0;
if(chk_array($this->parametros, 0))
    $id_soc = chk_array($this->parametros, 0);
else
    header('location: '.HOME_URI);
$socio = $modelo->get_soc_by_id($id_soc);
$adm_uri = HOME_URI.'/perfil/me/'.$id_soc.'/';
$pagamento_uri = $adm_uri.'pay/';
$cancela_uri = $adm_uri.'can/';
$register_uri = $adm_uri.'register/';
$modelo->pay($this->parametros);
$modelo->cancelarEvento($this->parametros);
$modelo->registar($this->parametros);
?>
<h1>Perfil: </h1>
<p>
    <img src="<?echo HOME_URI.'/views/_uploads/'.$socio['imagem'];?>" width="300" height="300">
</p>
<p>Nome: <? echo $socio['nome'];?></p>
<p>User Name: <? echo $socio['login'];?></p>
<p>Email: <? echo $socio['email'];?></p>
<p>Associação: <? echo $modelo->get_assoc_by_id($socio['idAssoc']); ?></p>

<div class="wrap">
    <?
    $lista = $modelo->getQuotas($id_soc);
    ?>
    <h1>Lista de quotas:</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Preço</th>
            <th>Data Comeco</th>
            <th>Data Termino</th>
            <th>Pagamentos de quotas</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($lista as $quotas): ?>
            <?if($quotas['pago'] == 0):?>
            <tr>
                <td><? echo $quotas['preco'];?></td>
                <td><? echo $quotas['dataComeco'];?></td>
                <td><? echo $quotas['dataTermino'];?></td>
                <td>
                    <a href="<? echo $pagamento_uri.$quotas['idQuota']?>" >Pagar:</a>
                </td>
            </tr>
            <? endif;?>
        <? endforeach;?>
        </tbody>
    </table>
</div>
<div class="wrap">
    <?
    $lista_evento_soc = $modelo->get_eventos($socio['idAssoc']);
    $lista_eventos = null;
    ?>
    <h1>Lista de eventos em que estás inscrito:</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Titulo</th>
            <th>Evento</th>
            <th>Imagem</th>
            <th>Data de Começo</th>
            <th>Data de Termino</th>
            <th>Inscrição</th>
            <th>Cancelar</th>
        </tr>
        </thead>
        <tbody>

        <?foreach ($lista_evento_soc as $item):
            $lista_eventos = $modelo->get_id_evento($item['idEvento']);
            ?>
            <? foreach($lista_eventos as $evento): ?>
                    <tr>
                        <td><? echo $evento['titulo'];?></td>
                        <td><? echo $evento['evento'];?></td>
                        <td>
                            <img src="<?echo HOME_URI.'/views/_uploads/'.$evento['imagem'];?>" width="30px">
                        </td>
                        <td><? echo $evento['dataComeco'];?></td>
                        <td><? echo $evento['dataTermino'];?></td>
                        <td><? if(!empty($modelo->get_id_incricao($evento['idEvento'], $id_soc)['idEvento'])) echo "Inscrito"; else echo "Não inscrito";?></td>
                        <td>
                            <a href="<? echo $cancela_uri.$evento['idEvento']?>" >Cancelar:</a>
                            <a href="<? echo $register_uri.$evento['idEvento']?>" >Inscrever:</a>
                        </td>
                    </tr>
            <? endforeach;?>
        <? endforeach;?>
        </tbody>
    </table>
</div>
