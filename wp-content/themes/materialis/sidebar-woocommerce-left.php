<?php

if(!is_active_sidebar('ope_pro_woocommerce_sidebar_left'))
{
    return;
}

?>

<div class="sidebar left col-sm-12 last-sm col-md-3 first-md">
	<div class="sidebar-row">
    	<?php dynamic_sidebar('ope_pro_woocommerce_sidebar_left'); ?>
    </div>
</div>
