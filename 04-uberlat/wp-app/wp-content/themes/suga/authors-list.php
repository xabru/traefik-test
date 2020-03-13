<?php
/*
Template Name: Authors List
*/
 ?> 
<?php
    $layout     = suga_core::bk_get_theme_option('bk_authors_list_page_layout');
    $sidebar    = suga_core::bk_get_theme_option('bk_authors_list_page_sidebar');
    if($layout == 'listing-list') {
        if($sidebar == 1) {
            get_template_part( '/library/templates/author_list/authors-listing-list' );
        }else {
            get_template_part( '/library/templates/author_list/authors-listing-list-fw' );
        }
    }else {
        if($sidebar == 1) {
            get_template_part( '/library/templates/author_list/authors-listing-grid' );
        }else {
            get_template_part( '/library/templates/author_list/authors-listing-grid-fw' );
        }
    }
?>