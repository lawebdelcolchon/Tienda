<?php /* Wrapper Name: Header */ ?>
<div class="row">
	<div class="box1">
    	<div class="span8" data-motopress-type="static" data-motopress-static-file="static/static-shop-nav.php">
    		<?php get_template_part("static/static-shop-nav"); ?>
    	</div>
        <div class="span4" data-motopress-type="static" data-motopress-static-file="static/cart-holder.php">
    		<?php get_template_part("static/static-search"); ?>
    	</div>
    </div>
    <div class="box2">
        <div class="span6" data-motopress-type="static" data-motopress-static-file="static/static-shop-nav.php">
    		<?php get_template_part("static/static-logo"); ?>
    	</div>
        <div class="span6" data-motopress-type="static" data-motopress-static-file="static/static-shop-nav.php">
    		<?php dynamic_sidebar( 'cart-holder' ); ?>
    	</div>
    </div>
</div>
<div class="row">
	<div class="span12 logo_box" data-motopress-type="static" data-motopress-static-file="static/static-nav.php">
		<?php get_template_part("static/static-nav"); ?>
	</div>
</div>