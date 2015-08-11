<?php 

class cr3ativ_carousel extends WP_Widget {

	// constructor
	function cr3ativ_carousel() {
        parent::__construct(false, $name = __('Carousel Loop', 'cr3atcarousel') );
    }

	// widget form creation
	function form($instance) { 
// Check values
 if( $instance) { 
     $title = esc_attr($instance['title']); 
     $numbertodisplay = esc_attr($instance['numbertodisplay']); 
     $sortby = esc_attr($instance['sortby']); 
     $carousel_category = esc_attr($instance['carousel_category']);
} else { 
     $title = ''; 
     $numbertodisplay = ''; 
     $sortby = '';
     $carousel_category = '';
} 
?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'cr3atcarousel'); ?></label>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" style="float:right; width:56%;" />
</p>
<p>
<label for="<?php echo $this->get_field_id('numbertodisplay'); ?>"><?php _e('# of Columns', 'cr3atcarousel'); ?></label>
<select id="<?php echo $this->get_field_id('numbertodisplay'); ?>" name="<?php echo $this->get_field_name('numbertodisplay'); ?>"  style="float:right; width:56%;">
    <option selected="selected" value="none"><?php _e( 'Select One', 'cr3atcarousel' ); ?></option>
    <option <?php if ( $numbertodisplay == '1' ) { echo ' selected="selected"'; } ?> value="1"><?php _e( 'One Column', 'cr3atcarousel' ); ?></option>
    <option <?php if ( $numbertodisplay == '2' ) { echo ' selected="selected"'; } ?> value="2"><?php _e( 'Two Column', 'cr3atcarousel' ); ?></option>
    <option <?php if ( $numbertodisplay == '3' ) { echo ' selected="selected"'; } ?> value="3"><?php _e( 'Three Column', 'cr3atcarousel' ); ?></option>
    <option <?php if ( $numbertodisplay == '4' ) { echo ' selected="selected"'; } ?> value="4"><?php _e( 'Four Column', 'cr3atcarousel' ); ?></option>
</select>
</p>
<p>
<label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e('Sort by ASC?', 'cr3atcarousel'); ?></label>
<input id="<?php echo $this->get_field_id('sortby'); ?>" name="<?php echo $this->get_field_name('sortby'); ?>" type="checkbox" value="1" <?php checked( '1', $sortby ); ?> style="float:right; margin-right:6px;" />
</p>
<p>
<label for="<?php echo $this->get_field_id('carousel_category'); ?>"><?php _e('Carousel category', 'cr3atcarousel'); ?></label>
<select id="<?php echo $this->get_field_id('carousel_category'); ?>" name="<?php echo $this->get_field_name('carousel_category'); ?>"  style="float:right; width:56%;" >
    <option selected="selected" value="none"><?php _e( 'Select One', 'cr3atcarousel' ); ?></option>
    <?php $terms = get_terms( 'cr3ativcarousel_type' ); ?> 
    <?php foreach ( $terms as $term ) { ?>
    <option<?php if ( $carousel_category == $term->slug ) { echo ' selected="selected"'; } ?> value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
    <?php } ?>
</select>
</p>
            
<?php }
	// widget update
	function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['numbertodisplay'] = $new_instance['numbertodisplay'];
      $instance['sortby'] = strip_tags($new_instance['sortby']);
      $instance['carousel_category'] = $new_instance['carousel_category'];
     return $instance;
}

	// widget display
	function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);
   $numbertodisplay = $instance['numbertodisplay'];
   $carousel_category = $instance['carousel_category'];
   $sortby = $instance['sortby'];
   echo $before_widget;
   if( $sortby == '1' ) {
   $sortby = 'ASC';
   } else {
   $sortby = 'DESC';
   }
      
		global $post;  
		$carousel = array(
		'post_type' => 'cr3ativcarousel',
		'order' => $sortby,
        'posts_per_page' => 999999,
        'tax_query' => array(
            array(
                'taxonomy' => 'cr3ativcarousel_type',
                'field' => 'slug',
                'terms' => array( $carousel_category)
            )),
		);   
   
   // Check if title is set
   if ( $title ) {
      echo $before_title . $title . $after_title;
   }	
   
   // Display the widget
?> 
<?php if( $numbertodisplay == '1' ) { ?>
<div class="1-column">
<?php ;} elseif ( $numbertodisplay == '2' ) { ?>
<div class="2-column">    
<?php ;} elseif ( $numbertodisplay == '3' ) { ?>    
<div class="3-column">       
<?php ;} else { ?>    
<div class="4-column">   
<?php ;} ?>   

    <?php query_posts($carousel); if (have_posts()) : while (have_posts()) : the_post(); ?>
        
<div>

<?php the_content (); ?>

</div>

<?php endwhile; ?>
    
<?php else: ?> 
<p><?php _e( 'There are no posts to display. Try using the search.', 'cr3atcarousel' ); ?></p> 

<?php endif; ?><?php wp_reset_query(); ?>
</div>
  
<?php     
   
   echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("cr3ativ_carousel");'));


?>