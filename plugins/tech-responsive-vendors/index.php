<?php
/*
Plugin Name: Tech Responsive Vendors
Plugin URI: http://www.techeffex.com/plugins/vendors/
Description: Categorized Vendor List Plugin. 
Version: 1.0.0
Author: Mike Nelson
Author URI: http://www.techeffex.com
License: GPL2
http://www.gnu.org/licenses/gpl-2.0.html
*/

//Custom Vendor Post Type 
function tech_vendor() {
    $labels = array(
        'name'               => _x( 'Vendor', 'post type general name' ),
        'singular_name'      => _x( 'Vendor', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'book' ),
        'add_new_item'       => __( 'Add New Vendor' ),
        'edit_item'          => __( 'Edit Vendor' ),
        'new_item'           => __( 'New Vendor Items' ),
        'all_items'          => __( 'All Vendor\'s' ),
        'view_item'          => __( 'View Vendor' ),
        'search_items'       => __( 'Search Vendor' ),
        'not_found'          => __( 'No Vendor Items found' ),
        'not_found_in_trash' => __( 'No Vendor Items found in the Trash' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Vendors'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds Vendor specific data',
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
        'menu_icon' 	=> 'dashicons-businessman',  // Icon Path
    );

    register_post_type( 'vendor', $args ); 

        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name'              => _x( 'Vendor Categories', 'taxonomy general name' ),
            'singular_name'     => _x( 'Vendor Category', 'taxonomy singular name' ),
            'search_items'      =>  __( 'Search Vendor Categories' ),
            'all_items'         => __( 'All Vendor Category' ),
            'parent_item'       => __( 'Parent Vendor Category' ),
            'parent_item_colon' => __( 'Parent Vendor Category:' ),
            'edit_item'         => __( 'Edit Vendor Category' ),
            'update_item'       => __( 'Update Vendor Category' ),
            'add_new_item'      => __( 'Add New Vendor Category' ),
            'new_item_name'     => __( 'New Vendor Category Name' ),
            'menu_name'         => __( 'Vendor Category' ),
        );
    
        register_taxonomy('vendor_cat',array('vendor'), array(
            'hierarchical' => true,
            'labels'       => $labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => array( 'slug' => 'vendor_cat' ),
        ));
}

add_action( 'init', 'tech_vendor' );

function tech_vendor_scripts(){
     if(!is_admin()){
        wp_register_style('tech-vendor-jquery-ui-style',plugins_url('/jquery-ui.css', __FILE__ ));
        wp_enqueue_style('tech-vendor-jquery-ui-style');
        //wp_enqueue_script('jquery');
        //wp_enqueue_script('jquery-ui-core');
        //wp_register_script('h2cweb-custom-js', plugins_url('/accordion.js', __FILE__ ), array('jquery-ui-accordion'),true);
        //wp_enqueue_script('h2cweb-custom-js');
    }   
}
add_action( 'init', 'tech_vendor_scripts' );

add_filter( 'manage_edit-vendor_columns', 'my_vendor_columns' ) ;

function my_vendor_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'category' => __( 'Category' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_vendor_posts_custom_column', 'my_manage_vendor_columns', 10, 2 );

function my_manage_vendor_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'category' column. */
		case 'category' :

			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'vendor_cat' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'vendor_cat' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'vendor_cat', 'display' ) )
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
/*function taxonomy_filter_restrict_manage_posts() {
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

add_filter( 'parse_query', 'taxonomy_filter_post_type_request' );*/

function set_vendor_default_category( $post_id ) {

    // Get the terms
    $terms = wp_get_post_terms( $post_id, 'vendor_cat');

    // Only set default if no terms are set yet
    if (!$terms) {
        // Assign the default category
        $default_term = get_term_by('slug', 'nocat', 'vendor_cat');
        $taxonomy = 'vendor_cat';
        wp_set_post_terms( $post_id, $default_term->term_id, $taxonomy );
    }
}
add_action( 'save_post', 'set_vendor_default_category' );

function tech_accordion_vendor_shortcode() { 
// 


// Getting FAQ Categories
global $wpdb;
//initialize $vendor_content
$vendor_content = '';
$categories = $wpdb->get_results( "SELECT * FROM wp_term_taxonomy AS wptt, wp_terms AS wpt WHERE wptt.taxonomy = 'vendor_cat' AND wptt.term_id = wpt.term_id ORDER BY `custom_order`", OBJECT );
foreach ( $categories as $category ) {
	
	// Getting FAQs for this category
	$vendors = $wpdb->get_results( $wpdb->prepare("SELECT * FROM wp_posts AS posts, wp_term_relationships AS tr WHERE tr.object_id = posts.ID AND tr.term_taxonomy_id = '%s' AND posts.post_type = 'vendor' AND posts.post_status = 'publish' ORDER BY `menu_order` ASC", $category->term_taxonomy_id ));
	if ($vendors) {
		$vendor_content .= '<div class="vendorCategoryUnit">';
		$imageContent = fifc_get_tax_thumbnail($category->term_id,'vendor_cat','thumbnail');
		$vendor_content .= '<div class="vendorCategoryThumb"><img src="'.$imageContent.'"></div>';
		//global $vendor;
		if ($category->name != 'No Category') {
			$vendor_content .= '<div class="vendorCategoryName">'.$category->name.'</div>';
		}
		$vendor_content .= '<div class="vendorEntryArea">';
		foreach ( $vendors as $vendor )  {
			
			$vendor_url = $wpdb->get_results( $wpdb->prepare("SELECT * FROM wp_postmeta WHERE `post_id` = '%s' AND `meta_key` = 'vendor_url'", $vendor->ID ),OBJECT);
			$vendor_content .= '<div class="vendorEntry"><a href="'.$vendor_url[0]->meta_value.'" target="_blank">'.$vendor->post_title.'</a></div>';
		 } // for each vendor
		$vendor_content .= '</div>'; //vendorEntryArea
		$vendor_content .= '</div>'; //vendorCategoryUnit
		
	} // if any vendors in cat
} // for each cat

return $vendor_content;

}
add_shortcode('vendor', 'tech_accordion_vendor_shortcode');

?>