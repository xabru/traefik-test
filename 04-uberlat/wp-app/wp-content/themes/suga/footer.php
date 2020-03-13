<?php if(!is_404()) :?>
<?php $suga_option = suga_core::bk_get_global_var('suga_option');?>

<?php
    if (isset($suga_option) && ($suga_option != '')): 
        $bkFooterTemplate = $suga_option['bk-footer-template'];
    else :
        $bkFooterTemplate = 'footer-1';
    endif;
    if ($bkFooterTemplate == 'footer-1') {
        get_template_part( 'library/templates/footer/partials/footer', '1' );
    }elseif ($bkFooterTemplate == 'footer-6') {
        get_template_part( 'library/templates/footer/partials/footer', '6' );
    }elseif ($bkFooterTemplate == 'footer-7') {
        get_template_part( 'library/templates/footer/partials/footer', '7' );
    }elseif ($bkFooterTemplate == 'footer-8') {
        get_template_part( 'library/templates/footer/partials/footer', '8' );
    }
?>
</div><!-- .site-wrapper -->
<?php
    suga_core::suga_create_ajax_security_code();
    wp_localize_script( 'suga-scripts', 'ajax_buff', suga_core::$globalBuff );
?>
<?php endif; //End if is_404?>
<?php wp_footer(); ?>

</body>
</html>