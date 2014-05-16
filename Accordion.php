<?php
/*
Plugin Name: Perfect Accordion
Plugin URI: http://laptopidea.com/perfect-accordion-demo/
Description: This is Accordion Plugin. You can use it for various purpose via using Shortcode.  
Author: Khurshid Alam Mojumder
Version: 1.0
Author URI: http://www.fb.com/sozan.mojumder
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
			jQuery('.accord').raaccordion(); 
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
	'rewrite' => array('slug' => 'accordion-item'),
);
register_post_type( 'accordion_posts', $args );	
}
add_action( 'init', 'accordion_post' ); 



function accordion_markup_test($atts){
	extract( shortcode_atts( array(
		'post_from' => 'accordion_post',
		'count' => '5',
	), $atts, 'projects' ) );
	
	$q = new WP_Query(
		array('posts_per_page' => $count, 'post_type' => $post_from)
		);		
		
		
	$list = '<div>';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$list .= '
		
			<div class="accord">
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
?>