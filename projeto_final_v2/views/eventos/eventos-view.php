<?if(!defined('ABSPATH')) exit;?>

<div class="wrap">
    <?
    $lista = $modelo->listar_items();
    ?>
    <h1>Lista de Noticias</h1>
    <?foreach ($lista as $eventos):?>
        <h1>
            <a href="<? echo HOME_URI?>/evento/index/<?echo $eventos['idEvento']?>"><?echo $eventos['titulo']?></a>
        </h1>
        <?
        if(is_numeric(chk_array($modelo->parametros,0))):?>
            <p>Titulo: <?echo $eventos['titulo'];?></p>
            <p>Evento: <?echo $eventos['evento'];?></p>
            <p>Data de comeco: <?echo $eventos['dataComeco'];?></p>
            <p>Data de termino: <?echo $eventos['dataTermino'];?></p>
            <p></p>
            <p>Associacões que estao fazendo este evento: <?$list_assoc = $modelo->list_by_id_eventos_assoc($eventos['idEvento']);
                $assoc = [];
                foreach ($list_assoc as $item) {
                    $assoc = $modelo->list_by_id_eventos($item['idAssoc']);
                    if($assoc){
                        foreach ($assoc as $nome)
                            echo $nome['nome'] . ' ';
                    }else
                        echo "Sem associacao";
                }
            ?></p>
            <p>
                <img src="<?echo HOME_URI.'/views/_uploads/'.$eventos['imagem'];?>">
            </p>
            <?
            $this->prev_page = true;
            if($this->prev_page){
                ?>
                <a href="<?echo HOME_URI?>/evento/index/">Voltar</a>
            <?}?>
        <?endif;?>

    <? endforeach;?>
    <?$modelo->paginacao();?>
</div>