<?php
$postID = get_the_ID();
?>
<footer class="single-footer entry-footer">
    <div class="entry-interaction entry-interaction--horizontal">
        <div class="entry-interaction__left">
            <div class="entry-tags">
				<ul>
                    <?php
                    $tags = get_the_tags();
                    if($tags != '') :
                    ?>
                    <?php
                        foreach ($tags as $tag):
                			echo '<li><a class="post-tag" rel="tag" href="'. get_tag_link($tag->term_id) .'">'. $tag->name.'</a></li>';
                		endforeach;
                    ?>
                    <?php endif;?>
				</ul>
			</div>
        </div>
        <?php
            if ( function_exists( 'suga_extension_single_footer_interaction' ) ) {
                echo suga_extension_single_footer_interaction(get_the_ID());
            }
        ?>
    </div>
</footer>