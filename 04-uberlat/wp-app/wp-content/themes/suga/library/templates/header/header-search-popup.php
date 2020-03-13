<!-- search popup-->
<?php
    $suga_option                = suga_core::bk_get_global_var('suga_option');
    $posts_section_heading      = isset($suga_option['search_recommend_heading']) ? $suga_option['search_recommend_heading'] : '';
    $post_section_query         = isset($suga_option['search_recommend_query_option']) ? $suga_option['search_recommend_query_option'] : '';
    
    $tags_section_heading       = isset($suga_option['search_panel_tags_headline']) ? $suga_option['search_panel_tags_headline'] : '';
    $tagIDs                     = isset($suga_option['section_search_panel_tag_option']) ? $suga_option['section_search_panel_tag_option'] : '';
    
    $search_section_heading     = isset($suga_option['search_panel_search_term_headline']) ? $suga_option['search_panel_search_term_headline'] : '';
    $searchTerms                = isset($suga_option['search_term_keyword']) ? $suga_option['search_term_keyword'] : '';
?>
<div class="atbssuga-search-full">
    <span id="atbssuga-search-remove"><i class="mdicon mdicon-close"></i></span>
    <div class="atbssuga-search-full--wrap ajax-search is-in-navbar js-ajax-search is-active">
        <div class="atbssuga-search-full--form">
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                <input type="text" name="s" class="form-control search-form__input" autocomplete="off" placeholder="<?php esc_attr_e('Type to search', 'suga');?>" value="">
                <button type="submit" class="btn-search-full"><i class="mdicon mdicon-arrow_forward"></i></button>
            </form>
            <div class="result-default">
                <div class="popular-posts">
                    <h2 class="popular-title">
                        <span>
                        <?php 
                            if($posts_section_heading != '') :
                                echo esc_html($posts_section_heading);
                            else:
                                esc_html_e('Recommend Posts', 'suga');
                            endif;
                        ?>
                        </span>
                    </h2>
                    <?php 
                        $args = array(
                            'orderby'       => 'date',
                            'post_status'   => 'publish',
            				'ignore_sticky_posts'   => 1,
            				'posts_per_page'        => 3,
                            'post_type'             => 'post',
                        );
                        switch ( $post_section_query ) {
    
            				//Date post
            				case 'date' :
            					$args['orderby'] = 'date';
            					break;
            
            				//Popular comment
            				case 'comment_count' :
            					$args['orderby'] = 'comment_count';
            					break;
                            
                            //Popular Views
            				case 'view_count' :
                                $args['meta_key'] = 'post_views_count';
            					$args['orderby']  = 'meta_value_num';
            					$args['order']    = 'DESC';
            					break;
                            
            				//Modified
            				case 'modified' :
            					$args['orderby'] = 'modified';
            					break;
                                
                            // Review
            				case 'top_review' :
            					$args['meta_key'] = 'bk_review_score';
            					$args['orderby']  = 'meta_value_num';
            					$args['order']    = 'DESC';
            					break;
            				//Random
            				case 'rand':
            					$args['orderby'] = 'rand';
            					break;
            
            				//Alphabet decs
            				case 'alphabetical_decs':
            					$args['orderby'] = 'title';
            					$args['order']   = 'DECS';
            					break;
            
            				//Alphabet asc
            				case 'alphabetical_asc':
            					$args['orderby'] = 'title';
            					$args['order']   = 'ASC';
            					break;
                            
                            // Default
                            default:
                                $args['orderby'] = 'date';
            					break;
            			}
                        $the_query = new WP_Query( $args );
                    ?>
                    <div class="post-list">
                        <?php 
                        while ( $the_query->have_posts() ): $the_query->the_post(); 
                            $postID = get_the_ID();
                            $bk_permalink = get_permalink($postID);
                            $bk_post_title = get_the_title($postID);
                        ?>
                        <div class="list-item">
                            <article class="post">
                                <div class="post__text">
                                    <h3 class="post__title typescale-2 custom-typescale-2">
                                        <a href="<?php echo esc_url($bk_permalink);?>"><?php echo get_the_title($postID);?></a>
                                    </h3>
                                </div>
                            </article>
                        </div>
                        <?php    
                        endwhile;
                        ?> 
                    </div>
                </div>
                 <?php if(is_array($searchTerms) && ($searchTerms[0]) != ''):?>
                <div class="popular-tags">
                    <h2 class="popular-title"> 
                        <span>              
                            <?php 
                                if($tags_section_heading != '') :
                                    echo esc_html($tags_section_heading);
                                else:
                                    esc_html_e('Popular Tags', 'suga');
                                endif;
                            ?>
                        </span> 
                    </h2>                    
                    <div class="tags-list entry-tags">
                        <ul>
                        <?php 
                            foreach ($tagIDs as $tagID):
                                $tag = get_tag($tagID);
                    			echo '<li><a class="post-tag" rel="tag" href="'. get_tag_link($tag->term_id) .'">'. $tag->name.'</a></li>';
                    		endforeach;
                        ?>
                        </ul>
                    </div>
                </div>
                <?php endif;?>
                <?php if(is_array($searchTerms) && ($searchTerms[0]) != ''):?>
                <div class="popular-search">
                    <h2 class="popular-title"> 
                        <span>              
                            <?php 
                                if($search_section_heading != '') :
                                    echo esc_html($search_section_heading);
                                else:
                                    esc_html_e('Popular Search', 'suga');
                                endif;
                            ?>
                        </span> 
                    </h2>          
                    <div class="search-terms-section search-terms-list">
                        <ul>
                        <?php foreach ($searchTerms as $searchTerm):?>
                            <li class="search-term typescale-2 custom-typescale-2">
                                <a href="<?php echo esc_url(get_search_link($searchTerm));?>"><?php echo esc_html($searchTerm);?></a>             
                  		    </li>
                          <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
        <div class="atbssuga-search-full--result search-results">
            <div class="typing-loader"></div>
            <div class="search-results__inner">
            </div>                
        </div>
    </div>
</div>
<!-- .header-search-popup -->
