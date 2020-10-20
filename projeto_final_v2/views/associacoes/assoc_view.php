<?verifyPath();?>

<div class="wrap">
    <?
    $lista = $modelo->listar_items();
    ?>
    <h1>Lista de Associações</h1>
    <?foreach ($lista as $assoc):?>
        <h1>
            <a href="<? echo HOME_URI?>/associacoes/index/<?echo $assoc['idAssoc']?>"><?echo $assoc['nome']?></a>
        </h1>
        <?
        if(is_numeric(chk_array($modelo->parametros,0))):?>
            <p>Morada: <?echo $assoc['morada'];?></p>
            <p>Telefone: <?echo $assoc['telefone'];?></p>
            <p>Numero de contribuinte: <?echo $assoc['numContribuinte'];?></p>
            <?
            $this->prev_page = true;
            if($this->prev_page){
                ?>
                <a href="<?echo HOME_URI?>/associacoes/index/">Voltar</a>
            <?}?>
        <?endif;?>

    <? endforeach;?>
    <?$modelo->paginacao();?>
</div>