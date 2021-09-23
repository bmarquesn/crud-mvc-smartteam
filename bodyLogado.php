<div class="line_top interno">
    <?php require_once('view/menu/menuDuploTopo.php'); ?>
</div>
<div class="container-fluid">
    <?php require_once('view/menu/topoMenuInterno.php'); ?>
</div>
<div class="container-fluid">
    <div class="conteudo_interno">
        <?php
        require_once('view/menu/menuBusca.php');
        include($html_pagina['page_include']);
        ?>
    </div>
</div>