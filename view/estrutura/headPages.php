<meta charset="UTF-8" />
<title>CRUD MVC SMARTTEAM - Bruno Marques Nogueira - Processo Seletivo</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Keywords" content="CRUD, MVC, PHP" />
<meta name="Description" content="Teste CRUD MVC processo seletivo SmartTeam" />
<link href="assets/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/crud_mvc.css" rel="stylesheet" type="text/css" />
<?php
if(isset($html_pagina['library']) && !empty($html_pagina['library'])) {
    if(isset($html_pagina['library']['css_pages']) && !empty($html_pagina['library']['css_pages'])) {
        if(is_array($html_pagina['library']['css_pages'])) {
            foreach($html_pagina['library']['css_pages'] as $key => $value) {
                echo '<link href="assets/css/' . $value . '?clearCSS=' . $date->getTimestamp() . '" rel="stylesheet" type="text/css" />';
            }
        } else {
            echo '<link href="assets/css/' . $html_pagina['library']['css_pages'] . '?clearCSS=' . $date->getTimestamp() . '" rel="stylesheet" type="text/css" />';
        }
    }
}
?>
<script src="assets/js/jquery-3.4.1.js" crossorigin="anonymous"></script>
<script src="assets/js/bootstrap/bootstrap.min.js" crossorigin="anonymous"></script>