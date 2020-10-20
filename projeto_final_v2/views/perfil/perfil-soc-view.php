<?php
verifyPath();
$id_soc = 0;
if(chk_array($this->parametros, 0))
    $id_soc = chk_array($this->parametros, 0);
else
    header('location: '.HOME_URI);
$socio = $modelo->get_soc_by_id($id_soc);
$adm_uri = HOME_URI.'/perfil/me/'.$id_soc.'/';
$pagamento_uri = $adm_uri.'pay/';
$modelo->pay($this->parametros);
?>
<h1>Perfil: </h1>
<p>
    <img src="<?echo HOME_URI.'/views/_uploads/login.png';?>" width="100" height="100">
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
    $lista_evento_soc = $modelo->get_id_incricao($id_soc);
    $lista_eventos = "";
    ?>
    <h1>Lista de eventos em que estás inscrito:</h1>
    <table id="tbl-projeto" class="list-table">
        <thead>
        <tr>
            <th>Titulo</th>
            <th>Evento</th>
            <th>Imagem</th>
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
                    </tr>
            <? endforeach;?>
        <? endforeach;?>
        </tbody>
    </table>
</div>
