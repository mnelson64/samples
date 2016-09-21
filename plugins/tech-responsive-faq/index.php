<?php
/*
Plugin Name: Tech Responsive FAQ
Plugin URI: http://www.techeffex.com/plugins/faq/
Description: jQuery based scrolling responsive FAQ. 
Version: 1.0.0
Author: Mike Nelson
Author URI: http://www.techeffex.com
License: GPL2
http://www.gnu.org/licenses/gpl-2.0.html
*/

//Custom FAQ Post Type 
function tech_faq() {
    $labels = array(
        'name'               => _x( 'FAQ', 'post type general name' ),
        'singular_name'      => _x( 'FAQ', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'book' ),
        'add_new_item'       => __( 'Add New FAQ' ),
        'edit_item'          => __( 'Edit FAQ' ),
        'new_item'           => __( 'New FAQ Items' ),
        'all_items'          => __( 'All FAQ\'s' ),
        'view_item'          => __( 'View FAQ' ),
        'search_items'       => __( 'Search FAQ' ),
        'not_found'          => __( 'No FAQ Items found' ),
        'not_found_in_trash' => __( 'No FAQ Items found in the Trash' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'FAQs'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds FAQ specific data',
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'query_var'     => true,
        'rewrite'       => true,
        'capability_type'=> 'post',
        'has_archive'   => true,
        'hierarchical'  => true,
        'menu_position' => 20,
        'supports'      => array( 'title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-info',  // Icon Path
    );

    register_post_type( 'faq', $args ); 

        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name'              => _x( 'FAQ Categories', 'taxonomy general name' ),
            'singular_name'     => _x( 'FAQ Category', 'taxonomy singular name' ),
            'search_items'      =>  __( 'Search FAQ Categories' ),
            'all_items'         => __( 'All FAQ Category' ),
            'parent_item'       => __( 'Parent FAQ Category' ),
            'parent_item_colon' => __( 'Parent FAQ Category:' ),
            'edit_item'         => __( 'Edit FAQ Category' ),
            'update_item'       => __( 'Update FAQ Category' ),
            'add_new_item'      => __( 'Add New FAQ Category' ),
            'new_item_name'     => __( 'New FAQ Category Name' ),
            'menu_name'         => __( 'FAQ Category' ),
        );
    
        register_taxonomy('faq_cat',array('faq'), array(
            'hierarchical' => true,
            'labels'       => $labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => array( 'slug' => 'faq_cat' ),
        ));
}

add_action( 'init', 'tech_faq' );

add_filter( 'manage_edit-faq_columns', 'my_faq_columns' ) ;

function my_faq_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'category' => __( 'Category' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_faq_posts_custom_column', 'my_manage_faq_columns', 10, 2 );

function my_manage_faq_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'category' column. */
		case 'category' :

			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'faq_cat' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'faq_cat' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'faq_cat', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'No Category Assigned' );
			}

			break;


		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

// Filter the request to just give posts for the given taxonomy, if applicable.
function taxonomy_filter_restrict_manage_posts() {
    global $typenow;

    // If you only want this to work for your specific post type,
    // check for that $type here and then return.
    // This function, if unmodified, will add the dropdown for each
    // post type / taxonomy combination.

    $post_types = get_post_types( array( '_builtin' => false ) );

    if ( in_array( $typenow, $post_types ) ) {
    	$filters = get_object_taxonomies( $typenow );

        foreach ( $filters as $tax_slug ) {
            $tax_obj = get_taxonomy( $tax_slug );
            wp_dropdown_categories( array(
                'show_option_all' => __('Show All '.$tax_obj->label ),
                'taxonomy' 	  => $tax_slug,
                'name' 		  => $tax_obj->name,
                'orderby' 	  => 'name',
                'selected' 	  => $_GET[$tax_slug],
                'hierarchical' 	  => $tax_obj->hierarchical,
                'show_count' 	  => false,
                'hide_empty' 	  => true
            ) );
        }
    }
}

add_action( 'restrict_manage_posts', 'taxonomy_filter_restrict_manage_posts' );

function taxonomy_filter_post_type_request( $query ) {
  global $pagenow, $typenow;

  if ( 'edit.php' == $pagenow ) {
    $filters = get_object_taxonomies( $typenow );
    foreach ( $filters as $tax_slug ) {
      $var = &$query->query_vars[$tax_slug];
      if ( isset( $var ) ) {
        $term = get_term_by( 'id', $var, $tax_slug );
        $var = $term->slug;
      }
    }
  }
}

add_filter( 'parse_query', 'taxonomy_filter_post_type_request' );

function tech_scripts(){
     if(!is_admin()){
        wp_register_style('h2cweb-jquery-ui-style',plugins_url('/jquery-ui.css', __FILE__ ));
        wp_enqueue_style('h2cweb-jquery-ui-style');
        //wp_enqueue_script('jquery');
        //wp_enqueue_script('jquery-ui-core');
        wp_register_script('h2cweb-custom-js', plugins_url('/accordion.js', __FILE__ ), array('jquery-ui-accordion'),true);
        wp_enqueue_script('h2cweb-custom-js');
    }   
}
add_action( 'init', 'tech_scripts' );


function set_default_category( $post_id ) {

    // Get the terms
    $terms = wp_get_post_terms( $post_id, 'faq_cat');

    // Only set default if no terms are set yet
    if (!$terms) {
        // Assign the default category
        $default_term = get_term_by('slug', 'nocat', 'faq_cat');
        $taxonomy = 'faq_cat';
        wp_set_post_terms( $post_id, $default_term->term_id, $taxonomy );
    }
}
add_action( 'save_post', 'set_default_category' );

function tech_accordion_shortcode() { 
// 


// Getting FAQ Categories
global $wpdb;

$categories = $wpdb->get_results( "SELECT * FROM wp_term_taxonomy AS wptt, wp_terms AS wpt WHERE wptt.taxonomy = 'faq_cat' AND wptt.term_id = wpt.term_id ORDER BY `custom_order`", OBJECT );
foreach ( $categories as $category ) {
	
	//initialize $faq_content
	$faq_content = '';
	// Getting FAQs for this category
	$faqs = $wpdb->get_results( $wpdb->prepare("SELECT * FROM wp_posts AS posts, wp_term_relationships AS tr WHERE tr.object_id = posts.ID AND tr.term_taxonomy_id = '%s' AND posts.post_type = 'faq' AND posts.post_status = 'publish' ORDER BY `menu_order` ASC", $category->term_taxonomy_id ));
	if ($faqs) {
		//global $faq;
		if ($category->name != 'No Category') {
			$faq_content .= '<div class="categoryName">'.$category->name.'</div>';
		}
		//echo $category->term_id;
		$faq_content .= '<div class="accordion">';
		foreach ( $faqs as $faq )  {
			$faq_content .= '<h3><a href="">'.$faq->post_title.'</a></h3><div>'.apply_filters( 'the_content', $faq->post_content).'</div>';
		 } // for each faq
		$faq_content .= '</div>';
		return $faq_content;
	} // if any faqs in cat
} // for each cat


}
add_shortcode('faq', 'tech_accordion_shortcode');

?>