<?php $suga_option = suga_core::bk_get_global_var('suga_option');?>
<?php if($suga_option['bk-mailchimp-shortcode'] != ''):?>
<!-- Subscribe modal -->
<div class="modal fade subscribe-modal" id="subscribe-modal" tabindex="-1" role="dialog" aria-labelledby="subscribe-modal-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&#10005;</span></button>
                
                <?php if($suga_option['bk-mailchimp-title'] != ''):?>
				    <h4 class="modal-title" id="subscribe-modal-label"><?php echo esc_attr($suga_option['bk-mailchimp-title']);?></h4>
                <?php endif;?>
                
			</div>
			<div class="modal-body">
				<div class="subscribe-form subscribe-form--horizontal text-center max-width-sm">
                    <?php echo do_shortcode($suga_option['bk-mailchimp-shortcode']);?>
				</div>
			</div>
		</div>
	</div>
</div><!-- Subscribe modal -->
<?php endif;?>