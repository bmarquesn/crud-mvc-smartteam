<?php require_once('AutoLoadPages.php'); ?>
<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <?php require_once('view/estrutura/headPages.php'); ?>
</head>

<body>
    <?php
    if(is_array($html_pagina)) {
        if(isset($html_pagina['tipo_view']) && $html_pagina['tipo_view'] == "pagina_interna") {
            include('bodyLogado.php');
        } else {
            if(file_exists($html_pagina['page_include'])) {
                include($html_pagina['page_include']);
            }
        }
    } else {
        echo $html_pagina;
    }
    require_once('view/estrutura/footerScriptsPages.php');
    ?>
</body>

</html>