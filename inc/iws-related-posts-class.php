<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 7/16/2017
 * Time: 7:01 PM
 */
class iws_related_posts extends WP_Widget{
    //Create Widget
    function __construct(){
        parent::__construct(
            'iws_related_posts', //Base ID
            __('Barbareshet Related Posts', TEXT_DOMAIN),
            array(
                'description' => __('My related posts widget', TEXT_DOMAIN)
            )
        );
    }
//Frontend display
    public function widget($args, $instance){
        //get the values
        $title = apply_filters('widget_title', $instance['title']);
        $tax = esc_attr($instance['tax']) ? esc_attr($instance['tax']) : 'category';
        $count = esc_attr($instance['count']) ? esc_attr($instance['count']) : 4;
        $post_type = esc_attr($instance['post_type']) ? esc_attr($instance['post_type']) : 'post';


        echo $args['before_widget'];

        if(!empty($title)){
            echo $args['before_title'] . $title .$args['after_title'];
        }
        echo $this->show_my_related_posts($title, $tax, $count, $post_type);

        echo $args['after_widget'];
    }

    //Backend Form
    public function form($instance){
        if(isset($instance['title'])){
            $title = $instance['title'];
        }else{
            $title = __('Related Posts',TEXT_DOMAIN);
        }

        //Get category
        if(isset($instance['tax'])){
            $tax = $instance['tax'];
        }else{
            $tax = __('category',TEXT_DOMAIN);
        }

        //Get count
        if(isset($instance['count'])){
            $count = $instance['count'];
        }else{
            $count = 6;
        }

        //Get post type
        if(isset($instance['post_type'])){
            $post_type = $instance['post_type'];
        }else{
            $post_type = 'post';
        }
        //Frontend Widget Form
        ?>
        <p>
            <labal for="<?php echo $this->get_field_id('title');?>"><?php echo _e('Title', TEXT_DOMAIN);?></labal>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php echo esc_html__($title);?>">
        </p>
        <p>
            <labal for="<?php echo $this->get_field_id('tax');?>"><?php echo _e('Taxonomy', TEXT_DOMAIN);?></labal>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('tax');?>" name="<?php echo $this->get_field_name('tax');?>" value="<?php echo esc_html__($tax);?>">
        </p>
        <p>
            <labal for="<?php echo $this->get_field_id('count');?>"><?php echo _e('Number of Posts to Show', TEXT_DOMAIN);?></labal>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('count');?>" name="<?php echo $this->get_field_name('count');?>" value="<?php echo esc_html__($count);?>">
        </p>
        <p>
            <labal for="<?php echo $this->get_field_id('post_type');?>"><?php echo _e('Post Type', TEXT_DOMAIN);?></labal>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('post_type');?>" name="<?php echo $this->get_field_name('post_type');?>" value="<?php echo esc_html__($post_type);?>">
        </p>
        <?php
    }
//Update widget values
    public function update($new_instance, $old_instance){
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['tax'] = (!empty($new_instance['tax'])) ? strip_tags($new_instance['tax']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? strip_tags($new_instance['count']) : '';
        $instance['post_type'] = (!empty($new_instance['post_type'])) ? strip_tags($new_instance['post_type']) : '';

        return $instance;
    }
//Show Repositories

    public function show_my_related_posts($title, $tax, $count, $post_type){
        global $post;


        $post_terms = wp_get_object_terms($post->ID, 'category', array('fields'=>'ids'));

        $args = array(
            'post_type' => $post_type,
            'post__not_in' => array($post->ID),
            'posts_per_page'   =>   $count,
//            'tax_query' => array(
//                array(
//                    'taxonomy' => $tax,
//                    'field' => 'id',
//                    'terms' => $post_terms
//                )
//            )
        );
        $related_query = new WP_Query($args);

        if($related_query){
            ob_start();
            $output = '<div class="row">';

                while ($related_query->have_posts() ): $related_query->the_post();

                        $output .= require( plugin_dir_path(__FILE__) . '/iws-related-posts-widget-content.php');

                    wp_reset_postdata();
                endwhile;

            $output .= '</div>';
        }else{
            __e('Nothing more to show');
        }
        $output = ob_get_clean();
        //Build the output
        return $output;
    }
}//end of class


