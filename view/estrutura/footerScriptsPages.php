<script type="text/javascript">
$(function(){
    var pagina_Atual="<?php echo $pagina_Atual; ?>";
    var funcao_Atual="<?php echo $funcao_Atual; ?>";
    pagina_Atual="?controller="+pagina_Atual;
    if(funcao_Atual!="index"){
        pagina_Atual+="&method="+funcao_Atual;
    }
    
    $('#topo_menu_interno').find('a').each(function(){
        if($(this).attr('href').toUpperCase()==pagina_Atual.toUpperCase()){
            $(this).addClass('active');
        }
    });
});
</script>
<script type="text/javascript" src="assets/js/jquery.mask.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/js/crud_mvc.js?clear=<?php echo $date->getTimestamp(); ?>" crossorigin="anonymous"></script>
<?php
if(isset($html_pagina['library']) && !empty($html_pagina['library'])) {
    if(isset($html_pagina['library']['script_pages']) && !empty($html_pagina['library']['script_pages'])) {
        if(is_array($html_pagina['library']['script_pages'])) {
            foreach($html_pagina['library']['script_pages'] as $key => $value) {
                echo '<script type="text/javascript" src="assets/js/' . $value . '?clearJS=' . $date->getTimestamp() . '"></script>';
            }
        } else {
            echo '<script type="text/javascript" src="assets/js/' . $html_pagina['library']['script_pages'] . '?clearJS=' . $date->getTimestamp() . '"></script>';
        }
    }
}
?>