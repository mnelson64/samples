<?php
/*
Plugin Name: Tech Courses
Plugin URI: http://www.techeffex.com/plugins/courses/
Description: Course Manager Plugin. 
Version: 1.0.0
Author: Mike Nelson
Author URI: http://www.techeffex.com
License: GPL2
http://www.gnu.org/licenses/gpl-2.0.html
*/
$daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
//Custom Course Post Type 
function tech_course() {
    $labels = array(
        'name'               => _x( 'Course', 'post type general name' ),
        'singular_name'      => _x( 'Course', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'book' ),
        'add_new_item'       => __( 'Add New Course' ),
        'edit_item'          => __( 'Edit Course' ),
        'new_item'           => __( 'New Course Items' ),
        'all_items'          => __( 'All Courses' ),
        'view_item'          => __( 'View Course' ),
        'search_items'       => __( 'Search Course' ),
        'not_found'          => __( 'No Course Items found' ),
        'not_found_in_trash' => __( 'No Course Items found in the Trash' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Courses'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds Course specific data',
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

    register_post_type( 'course', $args ); 
	


        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name'              => _x( 'Course Categories', 'taxonomy general name' ),
            'singular_name'     => _x( 'Course Category', 'taxonomy singular name' ),
            'search_items'      =>  __( 'Search Course Categories' ),
            'all_items'         => __( 'All Course Category' ),
            'parent_item'       => __( 'Parent Course Category' ),
            'parent_item_colon' => __( 'Parent Course Category:' ),
            'edit_item'         => __( 'Edit Course Category' ),
            'update_item'       => __( 'Update Course Category' ),
            'add_new_item'      => __( 'Add New Course Category' ),
            'new_item_name'     => __( 'New Course Category Name' ),
            'menu_name'         => __( 'Course Category' ),
        );
    
        register_taxonomy('course_cat',array('course'), array(
            'hierarchical' => true,
            'labels'       => $labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => array( 'slug' => 'course_cat' ),
        ));
}

add_action( 'init', 'tech_course' );

// Add the Meta Box
function add_course_meta_box() {
    add_meta_box(
        'course_meta_box', // $id
        'Scheduler', // $title 
        'show_course_meta_box', // $callback
        'course', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_course_meta_box');

// Field Array
$prefix = 'course';
$course_meta_fields = array(
    array(
        'label'=> 'Start Time',
        'desc'  => '',
        'id'    => $prefix.'Start',
        'type'  => 'timeSelect',
        'hourOptions' => array (
				'one' => array (
					'label' => '1',
					'value' => '1'
				),
				'two' => array (
					'label' => '2',
					'value' => '2'
				),
				'three' => array (
					'label' => '3',
					'value' => '3'
				),
				'four' => array (
					'label' => '4',
					'value' => '4'
				),
				'five' => array (
					'label' => '5',
					'value' => '5'
				),
				'six' => array (
					'label' => '6',
					'value' => '6'
				),
				'seven' => array (
					'label' => '7',
					'value' => '7'
				),
				'eight' => array (
					'label' => '8',
					'value' => '8'
				),
				'nine' => array (
					'label' => '9',
					'value' => '9'
				),
				'ten' => array (
					'label' => '10',
					'value' => '10'
				),
				'eleven' => array (
					'label' => '11',
					'value' => '11'
				),
				'twelve' => array (
					'label' => '12',
					'value' => '0'
				)
			),
		'minuteOptions' => array (
				'zero' => array (
					'label' => '00',
					'value' => '00'
				),
				'fifteen' => array (
					'label' => '15',
					'value' => '15'
				),
				'thirty' => array (
					'label' => '30',
					'value' => '30'
				),
				'fortyFive' => array (
					'label' => '45',
					'value' => '45'
				)
				
			),
		'amOptions' => array (
				'am' => array (
					'label' => 'am',
					'value' => 'am'
				),
				'pm' => array (
					'label' => 'pm',
					'value' => 'pm'
				)
			)
			

    ),
	array(
        'label'=> 'End Time',
        'desc'  => '',
        'id'    => $prefix.'End',
        'type'  => 'timeSelect',
        'hourOptions' => array (
				'one' => array (
					'label' => '1',
					'value' => '1'
				),
				'two' => array (
					'label' => '2',
					'value' => '2'
				),
				'three' => array (
					'label' => '3',
					'value' => '3'
				),
				'four' => array (
					'label' => '4',
					'value' => '4'
				),
				'five' => array (
					'label' => '5',
					'value' => '5'
				),
				'six' => array (
					'label' => '6',
					'value' => '6'
				),
				'seven' => array (
					'label' => '7',
					'value' => '7'
				),
				'eight' => array (
					'label' => '8',
					'value' => '8'
				),
				'nine' => array (
					'label' => '9',
					'value' => '9'
				),
				'ten' => array (
					'label' => '10',
					'value' => '10'
				),
				'eleven' => array (
					'label' => '11',
					'value' => '11'
				),
				'twelve' => array (
					'label' => '12',
					'value' => '0'
				)
			),
		'minuteOptions' => array (
				'zero' => array (
					'label' => '00',
					'value' => '00'
				),
				'fifteen' => array (
					'label' => '15',
					'value' => '15'
				),
				'thirty' => array (
					'label' => '30',
					'value' => '30'
				),
				'fortyFive' => array (
					'label' => '45',
					'value' => '45'
				)
				
			),
		'amOptions' => array (
				'am' => array (
					'label' => 'am',
					'value' => 'am'
				),
				'pm' => array (
					'label' => 'pm',
					'value' => 'pm'
				)
			)
			

    ),
    array(
        'label'=> 'Start Date',
        'desc'  => '*Start Date Must Match Date of First Occurrence of a Recurring Event',
        'id'    => $prefix.'StartDate',
        'type'  => 'date'
    ),
	array(
        'label'=> 'End Date',
        'desc'  => 'leave blank for no end date',
        'id'    => $prefix.'EndDate',
        'type'  => 'date'
    ),
	array (
		'label' => 'Recurring Every',
		'desc'  => 'A description for the field.',
		'id'    => $prefix.'Recurrence',
		'type'  => 'recurrence',
		'options' => array (
			'day' => array (
				'label' => 'Day',
				'value' => 'daily'
			),
			'week' => array (
				'label' => 'Week',
				'value' => 'weekly'
			),
			'biweekly' => array (
				'label' => '2 Weeks',
				'value' => 'biweekly'
			),
			'monthly' => array (
				'label' => 'Month',
				'value' => 'monthly'
			),
			'none' => array (
				'label' => 'None',
				'value' => ''
			)
		)
	),
	array(
        'label'=> 'Days of the Week',
        'desc'  => '',
        'id'    => $prefix.'checkbox',
        'type'  => 'dailyCheck'
    ),
	array(
        'label'=> 'Day of the Week',
        'desc'  => '',
        'id'    => $prefix.'checkbox',
        'type'  => 'dailyRadio'
    ),
	array(
        'label'=> 'Week',
        'desc'  => '',
        'id'    => $prefix.'checkbox',
        'type'  => 'weekRadio'
    ),
	array(
        'label'=> 'Day of the Month',
        'desc'  => 'Select a day of the month if you want the course to occur on the same date every month.',
        'id'    => $prefix.'DayOfMonth',
        'type'  => 'dayOfMonth'
    ),
	array(
        'label'=> 'Cost',
        'desc'  => '',
        'id'    => $prefix.'Cost',
        'type'  => 'text'
    )
);

// The Callback
function show_course_meta_box() {

global $course_meta_fields, $post, $daysOfWeek;
// Use nonce for verification
echo '<input type="hidden" name="course_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($course_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
		$recurrence = get_post_meta($post->ID, 'courseRecurrence', true);
		if ($field['type'] == 'dailyCheck') {
			$rowID = 'id="row_day"';
			$init = ('daily' == $recurrence) ? 'style="display:table-row"' : 'style="display:none"';
				
		} elseif ($field['type'] == 'dailyRadio' or $field['type'] == 'weekRadio' or $field['type'] == 'dayOfMonth') {
			$rowID = 'class="row_monthly"';
			$init = ('monthly' == $recurrence) ? 'style="display:table-row"' : 'style="display:none"';
		} else {
			$rowID = '';
			$init = '';
		}
        echo '<tr ', $rowID,' ',$init,'>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // text
					case 'text':
						echo '$<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="10" />
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
							<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// recurrence
					case 'recurrence':
						foreach ( $field['options'] as $key => $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' onClick="displayRecurrence(\''.$key.'\');"/>
								<label for="'.$option['value'].'">'.$option['label'].'</label>&nbsp;&nbsp;';
						}
					break;
					// Days of Week checkboxes
					case 'dailyCheck':
						foreach ($daysOfWeek as $day) {
							$meta = get_post_meta($post->ID, 'course'.$day, true);
							echo '<input type="checkbox" name="course'.$day.'" id="course'.$day.'" ',$meta ? ' checked="checked"' : '','/>
							<label for="course'.$day.'">'.$day.'</label>&nbsp;&nbsp;&nbsp;&nbsp;';
						}
					break;
					// Day of Week radio for monthly
					case 'dailyRadio':
						foreach ($daysOfWeek as $day) {
							$meta = get_post_meta($post->ID, 'courseDayOfWeek', true);
							echo '<input type="radio" name="courseDayOfWeek" id="courseDayOfWeek'.$day.'" value="'.$day.'"',$meta == $day ? ' checked="checked"' : '','/>
							<label for="courseDayOfWeek'.$day.'">'.$day.'</label>&nbsp;&nbsp;&nbsp;&nbsp;';
						}
					break;
					// Week radio for monthly
					case 'weekRadio':
						$meta = get_post_meta($post->ID, 'courseWeek', true);
						echo '<input type="radio" name="courseWeek" id="courseWeek1" value="1"',$meta == 1 ? ' checked="checked"' : '','/>
						<label for="courseWeek1">First Week</label>&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<input type="radio" name="courseWeek" id="courseWeek2" value="2"',$meta == 2 ? ' checked="checked"' : '','/>
						<label for="courseWeek2">Second Week</label>&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<input type="radio" name="courseWeek" id="courseWeek3" value="3"',$meta == 3 ? ' checked="checked"' : '','/>
						<label for="courseWeek3">Third Week</label>&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<input type="radio" name="courseWeek" id="courseWeek4" value="4"',$meta == 4 ? ' checked="checked"' : '','/>
						<label for="courseWeek4">Fourth Week</label>&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<input type="radio" name="courseWeek" id="courseWeek0" value="0"',$meta == 0 ? ' checked="checked"' : '','/>
						<label for="courseWeek0">None</label>&nbsp;&nbsp;&nbsp;&nbsp;';
					break;
					// Day of Month
					case 'dayOfMonth':
						$meta = get_post_meta($post->ID, 'dayOfMonth', true);
						echo '<select name="dayOfMonth" id="dayOfMonth">';
						for ($i = 1; $i < 29; $i++) {
							echo '<option', $meta == $i ? ' selected="selected"' : '', ' value="'.$i.'">'.$i.'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					case 'timeSelect':
						$meta = get_post_meta($post->ID, $field['id'].'Hour', true);
						echo '<select name="'.$field['id'].'Hour" id="'.$field['id'].'Hour">';
						foreach ($field['hourOptions'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select>';
						
						$meta = get_post_meta($post->ID, $field['id'].'Minute', true);
						echo '<select name="'.$field['id'].'Minute" id="'.$field['id'].'Minute">';
						foreach ($field['minuteOptions'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select>';
						
						$meta = get_post_meta($post->ID, $field['id'].'AMPM', true);
						echo '<select name="'.$field['id'].'AMPM" id="'.$field['id'].'AMPM">';
						foreach ($field['amOptions'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select>';
					break;
					// text
					case 'date':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_course_meta($post_id) {
    global $course_meta_fields,$daysOfWeek;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['course_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($course_meta_fields as $field) {
		if ('timeSelect' == $field['type']) {
			//hours
			$old = get_post_meta($post_id, $field['id'].'Hour', true);
			$new = $_POST[$field['id'].'Hour'];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'].'Hour', $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'].'Hour', $old);
			}
			// minutes
			$old = get_post_meta($post_id, $field['id'].'Minute', true);
			$new = $_POST[$field['id'].'Minute'];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'].'Minute', $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'].'Minute', $old);
			}
			// AMPM
			$old = get_post_meta($post_id, $field['id'].'AMPM', true);
			$new = $_POST[$field['id'].'AMPM'];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'].'AMPM', $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'].'AMPM', $old);
			}
			
		} elseif ('dailyCheck' == $field['type']) {
			foreach ($daysOfWeek as $day) {
				$old = get_post_meta($post_id, 'course'.$day, true);
				$new = $_POST['course'.$day];
				if ($new && $new != $old) {
					update_post_meta($post_id, 'course'.$day, $new);
				} elseif ('' == $new && $old) {
					delete_post_meta($post_id, 'course'.$day, $old);
				}
			}
		} elseif ('dailyRadio' == $field['type']) {
			$old = get_post_meta($post_id, 'courseDayOfWeek', true);
			$new = $_POST['courseDayOfWeek'];
			if ($new && $new != $old) {
				update_post_meta($post_id, 'courseDayOfWeek', $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, 'courseDayOfWeek', $old);
			}
		} elseif ('weekRadio' == $field['type']) {
			$old = get_post_meta($post_id, 'courseWeek', true);
			$new = $_POST['courseWeek'];
			if ($new && $new != $old) {
				update_post_meta($post_id, 'courseWeek', $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, 'courseWeek', $old);
			}
		} elseif ('dayOfMonth' == $field['type']) {
			$old = get_post_meta($post_id, 'dayOfMonth', true);
			$new = $_POST['dayOfMonth'];
			if ($new && $new != $old) {
				update_post_meta($post_id, 'dayOfMonth', $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, 'dayOfMonth', $old);
			}	
		} else {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
        
    } // end foreach
}
add_action('save_post', 'save_course_meta');

function tech_course_scripts(){
     if(!is_admin() or true){
        //wp_register_style('tech-course-jquery-ui-style',plugins_url('/jquery-ui.css', __FILE__ ));
        //wp_enqueue_style('tech-course-jquery-ui-style');
        //wp_enqueue_script('jquery');
        //wp_enqueue_script('jquery-ui-core');
		//wp_enqueue_script('jquery-ui-datepicker');
		//wp_enqueue_style( 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );
        wp_register_script('display-recurrence-js', plugins_url('/displayRecurrence.js', __FILE__ ));
        wp_enqueue_script('display-recurrence-js');
		wp_register_script('h2cweb-custom-js', plugins_url('/datePicker.js', __FILE__ ));
        wp_enqueue_script('h2cweb-custom-js');
    }   
}
add_action( 'init', 'tech_course_scripts' );

add_filter( 'manage_edit-course_columns', 'my_course_columns' ) ;

function my_course_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'category' => __( 'Category' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_course_posts_custom_column', 'my_manage_course_columns', 10, 2 );

function my_manage_course_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'category' column. */
		case 'category' :

			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'course_cat' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'course_cat' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'course_cat', 'display' ) )
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

function set_course_default_category( $post_id ) {

    // Get the terms
    $terms = wp_get_post_terms( $post_id, 'course_cat');

    // Only set default if no terms are set yet
    if (!$terms) {
        // Assign the default category
        $default_term = get_term_by('slug', 'nocat', 'course_cat');
        $taxonomy = 'course_cat';
        wp_set_post_terms( $post_id, $default_term->term_id, $taxonomy );
    }
}
add_action( 'save_post', 'set_course_default_category' );

function tech_accordion_course_shortcode() { 
// 


// Getting FAQ Categories
global $wpdb;
//initialize $course_content
$course_content = '';
$categories = $wpdb->get_results( "SELECT * FROM wp_term_taxonomy AS wptt, wp_terms AS wpt WHERE wptt.taxonomy = 'course_cat' AND wptt.term_id = wpt.term_id ORDER BY `custom_order`", OBJECT );
foreach ( $categories as $category ) {
	
	// Getting FAQs for this category
	$courses = $wpdb->get_results( $wpdb->prepare("SELECT * FROM wp_posts AS posts, wp_term_relationships AS tr WHERE tr.object_id = posts.ID AND tr.term_taxonomy_id = '%s' AND posts.post_type = 'course' AND posts.post_status = 'publish' ORDER BY `menu_order` ASC", $category->term_taxonomy_id ));
	if ($courses) {
		$course_content .= '<div class="courseCategoryUnit">';
		$imageContent = fifc_get_tax_thumbnail($category->term_id,'course_cat','thumbnail');
		$course_content .= '<div class="courseCategoryThumb"><img src="'.$imageContent.'"></div>';
		//global $course;
		if ($category->name != 'No Category') {
			$course_content .= '<div class="courseCategoryName">'.$category->name.'</div>';
		}
		$course_content .= '<div class="courseEntryArea">';
		foreach ( $courses as $course )  {
			
			$course_url = $wpdb->get_results( $wpdb->prepare("SELECT * FROM wp_postmeta WHERE `post_id` = '%s' AND `meta_key` = 'course_url'", $course->ID ),OBJECT);
			$course_content .= '<div class="courseEntry"><a href="'.$course_url[0]->meta_value.'" target="_blank">'.$course->post_title.'</a></div>';
		 } // for each course
		$course_content .= '</div>'; //courseEntryArea
		$course_content .= '</div>'; //courseCategoryUnit
		
	} // if any courses in cat
} // for each cat

return $course_content;

}
add_shortcode('course', 'tech_accordion_course_shortcode');

?>