<?php
/*
Template Name: Authors Listing Grid
*/
 ?> 
<?php
    get_header();
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts('post_type=post&post_status=publish&paged=' . $paged);
    
    $sticky = get_option('sticky_posts') ;
    rsort( $sticky );
    
    $pageID         = get_the_ID();
    $headerStyle     = suga_core::bk_get_theme_option('bk_authors_list_page_header_style');
    $headingColor   = suga_core::bk_get_theme_option('bk_authors_list_heading__color');
    
    $user_query = new WP_User_Query( array( 'role' => 'Administrator' ) );
    $users_found = $user_query->get_results();
?>

<div class="site-content">
    <div class="atbssuga-block atbssuga-block--fullwidth">
        <div class="container">
            <?php echo suga_archive::render_page_heading($pageID, $headerStyle, $headingColor);?>
            <div class="row">
                <div class="atbssuga-main" role="main">
                    <div class="atbssuga-block author-listing-grid--fw-layout">    
                        <ul class="list-unstyled list-space-lg">                    
                        <?php
                            foreach($users_found as $user) :
                                $authorID = $user->data->ID;
                                echo '<li class="col-md-4">'.suga_archive::author_box($authorID).'</li>';
                            endforeach;
                        ?>
                        </ul>
                    </div><!-- .atbssuga-block -->
                </div><!-- .atbssuga-main-col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .atbssuga-block -->
</div>
<?php get_footer(); ?>