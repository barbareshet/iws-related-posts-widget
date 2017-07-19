<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 7/16/2017
 * Time: 10:16 PM
 */

?>
<div class="col-md-3 col-sm-12 related-post">
    <a href="<?php the_permalink();?>">
        <?php if( has_post_thumbnail() ):?>
            <div class="thumbnail-wrap">
                <?php the_post_thumbnail('related-img');?>
            </div>
        <?php else :?>
            <div class="thumbnail-wrap thumbnail-wrap-default">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/default.jpg';?>" alt="<?php the_title();?>" width="300" height="200">
            </div>
        <?php endif;?>
        <div class="related-wrap text-center">
            <?php the_title('<h4 class="related-post-title">', '</h4>');?>
        </div>
    </a>
</div>