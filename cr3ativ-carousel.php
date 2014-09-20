<?php
/**
 * Plugin Name: Cr3ativ Carousel Plugin
 * Plugin URI: https://cr3ativ.com/cr3ativportfolio/carousel
 * Description: Custom written plugin to add carousels by category to your WordPress site.
 * Author: Cr3ativ
 * Author URI: http://cr3ativ.com/
 * Version: 1.0.3
 */

/* Place custom code below this line. */

/* Variables */
$ja_cr3ativ_carousel_main_file = dirname(__FILE__).'/cr3ativ-carousel.php';
$ja_cr3ativ_carousel_directory = plugin_dir_url($ja_cr3ativ_carousel_main_file);
$ja_creativ_carousel_path = dirname(__FILE__);

/* Add css and scripts file */
function creativ_carousel_add_scripts() {
	global $ja_cr3ativ_carousel_directory, $ja_creativ_carousel_path;
		wp_enqueue_style('creativ_carousel_styles', $ja_cr3ativ_carousel_directory.'css/owl.carousel.css');
        wp_enqueue_style('creativ_carousel_transitions', $ja_cr3ativ_carousel_directory.'css/owl.transitions.css');
        wp_enqueue_style('creativ_carousel_theme', $ja_cr3ativ_carousel_directory.'css/owl.theme.css');
		wp_enqueue_script('jquery');
		wp_register_script('creativ_carousel_js', $ja_cr3ativ_carousel_directory.'js/owl.carousel.js', 'jquery');
		wp_register_script('creativ_carousel_script_js', $ja_cr3ativ_carousel_directory.'js/owl.script.js', 'jquery');
		wp_enqueue_script('creativ_carousel_js');
        wp_enqueue_script('creativ_carousel_script_js');
}
		
add_action('wp_enqueue_scripts', 'creativ_carousel_add_scripts');





add_action('admin_head', 'cr3ativcarousel_custom_css');

function cr3ativcarousel_custom_css() {
  echo '<style>
    .carouselcontent img {
    height: 100%;
    max-width: 50%;
} 
  </style>';
}

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////       WP Default Functionality       ////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
add_theme_support( 'post-thumbnails' );


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Text Domain     /////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
load_plugin_textdomain('cr3atcarousel', false, basename( dirname( __FILE__ ) ) . '/languages' );


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Portfolio post type     /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
add_action('init', 'create_cr3ativcarousel');

function create_cr3ativcarousel() {
	
	$labels = array(
		'name' => __('Carousel Item', 'post type general name', 'cr3atcarousel'),
		'singular_name' => __('Carousel', 'post type singular name', 'cr3atcarousel'),
		'add_new' => __('Add New Carousel', 'carousel', 'cr3atcarousel'),
		'add_new_item' => __('Add New Carousel', 'cr3atcarousel'),
		'edit_item' => __('Edit Carousel', 'cr3atcarousel'),
		'new_item' => __('New Carousel', 'cr3atcarousel'),
		'view_item' => __('View Carousel', 'cr3atcarousel'),
		'search_items' => __('Search Carousel', 'cr3atcarousel'),
		'not_found' =>  __('Nothing found', 'cr3atcarousel'),
		'not_found_in_trash' => __('Nothing found in Trash', 'cr3atcarousel'),
		'parent_item_colon' => __('Carousel', 'cr3atcarousel')
	);
	
    	$carousel_args = array(
        	'labels' => $labels,
        	'public' => true,
            'menu_icon' => 'dashicons-slides',
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor')
        );
    	register_post_type('cr3ativcarousel',$carousel_args);
	}


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////     Custom taxonomies     ///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


add_action( 'init', 'cr3ativcarousel_type', 0 );
function cr3ativcarousel_type()	{
	register_taxonomy( 
		'cr3ativcarousel_type', 
		'cr3ativcarousel', 
			array( 
				'hierarchical' => true, 
				'label' => __('Carousel Category', 'cr3atcarousel'),
				'query_var' => true, 
				'rewrite' => array( 'slug' => 'carousel-category' ),
                'show_admin_column' => true
			) 
	);
 
}


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////       Shortcode Loop      ///////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


// Taxonomy category shortcode
function cat_func($atts) {
    extract(shortcode_atts(array(
            'columns'    => '4',
            'category'      => ''
            ), $atts));
if( $columns == '1' ) {
$output = '<div class="1-column">';
;} elseif ( $columns == '2' ) {
$output = '<div class="2-column">';  
;} elseif ( $columns == '3' ) {    
$output = '<div class="3-column">';     
;} else {    
$output = '<div class="4-column">';  
}
    global $post;
    $args = array(
        'post_type' => 'cr3ativcarousel',
        'tax_query' => array(
            array(
                'taxonomy' => 'cr3ativcarousel_type',
                'field' => 'slug',
                'terms' => array( $category)
            )
        ));
    $myposts = NEW WP_Query($args);

    while($myposts->have_posts()) {
        $myposts->the_post(); $content = $post->post_content; $content = apply_filters('the_content', $content);
        $output .= '<div>'.$content.'</div>';
    }; 
    $output .= '</div>';
    wp_reset_query();
    return $output;
}
add_shortcode('carousel-loop', 'cat_func');


////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////             Carousel widget                 /////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


include_once( 'cr3ativ-carousel-widget.php' );



add_filter( 'manage_edit-cr3ativcarousel_columns', 'my_edit_cr3ativcarousel_columns' ) ;

function my_edit_cr3ativcarousel_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
        'date' => __( 'Date Created', 'cr3atcarousel' ),
		'title' => __( 'Carousel Name', 'cr3atcarousel' ),
        'carouselcontent' => __( 'Carousel Item' , 'cr3atcarousel'),
        'carouselcategory' => __( 'Carousel Category' , 'cr3atcarousel')
	);

	return $columns;
}

add_action( 'manage_cr3ativcarousel_posts_custom_column', 'my_manage_cr3ativcarousel_columns', 10, 2 );

function my_manage_cr3ativcarousel_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
        
		case 'carouselcontent' :

			 the_content ();
			break;
        
		case 'carouselcategory' :

			$terms = get_the_terms( $post_id, 'cr3ativcarousel_type' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'cr3ativcarousel_type' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'cr3ativcarousel_type', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

?>