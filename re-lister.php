<?php
/* Plugin Name: RE Lister by CustomScripts
Plugin URI: https://wordpress.org/plugins/re-lister
Description: Easily create and display real estate listings, complete with MLS information, property details, agent info and more. Includes convenient shortcodes. Based on the Zillow Interchange Format.
Version: 2.1
Stable tag: 2.1
Author: CustomScripts
Author URI: https://customscripts.tech

Copyright 2009-2017  Christopher Buck  (email : support@customscripts.tech)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//==========================================================//
/*    DEPENDENCIES    */
//==========================================================//

/* Require the dependent plugin, RE-Lister (wordpress.org/plugins/re-lister) */

require_once dirname( __FILE__ ) . '/assets/php/tgm-plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'cst_rel_register_required_plugins' );

function cst_rel_register_required_plugins() {
    $plugins = array(
        array(
        'name' => 'RE Feed',
        'slug' => 're-feed',
        'required' => false
        ),
    );
    
    $config = array(
		'id'           => 're-lister',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',  
    );
    
    tgmpa( $plugins, $config );
}

/**
  * Init Actions
  *
  */

add_action( 'init', 'cst_rel_listings_init' );
add_action( 'init', 'cst_rel_meta_styling' );
add_action( 'init', 'cst_rel_doc_styling' );
add_action( 'init', 'cst_rel_custom_taxonomy' );


//Meta Styling
function cst_rel_meta_styling(){
    add_action( 'admin_print_styles', 'cst_rel_enqueue_meta_styling' );
}
function cst_rel_enqueue_meta_styling(){
    wp_enqueue_style( 'cst_rel_meta', plugins_url( '/assets/css/meta-wrapper.css', __FILE__ ) );
}
//Doc Styling
function cst_rel_doc_styling(){
    add_action( 'admin_print_styles', 'cst_rel_enqueue_doc_styling' );
}
function cst_rel_enqueue_doc_styling(){
    wp_enqueue_style( 'cst_rel_doc', plugins_url( '/assets/css/doc-wrapper.css', __FILE__ ) );
}

//jQuery for metabox
add_action( 'init', 'cst_rel_enqueue_meta_script' );
function cst_rel_enqueue_meta_script(){
    //enqueue in footer
    wp_enqueue_script( 'responsive-meta', plugins_url( 'assets/js/metabox/responsive.js' , __FILE__ ), array( 'jquery' ), '1.1', true );
}

/**
  * Menu Actions
  *
  */
add_action( 'admin_menu', 'cst_rel_add_documentation_page');
function cst_rel_add_documentation_page(){
    add_submenu_page( 'edit.php?post_type=listings', 'Documentation', 'Documentation', 'manage_options', 'documentation', 'cst_rel_documentation_page' );
}
function cst_rel_documentation_page(){
    /* Include Documentation Page */
    include_once('assets/php/documentation.php');
}

/**
  * Admin Init Actions
  *
  */

add_action('admin_init', 'cst_rel_add_listings_metaboxes');  

function cst_rel_listings_init(){
    $listing_args = array(
        'public' => true,
        'query_var' => 'listings',
        'rewrite' => array(
            'slug' => 'listings',
            'with_front' => false,
        ),
        'supports' => array(
            'title',
            'editor',
            'author',
            'excerpt',
            'page-attributes',
        ),
        'taxonomies' => array( 'listings' ),
        'hierarchical' => true,
        'has_archive' => true,
        'labels' => array(
            'name' => 'Listings',
            'singular_name' => 'Listing',
            'add_new' => 'Create Listing',
            'add_new_item' => 'Create Listing',
            'edit_item' => 'Edit Listing',
            'new_item' => 'New Listing',
            'view_item' => 'View Listing',
            'search_items' => 'Search Listings',
            'not_found' => 'No Listings Found',
            'not_found_in_trash' => 'No Listings Found in Trash',
        ),
        'menu_icon' => 'dashicons-admin-home',

    );
    
    register_post_type( 'listings', $listing_args);
}

/* Custom Taxonomy */
function cst_rel_custom_taxonomy(){
    register_taxonomy( 'listings', 'listings',
    array(
        'labels' => array(
            'name'          => ( 'Categories' ),
            'singular_name' => ( 'Category' ),
            'add_new_item'  => __( 'Add New Listing Category' ),
            'new_item_name' => __( 'New Listing' ),
        ),
        'exclude_from_search' => true,
        'has_archive'         => true,
        'hierarchical'        => true,
        'rewrite'             => array( 'slug' => 'listings', 'with_front' => true ),
        'show_ui'             => true,
        'show_tagcloud'       => false,
    ));
}

/* Include Shortcodes */
include_once('assets/php/shortcodes.php');
add_shortcode( 'listing', 'cst_rel_listing_shortcode' );

/* Include Field Definitions */
include_once('assets/php/fields.php');

/* Nonce Function */
function cst_rel_nonce($field_name){
    wp_nonce_field( $field_name, $field_name . '_nonce' );
}

/* Set Text Field */
function cst_rel_set_text_field( $label, $is_single, $max_length, $size, $column, $required, $basic_data, $escaped, $parent ){
    $output = array(
        'label' => $label,
        'input_type' => 'text',
        'is_single' => $is_single,
        'max_length' => $max_length,
        'size' => $size,
        'column' => $column,
        'required' => $required,
        'basic_data' => $basic_data,
        'escaped' => $escaped,
        'parent' => $parent,
    );
    return $output;
}

/* Set Select Field */
function cst_rel_set_select_field( $label, $is_single, $column, $required, $basic_data, $choices, $default, $class, $parent ){
    $output = array(
        'label' => $label,
        'input_type' => 'select',
        'is_single' => $is_single,
        'column' => $column,
        'required' => $required,
        'basic_data' => $basic_data,
        'choices' => $choices,
        'default' => $default,
        'class' => $class,
        'parent' => $parent,
    );
    return $output;
}

/* Set Checkbox Field */
function cst_rel_set_checkbox_field( $label, $column, $required, $default, $parent ){
    $output = array(
        'label' => $label,
        'input_type' => 'checkbox',
        'column' => $column,
        'required' => $required,
        'default' => $default,
        'parent' => $parent,
    );
    return $output;
}

/* Set Sublabel */
function cst_rel_set_sublabel ( $label, $input_type, $parent ){
    $output = array(
        'label' => $label,
        'input_type' => $input_type,
        'parent' => $parent,
    );
    return $output;
}

/* Create Text Field */
function cst_rel_create_text_input( $field ){
    global $post_id;
    
    $output = '';
    $fld;
    
    $pref = 'cst_rel_meta_';
    $field_name = '_' . $pref . strtolower( str_replace( " ", "_", $field["parent"] ) ) . '_' . strtolower( str_replace( "/", "_", str_replace ( " ", "_", $field["label"] ) ) );
    cst_rel_nonce($field_name);
    
    if ( $field["required"] == 'yes' ){
        $req = 'required';
    } else {
        $req = 'optional';
    }
    
    $value_str = cst_rel_get_text_field($post_id, $field_name);
    
    $field_id = str_replace( "_", "", $pref . strtolower( str_replace( " ", "_", $field["label"]) ) ); 
    $fld = '<div class="rel-col"><label for="'.$field_name.'" class="rel-lbl-' . $req . '">' . $field["label"] . ':</label><br /><input type="text" name="' . $field_name . '" id="'. $field_id .'" class="rel-field-text '. $req .'" maxlength="'. $field["max_length"] . '" size="'. $field["size"] .'" '.$value_str.' /></div>';
    
    if ( $field["column"] == 'first' ){
        $output .= '<div class="rel-row-fluid">' . $fld;
    } else if ( $field["column"] == 'last' ){
        $output .= $fld . '</div>';
    } else if ( $field["column"] == 'middle' ){
        $output .= $fld;
    } else if ( $field["column"] == 'blank1' ) {
        $output .= $fld . '</div>';
    } else if ( $field["column"] == 'blank2' ) {
        $output .= '<div class="rel-row-fluid">' . $fld . '</div>';
    }
    
    echo $output;
}

/* Create Select Field */
function cst_rel_create_select_input( $field ){
    global $post_id;
    $output = '';
    $fld;
    
    $pref = 'cst_rel_meta_';
    $field_name = '_' . $pref . strtolower( str_replace( " ", "_", $field["parent"] ) ) . '_' . strtolower( str_replace( "/", "_", str_replace ( " ", "_", $field["label"] ) ) );
    cst_rel_nonce($field_name);
    
    if ( $field["required"] == 'yes' ){
        $req = 'required';
    } else {
        $req = 'optional';
    }
    
    $id_str = $pref . strtolower( str_replace( " ", "_", $field["label"] ) );
    $field_id = str_replace( "_", "-", $id_str);
    $fld = '<div class="rel-col"><label for="'.$field_name.'" class="rel-lbl-' . $req . '">' . $field["label"] . ':</label><br /><select name="' . $field_name . '" id="'. $field_id .'" class="rel-field-select '. $req .' ' . $field["class"] . '" />';
    
    $opts = '';
    $select = $field["choices"];
    $i = 0;
    
    $opt_str;
    $def = '';
    if ( $field["is_single"] == 'single' ){
        $opt_str = cst_rel_get_select_single( $post_id, $field_name );
        foreach($select as $opt => $val){
            if ($opt_str != ''){
                if ($opt_str == $val ){
                    $def = 'selected="selected"';
                } else {
                    $def = '';
                }
            } else {
                if ($i == $field["default"]){
                    $def = 'selected="selected"';
                } else {
                    $def = '';
                }
            }
            $opts .= '<option value="' . $val . '" '. $def .'>'. $val .'</option>';
            $i++;
        }
    } elseif ( $field["is_single"] == 'multiple' ){
        $opt_str = cst_rel_get_select_multiple( $post_id, $field_name );
        foreach( $select as $opt => $val ){
            foreach( $opt_str as $ind => $txt ){
                if ( $val == $txt ){
                    $def = 'selected="selected"';
                } else {
                    $def = '';
                }
            }
            $opts .= '<option value="' . $val . '" '. $def .'>'. $val .'</option>';
            $i++;
        }
    }
    
    

    $fld .= $opts . '</select></div>';
   
    if ( $field["column"] == 'first' ){
        $output .= '<div class="rel-row-fluid">' . $fld;
    } else if ( $field["column"] == 'last' ){
        $output .= $fld . '</div>';
    } else if ( $field["column"] == 'middle' ){
        $output .= $fld;
    } else if ( $field["column"] == 'blank1' ) {
        $output .= $fld . '</div>';
    } else if ( $field["column"] == 'blank2' ) {
        $output .= '<div class="rel-row-fluid">' . $fld . '</div>';
    }
    
    echo $output;
}

/* Create Checkbox Field */
function cst_rel_create_checkbox_input ( $field ){
    global $post_id;
    
    $output = '';
    $fld;
    
    $pref = 'cst_rel_meta_';
    $field_name = '_' . $pref . strtolower( str_replace( " ", "_", $field["parent"] ) ) . '_' . strtolower( str_replace( "/", "_", str_replace ( " ", "_", $field["label"] ) ) );
    
    if ( $field["required"] == 'yes' ){
        $req = 'required';
    } else {
        $req = 'optional';
    }
    
    $value_str = cst_rel_get_check_field( $post_id, $field_name );
    
    $field_id = str_replace( "_", "", $pref . strtolower( str_replace( " ", "_", $field["label"]) ) ); 
    $fld = '<div class="rel-check-col"><label for="'.$field_name.'" class="rel-lbl-' . $req . '">' . $field["label"] . ':</label><input type="checkbox" name="' . $field_name . '" id="'. $field_id .'" class="rel-field-checkbox '. $req .'"' . $value_str . ' /></div>';
    
    if ( $field["column"] == 'first' ){
        $output .= '<div class="rel-row-fluid">' . $fld;
    } else if ( $field["column"] == 'last' ){
        $output .= $fld . '</div>';
    } else if ( $field["column"] == 'second' || $field["column"] == 'third' || $field["column"] == 'fourth' || $field["column"] == 'fifth' ){
        $output .= $fld;
    } else if ( $field["column"] == 'blank1' ) {
        $output .= $fld . '</div>';
    } else if ( $field["column"] == 'blank2' ) {
        $output .= '<div class="rel-row-fluid">' . $fld . '</div>';
    }
    
    echo $output;
}

/* Create Sublabel */
function cst_rel_create_sublabel( $field ){
    $output = '<div class="rel-row-fluid"><div class="rel-sublabel-col"><h4 class="rel-sublabel">'. $field["label"] .'</h4></div></div>';
    echo $output;
}

/* Display Fields */
function cst_rel_display_location_fields($location_fields){
    foreach ( $location_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input($field);
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input($field);
        }
        
    }
}
function cst_rel_display_listing_fields($listing_fields){
    foreach ( $listing_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input($field);
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input($field);
        }
        
    }
}
function cst_rel_display_rental_fields($rental_fields){
    foreach ( $rental_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } elseif ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } elseif ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        } elseif ( $field["input_type"] == 'checkbox' ){
            cst_rel_create_checkbox_input ( $field );
        }
    }
}
function cst_rel_display_basic_fields($basic_fields){
    foreach ( $basic_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } else if ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        }
    }
}
function cst_rel_display_picture_fields( $picture_fields ){
    foreach ( $picture_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } else if ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        }
    }
}
function cst_rel_display_agent_fields( $agent_fields ){
    foreach ( $agent_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } else if ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        }
    }
}
function cst_rel_display_office_fields( $office_fields ){
    foreach ( $office_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } else if ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        }
    }
}
function cst_rel_display_openhouse_fields( $openhouse_fields ){
    foreach ( $openhouse_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } else if ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        }
    }
}
function cst_rel_display_schools_fields( $schools_fields ){
    foreach ( $schools_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } else if ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        }
    }
}
function cst_rel_display_neighborhood_fields( $neighborhood_fields ){
    foreach ( $neighborhood_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } else if ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        }
    }
}
function cst_rel_display_fees_fields( $fees_fields ){
    foreach ( $fees_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } else if ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } else if ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        }
    }
}
function cst_rel_display_rich_details_fields( $rich_details_fields ){
    foreach ( $rich_details_fields as $field ){
        
        if ( $field["input_type"] == 'text'){
            cst_rel_create_text_input( $field );
        } elseif ( $field["input_type"] == 'select' ){
            cst_rel_create_select_input( $field );
        } elseif ( $field["input_type"] == 'sublabel' ){
            cst_rel_create_sublabel( $field );
        } elseif ( $field["input_type"] == 'checkbox' ){
            cst_rel_create_checkbox_input ( $field );
        }
    }
}

/* Create Panel */
function cst_rel_open_panel( $label, $collapse ){
$lbl = strtolower( str_replace(" ", "-", $label) );

$output = '
<div class="rel-panel rel-panel-hidden">
    <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-'. $lbl .'-fields" rel-toggle="collapse">
        <div class="rel-row-fluid">
            <h4 class="rel-panel-title">
                <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-'. $lbl .'-fields">'. $label. '</a>
            </h4>
        </div>
    </div>
    <div id="rel-'. $lbl .'-fields" class="panel-collapse '.$collape.'">
        <div id="rel-'.$lbl.'-body" class="panel-body">';
return $output;
}
function cst_rel_close_panel(){
    $output = '</div></div></div>';
    return $output;
}

/* Save Text Field */
function cst_rel_save_text_field( $post_id, $section, $label ){
    $field_name = '_cst_rel_meta_';
    $field_name .= strtolower( str_replace( " ", "", $section ) );
    $field_name .= '_';
    $field_name .= strtolower( str_replace( " ", "_", $label ) );
    
    $field = '';
    if ( isset($_POST[$field_name]) && $_POST[$field_name] != '' ){
        $field = sanitize_text_field( $_POST[$field_name] );
        update_post_meta( $post_id, $field_name, $field );
    }

    return $field;
}
/* Save Select Field */
function cst_rel_save_select_field( $post_id, $section, $label ){
    $field_name = '_cst_rel_meta_';
    $field_name .= strtolower( str_replace( " ", "", $section ) );
    $field_name .= '_';
    $field_name .= strtolower( str_replace( " ", "_", $label ) );
    //$select_name = "options['".$field_name."']";
    
    $field = '';
    if ( isset($_POST[$field_name]) && $_POST[$field_name] != '' ){
        $field = $_POST[$field_name];
        update_post_meta( $post_id, $field_name, $field );
    }
    
    return $field;
}
function cst_rel_save_check_field( $post_id, $section, $label ){
    $field_name = '_cst_rel_meta_';
    $field_name .= strtolower( str_replace( " ", "", $section ) );
    $field_name .= '_';
    $field_name .= strtolower( str_replace( " ", "_", $label ) );
    
    $field = '';
    //if ( isset($_POST[$field_name]) && $_POST[$field_name] != '' ){
    if ( isset($_POST[$field_name]) ) {
        $val = 'checked';
        update_post_meta( $post_id, $field_name, $val );
    } elseif ( isset($_POST[$field_name]) == false ) {
        $val = null;
        update_post_meta( $post_id, $field_name, $val );
    }
    
    return $val;
}
/* Save Field (Switch Between Types) */
function cst_rel_save_field( $post_id, $field_type, $section, $label ){
    if ($field_type == 'select'){
        cst_rel_save_select_field($post_id, $section, $label);
    } elseif ($field_type == 'text' ){
        cst_rel_save_text_field ($post_id, $section, $label);
    } elseif ($field_type == 'checkbox' ){
        cst_rel_save_check_field ($post_id, $section, $label);
    }
}

/* Get Text Field */
function cst_rel_get_text_field( $post_id, $field_name ){
    $val = get_post_meta( $post_id, $field_name, true );
    $val_str = '';
    if (isset($val) && $val != ''){
        $val_str = 'value="' . $val . '"';
    }
    return $val_str;
}
/* Get Select Field */
function cst_rel_get_select_single( $post_id, $field_name ){
    $val = get_post_meta( $post_id, $field_name, true );
    $val_str = '';
    if (isset($val) && $val != ''){
        $val_str = $val;
    }
    return $val_str;
}
function cst_rel_get_select_multiple( $post_id, $field_name ){
    $val = get_post_meta( $post_id, $field_name, false );
    $val_arr = array();
    if ( isset( $val ) && sizeof( $val ) > 0) {
        $val_arr = $val;
    }
    return $val_arr;
}
/* Get Checkbox Field */
function cst_rel_get_check_field( $post_id, $field_name ){
    $val = get_post_meta( $post_id, $field_name, true );
    $val_str = '';
    if (isset($val) && $val != ''){
        if ( $val == 'on' || $val == 'checked' ) {
            $val = 'checked';
        }
        $val_str = $val;
    }
    return $val_str;
}

/** 
  * Constructor
  */
function cst_rel_add_listings_metaboxes(){
   new cst_rel_listings_metabox();
}
class cst_rel_listings_metabox{
    /*
     * Constructor that creates the meta box
     */
    public  function  __construct(){
        /**
         * Render and Add form meta box
         */
        add_meta_box('rel-meta', 'Listing Information', array($this, 'cst_rel_listing_form'), 'listings', 'normal', 'high');
        /**
         * Save Listing
         */
        add_action('save_post',array($this, 'cst_rel_listings_save'),1,2);
    }
    /**
     * Render Form for Listing
     */
    function cst_rel_listing_form() {
        global $post;
        /* Set All Form Fields */
        cst_rel_set_all_fields();
        ?>

<div id="rel-meta-wrapper" class="meta-wrapper">
    <div id="rel-meta-container" class="meta-container">
        <div class="rel-panel-group">
            <div id="rel-panel-location" class="rel-panel rel-panel-visible">
                <div class="rel-panel-heading" rel-target="#rel-location-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-location-fields">Location</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-location-fields" class="rel-body rel-body-default">
                    <div id="rel-location-body" class="rel-panel-body">
                        <?php 
                            $location_fields = cst_rel_location_fields();
                            cst_rel_display_location_fields($location_fields);
                        ?>
                    </div>
                </div>
            </div>
            
            <div id="rel-panel-listing-details" class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-target="#rel-listing-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-listing-fields">Listing Details</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-listing-fields" class="rel-body">
                    <div id="rel-listing-body" class="panel-body">
                        <?php 
                            $listing_fields = cst_rel_listing_fields();
                            cst_rel_display_listing_fields($listing_fields);
                        ?>
                    </div>
                </div>
            </div>
                        
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-rental-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-rental-fields">Rental Details</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-rental-fields" class="rel-body">
                    <div id="rel-rental-body" class="panel-body">
                        <?php 
                            $rental_fields = cst_rel_rental_fields();
                            cst_rel_display_rental_fields($rental_fields);
                        ?>
                    </div>
                </div>
            </div>
                                    
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-basic-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-basic-fields">Basic Details</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-basic-fields" class="rel-body">
                    <div id="rel-basic-body" class="panel-body">
                        <?php
                            $basic_fields = cst_rel_basic_fields();
                            cst_rel_display_basic_fields($basic_fields);
                        ?>
                    </div>
                </div>
            </div>
                                                
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-picture-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-picture-fields">Pictures</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-picture-fields" class="rel-body">
                    <div id="rel-picture-body" class="panel-body">
                        <?php
                            $picture_fields = cst_rel_picture_fields();
                            cst_rel_display_picture_fields($picture_fields);
                        ?>
                    </div>
                </div>
            </div>
                                                            
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-agent-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-agent-fields">Agent</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-agent-fields" class="rel-body">
                    <div id="rel-agent-body" class="panel-body">
                        <?php
                            $agent_fields = cst_rel_agent_fields();
                            cst_rel_display_agent_fields($agent_fields);
                        ?>
                    </div>
                </div>
            </div>
                                                                        
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-office-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-office-fields">Office</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-office-fields" class="rel-body">
                    <div id="rel-office-body" class="panel-body">
                        <?php
                            $office_fields = cst_rel_office_fields();
                            cst_rel_display_office_fields($office_fields);
                        ?>
                    </div>
                </div>
            </div>
                                                                                    
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-open-house-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-open-house-fields">Open Houses</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-open-house-fields" class="rel-body">
                    <div id="rel-open-house-body" class="panel-body">
                        <?php 
                            $openhouse_fields = cst_rel_openhouse_fields();
                            cst_rel_display_openhouse_fields($openhouse_fields);
                        ?>
                    </div>
                </div>
            </div>
                                                                                                
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-schools-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-schools-fields">Schools</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-schools-fields" class="rel-body">
                    <div id="rel-schools-body" class="panel-body">
                        <?php 
                            $schools_fields = cst_rel_schools_fields();
                            cst_rel_display_schools_fields($schools_fields);
                        ?>
                    </div>
                </div>
            </div>
                                                                                                            
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-neighborhood-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-neighborhood-fields">Neighborhood</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-neighborhood-fields" class="rel-body">
                    <div id="rel-neighborhood-body" class="panel-body">
                        <?php 
                            $neighborhood_fields = cst_rel_neighborhood_fields();
                            cst_rel_display_neighborhood_fields($neighborhood_fields);
                        ?>
                    </div>
                </div>
            </div>
                                                                                                                        
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-fees-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-fees-fields">Fees</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-fees-fields" class="rel-body">
                    <div id="rel-fees-body" class="panel-body">
                        <?php
                            $fees_fields = cst_rel_fees_fields();
                            cst_rel_display_fees_fields($fees_fields);
                        ?>
                    </div>
                </div>
            </div>
                                                                                                                                    
            <div class="rel-panel rel-panel-hidden">
                <div class="rel-panel-heading" rel-parent="#rel-meta-box" rel-target="#rel-rich-details-fields" rel-toggle="collapse">
                    <div class="rel-row-fluid">
                        <h4 class="rel-panel-title">
                            <a class="rel-header-link" rel-parent="#rel-meta-box" href="#rel-rich-details-fields">Rich Details</a>
                        </h4>
                    </div>
                </div>
                <div id="rel-rich-details-fields" class="rel-body">
                    <div id="rel-rich-details-body" class="panel-body">
                        <?php
                            $rich_details_fields = cst_rel_rich_details_fields();
                            cst_rel_display_rich_details_fields($rich_details_fields);
                        ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!--</div>-->
        <?php

    }
    /**
     * Meta key actual database insertion
     */
    function cst_rel_listings_save($post_id){
        
    //Location
        $cst_rel_location_street_address = cst_rel_save_field( $post_id, 'text', 'Location', 'Street Address' );
        $cst_rel_location_unit_number = cst_rel_save_field( $post_id, 'text', 'Location', 'Unit Number' );
        $cst_rel_location_city = cst_rel_save_field( $post_id, 'text', 'Location', 'City' );
        $cst_rel_location_state = cst_rel_save_field( $post_id, 'select', 'Location', 'State' );
        $cst_rel_location_zip = cst_rel_save_field( $post_id, 'text', 'Location', 'Zip' );
        $cst_rel_location_lat = cst_rel_save_field( $post_id, 'text', 'Location', 'Lat' );
        $cst_rel_location_long = cst_rel_save_field( $post_id, 'text', 'Location', 'Long' );
        $cst_rel_location_display_address = cst_rel_save_field( $post_id, 'select', 'Location', 'Display Address' );
    //Listing Details
        $cst_rel_listingdetails_status = cst_rel_save_field( $post_id, 'select', 'Listing Details', 'Status' );
        $cst_rel_listingdetails_price = cst_rel_save_field( $post_id, 'text', 'Listing Details', 'Price' );
        $cst_rel_listingdetails_listing_url = cst_rel_save_field( $post_id, 'text', 'Listing Details', 'Listing URL' );
        $cst_rel_listingdetails_mls_id = cst_rel_save_field( $post_id, 'text', 'Listing Details', 'MLS ID' );
        $cst_rel_listingdetails_mls_name = cst_rel_save_field( $post_id, 'text', 'Listing Details', 'MLS Name' );
        $cst_rel_listingdetails_provider_listing_id = cst_rel_save_field( $post_id, 'text', 'Listing Details', 'Provider Listing ID' );
        $cst_rel_listingdetails_virtual_tour_url = cst_rel_save_field( $post_id, 'text', 'Listing Details', 'Virtual Tour URL' );
        $cst_rel_listingdetails_listing_email = cst_rel_save_field( $post_id, 'text', 'Listing Details', 'Listing Email' );
        $cst_rel_listingdetails_always_email_agent = cst_rel_save_field( $post_id, 'select', 'Listing Details', 'Always Email Agent' );
        $cst_rel_listingdetails_short_sale = cst_rel_save_field( $post_id, 'select', 'Listing Details', 'Short Sale' );
        $cst_rel_listingdetails_reo = cst_rel_save_field( $post_id, 'select', 'Listing Details', 'REO' );
    //Rental Details
        $cst_rel_rentaldetails_availability = cst_rel_save_field( $post_id, 'select', 'Rental Details', 'Availability' );
        $cst_rel_rentaldetails_lease_term = cst_rel_save_field( $post_id, 'select', 'Rental Details', 'Lease Term' );
        $cst_rel_rentaldetails_deposit_fees = cst_rel_save_field( $post_id, 'text', 'Rental Details', 'Deposit Fees' );
        $cst_rel_utilitiesincluded_water = cst_rel_save_field( $post_id, 'checkbox', 'Utilities Included', 'Water' );
        $cst_rel_utilitiesincluded_sewage = cst_rel_save_field( $post_id, 'checkbox', 'Utilities Included', 'Sewage' );
        $cst_rel_utilitiesincluded_garbage = cst_rel_save_field( $post_id, 'checkbox', 'Utilities Included', 'Garbage' );
        $cst_rel_utilitiesincluded_electricity = cst_rel_save_field( $post_id, 'checkbox', 'Utilities Included', 'Electricity' );
        $cst_rel_utilitiesincluded_gas = cst_rel_save_field( $post_id, 'checkbox', 'Utilities Included', 'Gas' );
        $cst_rel_utilitiesincluded_internet = cst_rel_save_field( $post_id, 'checkbox', 'Utilities Included', 'Internet' );
        $cst_rel_utilitiesincluded_cable = cst_rel_save_field( $post_id, 'checkbox', 'Utilities Included', 'Cable' );
        $cst_rel_utilitiesincluded_sattv = cst_rel_save_field( $post_id, 'checkbox', 'Utilities Included', 'SatTv' );
        $cst_rel_petsallowed_no_pets = cst_rel_save_field( $post_id, 'select', 'Pets Allowed', 'No Pets' );
        $cst_rel_petsallowed_cats = cst_rel_save_field( $post_id, 'select', 'Pets Allowed', 'Cats' );
        $cst_rel_petsallowed_small_dogs = cst_rel_save_field( $post_id, 'select', 'Pets Allowed', 'Small Dogs' );
        $cst_rel_petsallowed_large_dogs = cst_rel_save_field( $post_id, 'select', 'Pets Allowed', 'Large Dogs' );
    //Basic Details
        $cst_rel_basicdetails_property_type = cst_rel_save_field( $post_id, 'select', 'Basic Details', 'Property Type' );
        $cst_rel_basicdetails_title = cst_rel_save_field( $post_id, 'text', 'Basic Details', 'Title' );
        $cst_rel_basicdetails_description = cst_rel_save_field( $post_id, 'text', 'Basic Details', 'Description' );
        $cst_rel_basicdetails_bedrooms = cst_rel_save_field( $post_id, 'select', 'Basic Details', 'Bedrooms' );
        $cst_rel_basicdetails_bathrooms = cst_rel_save_field( $post_id, 'select', 'Basic Details', 'Bathrooms' );
        $cst_rel_basicdetails_full_bathrooms = cst_rel_save_field( $post_id, 'select', 'Basic Details', 'Full Bathrooms' );
        $cst_rel_basicdetails_half_bathrooms = cst_rel_save_field( $post_id, 'select', 'Basic Details', 'Half Bathrooms' );
        $cst_rel_basicdetails_quarter_bathrooms = cst_rel_save_field( $post_id, 'select', 'Basic Details', 'Quarter Bathrooms' );
        $cst_rel_basicdetails_three_quarter_bathrooms = cst_rel_save_field( $post_id, 'select', 'Basic Details', 'Three Quarter Bathrooms' );
        $cst_rel_basicdetails_living_area = cst_rel_save_field( $post_id, 'text', 'Basic Details', 'Living Area' );
        $cst_rel_basicdetails_lot_size = cst_rel_save_field( $post_id, 'text', 'Basic Details', 'Lot Size' );
        $cst_rel_basicdetails_year_built = cst_rel_save_field( $post_id, 'text', 'Basic Details', 'Year Built' );
    //Pictures
        $cst_rel_picture_picture_url = cst_rel_save_field( $post_id, 'text', 'Picture', 'Picture URL' );
        $cst_rel_picture_caption = cst_rel_save_field( $post_id, 'text', 'Picture', 'Caption' );
    //Agent
        $cst_rel_agent_first_name = cst_rel_save_field( $post_id, 'text', 'Agent', 'First Name' );
        $cst_rel_agent_last_name = cst_rel_save_field( $post_id, 'text', 'Agent', 'Last Name' );
        $cst_rel_agent_email_address = cst_rel_save_field( $post_id, 'text', 'Agent', 'Email Address' );
        $cst_rel_agent_picture_url = cst_rel_save_field( $post_id, 'text', 'Agent', 'Picture URL' );
        $cst_rel_agent_office_line_number = cst_rel_save_field( $post_id, 'text', 'Agent', 'Office Line Number' );
        $cst_rel_agent_mobile_phone_line_number = cst_rel_save_field( $post_id, 'text', 'Agent', 'Mobile Phone Line Number' );
        $cst_rel_agent_fax_line_number = cst_rel_save_field( $post_id, 'text', 'Agent', 'Fax Line Number' );
        $cst_rel_agent_license_num = cst_rel_save_field( $post_id, 'text', 'Agent', 'License Num' );
    //Office
        $cst_rel_office_brokerage_name = cst_rel_save_field( $post_id, 'text', 'Office', 'Brokerage Name' );
        $cst_rel_office_broker_phone = cst_rel_save_field( $post_id, 'text', 'Office', 'Broker Phone' );
        $cst_rel_office_broker_email = cst_rel_save_field( $post_id, 'text', 'Office', 'Broker Email' );
        $cst_rel_office_broker_website = cst_rel_save_field( $post_id, 'text', 'Office', 'Broker Website' );
        $cst_rel_office_street_address = cst_rel_save_field( $post_id, 'text', 'Office', 'Street Address' );
        $cst_rel_office_unit_number = cst_rel_save_field( $post_id, 'text', 'Office', 'Unit Number' );
        $cst_rel_office_city = cst_rel_save_field( $post_id, 'text', 'Office', 'City' );
        $cst_rel_office_state = cst_rel_save_field( $post_id, 'select', 'Office', 'State' );
        $cst_rel_office_zip = cst_rel_save_field( $post_id, 'text', 'Office', 'Zip' );
        $cst_rel_office_office_name = cst_rel_save_field( $post_id, 'text', 'Office', 'Office Name' );
        $cst_rel_office_franchise_name = cst_rel_save_field( $post_id, 'text', 'Office', 'Franchise Name' );
    //Open Houses
        $cst_rel_openhouse_date = cst_rel_save_field( $post_id, 'text', 'Open House', 'Date' );
        $cst_rel_openhouse_start_time = cst_rel_save_field( $post_id, 'text', 'Open House', 'Start Time' );
        $cst_rel_openhouse_end_time = cst_rel_save_field( $post_id, 'text', 'Open House', 'End Time' );
    //Schools
        $cst_rel_schools_district = cst_rel_save_field( $post_id, 'text', 'Schools', 'District' );
        $cst_rel_schools_elementary = cst_rel_save_field( $post_id, 'text', 'Schools', 'Elementary' );
        $cst_rel_schools_middle = cst_rel_save_field( $post_id, 'text', 'Schools', 'Middle' );
        $cst_rel_schools_high = cst_rel_save_field( $post_id, 'text', 'Schools', 'High' );
    //Neighborhood
        $cst_rel_neighborhood_name = cst_rel_save_field( $post_id, 'text', 'Neighborhood', 'Name' );
    //Fees
        $cst_rel_fee_fee_type = cst_rel_save_field( $post_id, 'select', 'Fee', 'Fee Type' );
        $cst_rel_fee_fee_amount = cst_rel_save_field( $post_id, 'text', 'Fee', 'Fee Amount' );
        $cst_rel_fee_fee_period = cst_rel_save_field( $post_id, 'select', 'Fee', 'Fee Period' );
    //Rich Details
        $cst_rel_richdetails_additional_features = cst_rel_save_field( $post_id, 'select', 'Rich Details', 'Additional Features' );
        $cst_rel_appliances_appliance = cst_rel_save_field( $post_id, 'select', 'Appliances', 'Appliance' );
        $cst_rel_richdetails_architecture_style = cst_rel_save_field( $post_id, 'select', 'Rich Details', 'Architecture Style' );
        $cst_rel_richdetails_attic = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Attic' );
        $cst_rel_richdetails_barbecue_area = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Barbecue Area' );
        $cst_rel_richdetails_basement = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Basement' );
        $cst_rel_richdetails_building_unit_count = cst_rel_save_field( $post_id, 'text', 'Rich Details', 'Building Unit Count' );
        $cst_rel_richdetails_cable_ready = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Cable Ready' );
        $cst_rel_richdetails_ceiling_fan = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Ceiling Fan' );
        $cst_rel_richdetails_condo_floor_num = cst_rel_save_field( $post_id, 'text', 'Rich Details', 'Condo Floor Num' );
        $cst_rel_coolingsystems_cooling_system = cst_rel_save_field( $post_id, 'select', 'Cooling Systems', 'Cooling System' );
        $cst_rel_richdetails_deck = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Deck' );
        $cst_rel_richdetails_disabled_access = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Disabled Access' );
        $cst_rel_richdetails_dock = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Dock' );
        $cst_rel_richdetails_doorman = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Doorman' );
        $cst_rel_richdetails_double_pane_windows = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Double Pane Windows' );
        $cst_rel_richdetails_elevator = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Elevator' );
        $cst_rel_exteriortypes_exterior_type = cst_rel_save_field( $post_id, 'select', 'Exterior Types', 'Exterior Type' );
        $cst_rel_richdetails_fireplace = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Fireplace' );
        $cst_rel_floorcoverings_floor_covering = cst_rel_save_field( $post_id, 'select', 'Floor Coverings', 'Floor Covering' );
        $cst_rel_richdetails_garden = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Garden' );
        $cst_rel_richdetails_gated_entry = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Gated Entry' );
        $cst_rel_richdetails_greenhouse = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Greenhouse' );
        $cst_rel_heatingfuels_heating_fuel = cst_rel_save_field( $post_id, 'select', 'Heating Fuels', 'Heating Fuel' );
        $cst_rel_heatingsystems_heating_system = cst_rel_save_field( $post_id, 'select', 'Heating Systems', 'Heating System' );
        $cst_rel_richdetails_hottub_spa = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Hottub Spa' );
        $cst_rel_richdetails_intercom = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Intercom' );
        $cst_rel_richdetails_jetted_bath_tub = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Jetted Bath Tub' );
        $cst_rel_richdetails_lawn = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Lawn' );
        $cst_rel_richdetails_mother_in_law = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Mother In Law' );
        $cst_rel_richdetails_num_floors = cst_rel_save_field( $post_id, 'text', 'Rich Details', 'Num Floors' );
        $cst_rel_richdetails_num_parking_spaces = cst_rel_save_field( $post_id, 'text', 'Rich Details', 'Num Parking Spaces' );
        $cst_rel_parkingtypes_parking_type = cst_rel_save_field( $post_id, 'select', 'Parking Types', 'Parking Type' );
        $cst_rel_richdetails_patio = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Patio' );
        $cst_rel_richdetails_pond = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Pond' );
        $cst_rel_richdetails_pool = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Pool' );
        $cst_rel_richdetails_porch = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Porch' );
        $cst_rel_rooftypes_roof_type = cst_rel_save_field( $post_id, 'select', 'Roof Types', 'Roof Type' );
        $cst_rel_richdetails_room_count = cst_rel_save_field( $post_id, 'text', 'Rich Details', 'Room Count' );
        $cst_rel_rooms_room = cst_rel_save_field( $post_id, 'select', 'Rooms', 'Room' );
        $cst_rel_richdetails_rv_parking = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'RV Parking' );
        $cst_rel_richdetails_sauna = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Sauna' );
        $cst_rel_richdetails_security_system = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Security System' );
        $cst_rel_richdetails_skylight = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Skylight' );
        $cst_rel_richdetails_sports_court = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Sports Court' );
        $cst_rel_richdetails_sprinkler_system = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Sprinkler System' );
        $cst_rel_richdetails_vaulted_ceiling = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Vaulted Ceiling' );
        $cst_rel_richdetails_fitness_center = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Fitness Center' );
        $cst_rel_richdetails_basketball_court = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Basketball Court' );
        $cst_rel_richdetails_tennis_court = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Tennis Court' );
        $cst_rel_richdetails_near_transportation = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Near Transportation' );
        $cst_rel_richdetails_controlled_access = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Controlled Access' );
        $cst_rel_richdetails_over_55_active_community = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Over 55 Active Community' );
        $cst_rel_richdetails_assisted_living_community = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Assisted Living Community' );
        $cst_rel_richdetails_storage = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Storage' );
        $cst_rel_richdetails_fenced_yard = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Fenced Yard' );
        $cst_rel_richdetails_property_name = cst_rel_save_field( $post_id, 'text', 'Rich Details', 'Property Name' );
        $cst_rel_richdetails_furnished = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Furnished' );
        $cst_rel_richdetails_high_speed_internet = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'High Speed Internet' );
        $cst_rel_richdetails_onsite_laundry = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Onsite Laundry' );
        $cst_rel_richdetails_cable_sattv = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Cable SatTv' );
        $cst_rel_viewtypes_view_type = cst_rel_save_field( $post_id, 'select', 'View Types', 'View Type' );
        $cst_rel_richdetails_waterfront = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Waterfront' );
        $cst_rel_richdetails_wetbar = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Wetbar' );
        $cst_rel_richdetails_what_owner_loves = cst_rel_save_field( $post_id, 'text', 'Rich Details', 'What Owner Loves' );
        $cst_rel_richdetails_wired = cst_rel_save_field( $post_id, 'checkbox', 'Rich Details', 'Wired' );
        $cst_rel_richdetails_year_updated = cst_rel_save_field( $post_id, 'text', 'Rich Details', 'Year Updated' );

        
        
        
    }
}