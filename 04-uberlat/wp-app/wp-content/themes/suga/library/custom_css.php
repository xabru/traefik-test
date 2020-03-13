<?php
if ( ! function_exists( 'suga_custom_css' ) ) {
    function suga_custom_css() {
        $suga_option = suga_core::bk_get_global_var('suga_option');
        $suga_css_output = '';
        
        $cat_opt = get_option('bk_cat_opt');
        
        if ( isset($suga_option)):
            $primary_color = $suga_option['bk-primary-color'];
            if(isset($suga_option['bk-header-bg-style']) && ($suga_option['bk-header-bg-style'] == 'gradient')) {
                if(isset($suga_option['bk-header-bg-gradient']) && !empty($suga_option['bk-header-bg-gradient'])) {
                    $suga_gradient_bg = $suga_option['bk-header-bg-gradient'];
                    $suga_gradient_deg = $suga_option['bk-header-bg-gradient-direction'];
                    if($suga_gradient_deg == '') {
                        $suga_gradient_deg = 90;
                    }
                    $suga_css_output .= ".header-1 .header-main, 
                                        .header-2 .header-main, 
                                        .header-3 .site-header,
                                        .header-4 .navigation-bar,
                                        .header-5 .navigation-bar,
                                        .header-6 .navigation-bar,
                                        .header-7 .header-main,
                                        .header-8 .header-main,
                                        .header-9 .site-header,
                                        .header-10 .navigation-bar
                                        {background: ".$suga_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$suga_gradient_deg."deg, ".$suga_gradient_bg['from']." 0, ".$suga_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$suga_gradient_deg."deg, ".$suga_gradient_bg['from']." 0, ".$suga_gradient_bg['to']." 100%);}";   
                }
            }else if(isset($suga_option['bk-header-bg-style']) && ($suga_option['bk-header-bg-style'] == 'color')) {
                if(isset($suga_option['bk-header-bg-color']) && !empty($suga_option['bk-header-bg-color'])) {
                    $suga_bg_color = $suga_option['bk-header-bg-color'];
                    $suga_css_output .= ".header-1 .header-main, 
                                        .header-2 .header-main, 
                                        .header-3 .site-header, 
                                        .header-4 .navigation-bar,
                                        .header-5 .navigation-bar,
                                        .header-6 .navigation-bar,
                                        .header-7 .header-main,
                                        .header-8 .header-main,
                                        .header-9 .site-header,
                                        .header-10 .navigation-bar
                                        {background: ".$suga_bg_color['background-color'].";}";
                }
            }
            if (isset($suga_option['bk-sticky-menu-bg-style']) && ($suga_option['bk-sticky-menu-bg-style'] == 'gradient')) {
                if(isset($suga_option['bk-sticky-menu-bg-gradient']) && !empty($suga_option['bk-sticky-menu-bg-gradient'])) {
                    $suga_sticky_menu_gradient_bg = $suga_option['bk-sticky-menu-bg-gradient'];
                    $suga_sticky_menu_gradient_deg = $suga_option['bk-sticky-menu-bg-gradient-direction'];
                    if($suga_sticky_menu_gradient_deg == '') {
                        $suga_sticky_menu_gradient_deg = 90;
                    }
                    $suga_css_output .= ".sticky-header.is-fixed > .navigation-bar
                                        {background: ".$suga_sticky_menu_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$suga_sticky_menu_gradient_deg."deg, ".$suga_sticky_menu_gradient_bg['from']." 0, ".$suga_sticky_menu_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$suga_sticky_menu_gradient_deg."deg, ".$suga_sticky_menu_gradient_bg['from']." 0, ".$suga_sticky_menu_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($suga_option['bk-sticky-menu-bg-style']) && ($suga_option['bk-sticky-menu-bg-style'] == 'color')) {
                if(isset($suga_option['bk-sticky-menu-bg-color']) && !empty($suga_option['bk-sticky-menu-bg-color'])) {
                    $suga_sticky_menu_bg_color = $suga_option['bk-sticky-menu-bg-color'];
                    $suga_css_output .= ".sticky-header.is-fixed > .navigation-bar
                                        {background: ".$suga_sticky_menu_bg_color['background-color'].";}";
                }
            }
            if (isset($suga_option['bk-mobile-menu-bg-style']) && ($suga_option['bk-mobile-menu-bg-style'] == 'gradient')) {
                if(isset($suga_option['bk-mobile-menu-bg-gradient']) && !empty($suga_option['bk-mobile-menu-bg-gradient'])) {
                    $suga_mobile_menu_gradient_bg = $suga_option['bk-mobile-menu-bg-gradient'];
                    $suga_mobile_menu_gradient_deg = $suga_option['bk-mobile-menu-bg-gradient-direction'];
                    if($suga_mobile_menu_gradient_deg == '') {
                        $suga_mobile_menu_gradient_deg = 90;
                    }
                    $suga_css_output .= "#atbssuga-mobile-header
                                        {background: ".$suga_mobile_menu_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$suga_mobile_menu_gradient_deg."deg, ".$suga_mobile_menu_gradient_bg['from']." 0, ".$suga_mobile_menu_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$suga_mobile_menu_gradient_deg."deg, ".$suga_mobile_menu_gradient_bg['from']." 0, ".$suga_mobile_menu_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($suga_option['bk-mobile-menu-bg-style']) && ($suga_option['bk-mobile-menu-bg-style'] == 'color')) {
                if(isset($suga_option['bk-mobile-menu-bg-color']) && !empty($suga_option['bk-mobile-menu-bg-color'])) {
                    $suga_mobile_menu_bg_color = $suga_option['bk-mobile-menu-bg-color'];
                    $suga_css_output .= "#atbssuga-mobile-header
                                        {background: ".$suga_mobile_menu_bg_color['background-color'].";}";
                }
            }
            if (isset($suga_option['bk-footer-bg-style']) && ($suga_option['bk-footer-bg-style'] == 'gradient')) {
                if(isset($suga_option['bk-footer-bg-gradient']) && !empty($suga_option['bk-footer-bg-gradient'])) {
                    $suga_footer_gradient_bg = $suga_option['bk-footer-bg-gradient'];
                    $suga_footer_gradient_deg = $suga_option['bk-footer-bg-gradient-direction'];
                    if($suga_footer_gradient_deg == '') {
                        $suga_footer_gradient_deg = 90;
                    }
                    $suga_css_output .= ".site-footer, .footer-7.site-footer, .footer-8.site-footer, .footer-6.site-footer
                                        {background: ".$suga_footer_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$suga_footer_gradient_deg."deg, ".$suga_footer_gradient_bg['from']." 0, ".$suga_footer_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$suga_footer_gradient_deg."deg, ".$suga_footer_gradient_bg['from']." 0, ".$suga_footer_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($suga_option['bk-footer-bg-style']) && ($suga_option['bk-footer-bg-style'] == 'color')) {
                if(isset($suga_option['bk-footer-bg-color']) && !empty($suga_option['bk-footer-bg-color'])) {
                    $suga_footer_bg_color = $suga_option['bk-footer-bg-color'];
                    $suga_css_output .= ".site-footer, .footer-7.site-footer, .footer-8.site-footer, .footer-6.site-footer
                                        {background: ".$suga_footer_bg_color['background-color'].";}";
                }
            }
            if (isset($suga_option['bk-coming-soon-bg-style']) && ($suga_option['bk-coming-soon-bg-style'] == 'gradient')) {
                if(isset($suga_option['bk-coming-soon-bg-gradient']) && !empty($suga_option['bk-coming-soon-bg-gradient'])) {
                    $suga_cs_gradient_bg = $suga_option['bk-coming-soon-bg-gradient'];
                    $suga_cs_gradient_deg = $suga_option['bk-coming-soon-bg-gradient-direction'];
                    if($suga_cs_gradient_deg == '') {
                        $suga_cs_gradient_deg = 90;
                    }
                    $suga_css_output .= ".page-coming-soon .background-img>.background-overlay
                                        {background: ".$suga_cs_gradient_bg['from'].";
                                        background: -webkit-linear-gradient(".$suga_cs_gradient_deg."deg, ".$suga_cs_gradient_bg['from']." 0, ".$suga_cs_gradient_bg['to']." 100%);
                                        background: linear-gradient(".$suga_cs_gradient_deg."deg, ".$suga_cs_gradient_bg['from']." 0, ".$suga_cs_gradient_bg['to']." 100%);}";   
                }
            }else if (isset($suga_option['bk-coming-soon-bg-style']) && ($suga_option['bk-coming-soon-bg-style'] == 'color')) {
                if(isset($suga_option['bk-coming-soon-bg-color']) && !empty($suga_option['bk-coming-soon-bg-color'])) {
                    $suga_cs_bg_color = $suga_option['bk-coming-soon-bg-color'];
                    $suga_css_output .= ".page-coming-soon .background-img
                                        {background: ".$suga_cs_bg_color['background-color'].";}";
                }
            }
        endif;
        
        $suga_css_output .= "::selection {color: #FFF; background: $primary_color;}";
        $suga_css_output .= "::-webkit-selection {color: #FFF; background: $primary_color;}";
        
        if ( ($primary_color) != null) :
            $suga_css_output .= "a, a:hover, a:focus, a:active, .color-primary, .site-title, .atbssuga-widget-indexed-posts-b .posts-list > li .post__title:after,
            .author-box .author-name a, .atbssuga-pagination__item-current,
            .atbssuga-post-latest-d--post-slide .atbssuga-carousel .owl-prev,
            .atbssuga-post-latest-d--post-slide .atbssuga-carousel .owl-next,
            .atbssuga-post-latest-c--post-grid .atbssuga-carousel .owl-prev:hover,
            .atbssuga-post-latest-c--post-grid .atbssuga-carousel .owl-next:hover,
            .atbssuga-post-latest-b--post-slide .atbssuga-carousel .owl-prev,
            .atbssuga-post-latest-b--post-slide .atbssuga-carousel .owl-next,
            .post-grid-3i-has-slider-fullwidth-a .atbssuga-carousel-nav-custom-holder .owl-prev,
            .post-grid-3i-has-slider-fullwidth-a .atbssuga-carousel-nav-custom-holder .owl-next,
            .post-feature-slide-small .atbssuga-carousel-nav-custom-holder .owl-prev:hover,
            .post-feature-slide-small .atbssuga-carousel-nav-custom-holder .owl-next:hover,
            .post--horizontal-text-background .post__readmore .readmore__text, 
            .single .posts-navigation__next .posts-navigation__label:hover, .single .social-share-label, .single .single-header .entry-cat, .post--vertical-readmore-small .post__text .post__cat, 
            .post--vertical-readmore-big .post__text .post__cat, .post--horizontal-reverse-big .post__cat, .atbssuga-post--grid-has-postlist .atbssuga-post-list--vertical .block-title-small .block-heading__title,
            .atbssuga-post--grid-multiple-style__fullwidth-a .post-not-fullwidth .atbssuga-pagination .read-more-link, 
            .atbssuga-post--grid-multiple-style__fullwidth-a .post-not-fullwidth .atbssuga-pagination .read-more-link i,
            .carousel-heading .block-heading.block-heading--vertical .block-heading__title, .atbssuga-pagination__item:not(.atbssuga-pagination__item-current):hover, 
            .atbssuga-pagination__item-current:hover, .atbssuga-pagination__item-current, .post__readmore a.button__readmore:hover, .post__cat.cat-color-logo, 
            .post-score-star, .atbssuga-pagination .btn, .form-submit .submit, .atbssuga-search-full .result-default .popular-title span, .atbssuga-search-full--result .atbssuga-pagination .btn,
            .atbssuga-search-full .result-default .search-terms-list a:hover, .atbssuga-pagination.atbssuga-pagination-view-all-post .btn:hover i, .atbssuga-pagination.atbssuga-pagination-view-all-post .btn:hover,
            .sticky-suga-post .sugaStickyMark i
            {color: $primary_color;}";
            
            $suga_css_output .= ".category-tile__name, .cat-0.cat-theme-bg.cat-theme-bg, .primary-bg-color, .navigation--main > li > a:before, .atbssuga-pagination--next-n-prev .atbssuga-pagination__links a:last-child .atbssuga-pagination__item,
            .subscribe-form__fields input[type='submit'], .has-overlap-bg:before, .post__cat--bg, a.post__cat--bg, .entry-cat--bg, a.entry-cat--bg, 
            .comments-count-box, .atbssuga-widget--box .widget__title,  .posts-list > li .post__thumb:after, 
            .widget_calendar td a:before, .widget_calendar #today, .widget_calendar #today a, .entry-action-btn, .posts-navigation__label:before, 
            .atbssuga-carousel-dots-b .swiper-pagination-bullet-active,
             .site-header--side-logo .header-logo:not(.header-logo--mobile), .list-square-bullet > li > *:before, .list-square-bullet-exclude-first > li:not(:first-child) > *:before,
             .btn-primary, .btn-primary:active, .btn-primary:focus, .btn-primary:hover, 
             .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover,
             .atbssuga-post-latest-d--post-grid .list-item:first-child .post--nothumb-large-has-background, 
            .atbssuga-post-latest-d--post-slide .atbssuga-carousel .owl-prev:hover,
            .atbssuga-post-latest-d--post-slide .atbssuga-carousel .owl-next:hover,
            .atbssuga-post-latest-b--post-slide .atbssuga-carousel .owl-prev:hover,
            .atbssuga-post-latest-b--post-slide .atbssuga-carousel .owl-next:hover,
            .post--nothumb-has-line-readmore, .post--nothumb-has-line-readmore, .suga-owl-background, .post-slide--nothumb, 
            .single .single-footer .entry-tags ul > li > a:hover, 
            .social-share ul li a svg:hover, .social-share-label-wrap:before, .post--vertical-readmore-small .post__text-wrap .post__readmore:hover,
            .post--vertical-readmore-big .post__text-wrap .post__readmore:hover, .post--horizontal-hasbackground.post:hover,
            .post--horizontal__title-line .post__title:before, .widget-subscribe .subscribe-form__fields button, .atbssuga-pagination__item-current:before,
            .atbssuga-post-latest-d--post-grid .post-list:hover .list-item:first-child:hover .post--nothumb-large-has-background, .atbssuga-widget-indexed-posts-a .posts-list>li .post__thumb:after, .atbssuga-search-full .form-control, 
            .atbssuga-search-full .popular-tags .entry-tags ul > li > a, .atbssuga-pagination [class*='js-ajax-load-'] , .atbssuga-pagination [class*='js-ajax-load-']:hover , .atbssuga-pagination [class*='js-ajax-load-']:active,
            .widget-slide .atbssuga-carousel .owl-dot.active span, .single .comment-form .form-submit input[type='submit'] , .social-tile, .widget-subscribe__inner,
            .suga-subscribe-button, .suga-subscribe-button:hover, .suga-subscribe-button:focus, .suga-subscribe-button:active, .suga-subscribe-button:visited
            {background-color: $primary_color;}";
            
            $suga_css_output .= "@media (min-width: 1200px){.post--nothumb-large-has-background:hover {background-color: $primary_color;} }";
            $suga_css_output .= ".site-header--skin-4 .navigation--main > li > a:before
            {background-color: $primary_color !important;}";
            
            $suga_css_output .= ".post-score-hexagon .hexagon-svg g path
            {fill: $primary_color;}";
            
            $suga_css_output .= ".has-overlap-frame:before, .atbssuga-gallery-slider .fotorama__thumb-border, .bypostauthor > .comment-body .comment-author > img,
            .atbssuga-post-latest-b--post-slide .atbssuga-carousel .owl-next, 
            .atbssuga-post--grid-has-postlist .atbssuga-post-list--vertical .block-title-small .block-heading__title,
            .atbssuga-post-latest-b--post-slide .atbssuga-carousel .owl-prev, .atbssuga-post-latest-b--post-slide .atbssuga-carousel .owl-next, 
            .single .comment-form .form-submit input[type='submit'], .atbssuga-pagination .btn, .form-submit .submit, .atbssuga-search-full--result .atbssuga-pagination .btn, .atbssuga-pagination [class*='js-ajax-load-']:active
            {border-color: $primary_color;}";
            
            $suga_css_output .= ".atbssuga-pagination--next-n-prev .atbssuga-pagination__links a:last-child .atbssuga-pagination__item:after
            {border-left-color: $primary_color;}";
            
            $suga_css_output .= ".comments-count-box:before, .bk-preload-wrapper:after
            {border-top-color: $primary_color;}";
            
            $suga_css_output .= ".bk-preload-wrapper:after
            {border-bottom-color: $primary_color;}";
            
            $suga_css_output .= ".navigation--offcanvas li > a:after
            {border-right-color: $primary_color;}";
            
            $suga_css_output .= ".post--single-cover-gradient .single-header
            {
                background-image: -webkit-linear-gradient( bottom , $primary_color 0%, rgba(252, 60, 45, 0.7) 50%, rgba(252, 60, 45, 0) 100%);
                background-image: linear-gradient(to top, $primary_color 0%, rgba(252, 60, 45, 0.7) 50%, rgba(252, 60, 45, 0) 100%);
            }";
        endif;
        
        $suga_css_output .= ".atbssuga-video-box__playlist .is-playing .post__thumb:after { content: '".esc_html__( 'Now playing', 'suga' )."'; }";
        
        $cat__terms = get_terms( array(
            'taxonomy' => 'category',
            'hide_empty' => true,
        ) );    
        if ((is_array($cat__terms))) :
            
            foreach ($cat__terms as $key => $cat__term) :
                $catColorVal  = suga_core::suga_rwmb_meta( 'bk_category__color', array( 'object_type' => 'term' ), $cat__term->term_id );  
                if($catColorVal != '') :
                    $suga_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme, 
                                        .cat-'.$cat__term->term_id.'.cat-theme.cat-theme, 
                                        .cat-'.$cat__term->term_id.' a:hover .cat-icon,
                                        .atbssuga-post-latest-d--post-grid:hover .list-item.active .post--nothumb-large-has-background a.cat-'.$cat__term->term_id.'
                    {color: '.$catColorVal.' !important;}'; 
                    
                    $suga_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme-bg,
                                        .cat-'.$cat__term->term_id.'.cat-theme-bg.cat-theme-bg,
                                        .navigation--main > li.menu-item-cat-'.$cat__term->term_id.' > a:before,
                                        .cat-'.$cat__term->term_id.'.post--featured-a .post__text:before,
                                        .atbssuga-carousel-b .cat-'.$cat__term->term_id.' .post__text:before,
                                        .cat-'.$cat__term->term_id.' .has-overlap-bg:before,
                                        .cat-'.$cat__term->term_id.'.post--content-overlap .overlay-content__inner:before
                    {background-color: '.$catColorVal.' !important;}'; 
                    
                    $suga_css_output .= '.cat-'.$cat__term->term_id.' .cat-theme-border,
                                        .cat-'.$cat__term->term_id.'.cat-theme-border.cat-theme-border,
                                        .atbssuga-featured-block-a .main-post.cat-'.$cat__term->term_id.':before,
                                        .cat-'.$cat__term->term_id.' .category-tile__inner:before,
                                        .cat-'.$cat__term->term_id.' .has-overlap-frame:before,
                                        .navigation--offcanvas li.menu-item-cat-'.$cat__term->term_id.' > a:after,
                                        .atbssuga-featured-block-a .main-post:before
                    {border-color: '.$catColorVal.' !important;}';
                    
                    $suga_css_output .= '.post--single-cover-gradient.cat-'.$cat__term->term_id.' .single-header
                    {
                    background-image: -webkit-linear-gradient( bottom , '.$catColorVal.' 0%, rgba(25, 79, 176, 0.7) 50%, rgba(25, 79, 176, 0) 100%);
                    background-image: linear-gradient(to top, '.$catColorVal.' 0%, rgba(25, 79, 176, 0.7) 50%, rgba(25, 79, 176, 0) 100%);
                    }';
                endif;
            endforeach;
            
        endif; 
        wp_add_inline_style( 'suga-style', $suga_css_output );
    }
    add_action( 'wp_enqueue_scripts', 'suga_custom_css' );
}