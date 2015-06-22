<?php
/*
Plugin Name: Perfect Accordion
Plugin URI: http://demo.themeultra.com/wp-plugin/perfect-accordion/
Description: This is a awesome Accordion Plugin for your wordpress website. If you need any kind of support you can ask in our official website <a taget="blank" href="http://www.themeultra.com/support/">Ask Question</a>. To setup this plugin Read the <a target="blank" href="http://demo.themeultra.com/wp-plugin/perfect-accordion/">Documentation</a>. To view Demo <a target="blank" href="">Click-Here</a>   
Author: ThemeUltra.com
Version: 2.0.1
Author URI: http://www.themeultra.com
*/

function accordion_plugin_main_js() {
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'acordion-js', plugins_url( '/js/accordion.js', __FILE__ ), array('jquery'), 1.0, false);
	wp_enqueue_style( 'acordion-style', plugins_url('/css/acordion-style.css', __FILE__ ) );
}
add_action('init','accordion_plugin_main_js');

function accordion_active () {?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.ultra-accord').raaccordion(); 
		}); 	
	</script>
<?php
}
add_action('wp_head','accordion_active');

function accordion_post() {
$labels = array(
	'name'               => _x( 'Accordions', 'post type general name' ),
	'singular_name'      => _x( 'Accordion', 'post type singular name' ),
	'add_new'            => _x( 'Add New Accordion', 'book' ),
	'menu_icon'          => plugins_url( '/images/accordion.png', __FILE__  ),
	'edit_item'          => __( 'Edit Accordion' ),
	'new_item'           => __( 'New Accordion Item' ),
	'all_items'          => __( 'All Accordion' ),
	'view_item'          => __( 'View Accordion' ),
	'search_items'       => __( 'Search Accordion' ),
	'not_found'          => __( 'No Accordion found' ),
	'not_found_in_trash' => __( 'No Accordion found in the Trash' ), 
	'parent_item_colon'  => '',
	'menu_name'          => 'Accordion'
);
$args = array(
	'labels'        => $labels,
	'description'   => 'Holds our products and product specific data',
	'public'        => true,
	'menu_position' => 6,
	'supports'      => array( 'title', 'editor','custom-fields'),
	'has_archive'   => true,
	'rewrite' 		=> array('slug' => 'accordion-item'),
	'menu_icon' 	=> plugins_url( '/img/accordion.png', __FILE__ ), // 16px16
);
register_post_type( 'accordion_posts', $args );	
}
add_action( 'init', 'accordion_post' ); 

//require_once('set-api.php');

function accordion_markup_test($atts){
	extract( shortcode_atts( array(
		'post_from' => 'accordion_post',
		'count' => '-1',
		'class' => 'ultra-accordion',
		'sticky' => 'yes',
	), $atts, 'projects' ) );
	
	if($sticky == 'no'){ $ultra_post = 'sticky_posts';}
	
	$q = new WP_Query(
		array('posts_per_page' => $count, 'post_type' => $post_from, 'post__not_in' => get_option(''.$ultra_post.''))
		);		
		
		
	$list = '<div class="'.$class.'">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$list .= '
		
			<div class="ultra-accord">
				<div class="title">'.get_the_title().'</div>
				<div class="content">
					'.get_the_content().'
				</div>
			</div>
		';        
	endwhile;
	$list.= '</div>';
	wp_reset_query();
	return $list;
}
add_shortcode('accordion', 'accordion_markup_test');


/* Shortcode Support for Text widget */
add_filter('widget_text', 'do_shortcode');


?>