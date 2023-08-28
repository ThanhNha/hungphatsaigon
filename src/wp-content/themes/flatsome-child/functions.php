<?php
// Add custom Theme Functions here


//<!-- ###--- Add CSS Dashboard ---###-->

add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {?>
    <style>        
        .menu-item-settings .ux-menu-item-options.js-attached:first-child{display: none;} 
        .rank-math-sidebar-panel>div{width: 100%;}
    </style>';
<?php }




