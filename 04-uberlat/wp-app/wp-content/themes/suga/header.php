<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    
    <link rel="profile" href="//gmpg.org/xfn/11" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php wp_head(); ?>
    
    <?php get_template_part( 'library/templates/single/single-schema-meta');?>
</head>
<body <?php body_class(); ?>>
    <div class="site-wrapper <?php echo suga_header::suga_get_header_class();?>">
        <?php
            if(!is_404()) :
                suga_header::suga_get_header();
            endif;
        ?>