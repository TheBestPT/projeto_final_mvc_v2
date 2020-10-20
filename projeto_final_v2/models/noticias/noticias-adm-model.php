<?php
class NoticiasAdmModel extends ItemsAbstract {
    function insere_form()
    {
        return 'insere_noticia';
    }

    function table_name()
    {
        return 'noticias';
    }

    function id_table()
    {
        return 'idNoticia';
    }

    function url_name()
    {
        return 'noticias';
    }

    function haveImage()
    {
        return true;
    }
}
?>