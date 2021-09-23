<div class="line_top interno">
    <?php require_once('view/menu/menu_duplo_topo.php'); ?>
</div>
<div class="container-fluid">
    <?php require_once('view/menu/topo_menu_interno.php'); ?>
</div>
<div class="container-fluid">
    <div class="conteudo_interno">
    <?php
    require_once('view/menu/menu_busca.php');
    include($html_pagina['page_include']);
    ?>
    </div>
</div>