<?php
/*
Plugin Name: LCCC Proud
Plugin URI: https://www.lcccproud.com
Description: Site Specific Plugin - Includes: Admin Menu Dashboard Widget
Version: 0.1
Author: Lorain County Community College
Author Email: webmaster@lorainccc.edu
License:

  Copyright 2011 Lorain County Community College (webmaster@lorainccc.edu)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

//LCCC Dashboard Widget

add_action('wp_dashboard_setup', 'lccc_admin_dashboard_widgets');
 
function lccc_admin_dashboard_widgets() {
global $wp_meta_boxes;

wp_add_dashboard_widget('lccc_help_widget', 'Web Site Support', 'lccc_help_widget');

 	// Globalize the metaboxes array, this holds all the widgets for wp-admin
 
 	global $wp_meta_boxes;
 	
 	// Get the regular dashboard widgets array 
 	// (which has our new widget already but at the end)
 
 	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
 	
 	// Backup and delete our new dashboard widget from the end of the array
	
 	$lccc_widget_backup = array( 'lccc_help_widget' => $normal_dashboard['lccc_help_widget'] );
 	unset( $normal_dashboard['lccc_help_widget'] );
 
 	// Merge the two arrays together so our widget is at the beginning
 
 	$sorted_dashboard = array_merge( $lccc_widget_backup, $normal_dashboard );
 
 	// Save the sorted array back into the original metaboxes 
 
 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}

function lccc_help_widget() {
echo '<h1>Welcome to LCCC Proud!</h1>
<p><strong>Need help? <br />Please contact either</strong>
<ul style="list-style: disc; margin: 0 0 0 40px;">
<li> <strong>Joe Querin</strong> at <a href="mailto:yourusername@gmail.com">jquerin@lorainccc.edu</a> or ext 7060.</li>
<li> <strong>Lori Martin</strong> at <a href="mailto:lmartin@lorainccc.edu">lmartin@lorainccc.edu</a> or ext 7070.</li>
</ul>
</p>
<p>For WordPress Tutorials visit: <a href="http://www.wpbeginner.com" target="_blank">WPBeginner</a></p>
<img src="/wp-content/plugins/lccc_proud/images/lccc_proud_logo.png" style="margin: 0 0 0 100px;" alt="LCCC Proud Logo">';
}
function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(/wp-content/plugins/lccc_proud/images/lccc_proud_logo.png);
            padding-bottom: 30px;
			background-size: 375px 85px;
			background-position: center top;
			background-repeat: no-repeat;
			color: #999;
			height: 85px;
			font-size: 20px;
			font-weight: normal;
			line-height: 1.3em;
			margin: 0 auto 25px;
			padding: 0;
			text-decoration: none;
			width: 375px;
			text-indent: -9999px;
			outline: none;
			overflow: hidden;
			display: block;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// Register Custom Post Type
function custom_sidebar_image() {

	$labels = array(
		'name'                => _x( 'Random Sidebar Images', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'random sidebar image', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Random Siderbar Image', 'text_domain' ),
		'name_admin_bar'      => __( 'Random Siderbar Images', 'text_domain' ),
		'parent_item_colon'   => __( 'Random Siderbar Image', 'text_domain' ),
		'all_items'           => __( 'All Random Siderbar Images', 'text_domain' ),
		'add_new_item'        => __( 'Add Random Siderbar Image', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Random Siderbar Image', 'text_domain' ),
		'edit_item'           => __( 'Edit Random Siderbar Image', 'text_domain' ),
		'update_item'         => __( 'Update Image', 'text_domain' ),
		'view_item'           => __( 'View Image', 'text_domain' ),
		'search_items'        => __( 'Search Random Siderbar Image', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'random sidebar image', 'text_domain' ),
		'description'         => __( 'Creates a random sidebar image for the desktop version of LCCCPROUD.com', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'post-formats', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'random_sidebar_image', $args );

}
add_action( 'init', 'custom_sidebar_image', 0 );
class RandomSidebarImageWidget extends WP_Widget {
	function RandomSidebarImageWidget() {
		// Instantiate the parent object
		parent::__construct( false, 'LCCC Random Sidebar Image Widget' );
	}//closes the function MYNewWidget
	function widget( $args, $instance ) {
		// Widget output
	global $wpdb; // Globalize the $wpdb object so you can use it
		// set the default timezone to use. Available since PHP 5.1
		date_default_timezone_set('America/New_York'); 
		global $post;
			$LCP_image_args = array(
 				'post_type'        => 'random_sidebar_image',
  				'post_status' => 'publish',
  				'numberposts' => 1
			);
			$mysbimages = get_posts($LCP_image_args);
			foreach( $mysbimages as $post ) : setup_postdata($post);	
			?>
	<div class="randomimage show-for-large-up">
	<?php the_post_thumbnail('sidebar_image'); ?>
	</div>
<?php
			endforeach;		
	}
	function update( $new_instance, $old_instance ) {
		// Save widget options
	}//closes the function update

	function form( $instance ) {
		// Output admin widget options form
	}//closes function form
}
function random_side_bar_image_register_widgets() {
	register_widget( 'RandomSidebarImageWidget' );
}//clsoes the register function
add_action( 'widgets_init', 'random_side_bar_image_register_widgets' );
?>