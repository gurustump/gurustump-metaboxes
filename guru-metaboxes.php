<?php
/**
 * @package Guru_Metaboxes
 * @version 1
 */
/*
Plugin Name: Guru Metaboxes
Plugin URI: 
Description: Adding metaboxes for various post types using CMB2. Requires CMB2 Plugin, or the CMB2 theme folder.
Author: Matthew Stumphy
Version: 1
Author URI: http://www.gurustump.com
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_init', 'gurustump_register_page_metabox' );

function gurustump_register_page_metabox() {
	$prefix = '_gurustump_page_';
	
	$cmb_page_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Custom Page Fields', 'cmb2' ),
		'object_types'  => array( 'page'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_page_box->add_field( array(
		'name'		=> __( 'Index Gallery', 'cmb2' ),
		'desc' => __( 'Select images to be used for the background on the heading area of an index page', 'cmb2' ),
		'id'			=> $prefix . 'index_gallery',
		'type'		=> 'file_list',
	) );

	$cmb_page_box->add_field( array(
		'name'		=> __( 'Index Submenu', 'cmb2' ),
		'desc' => __( 'Enter the name of the Wordpress menu that you want to appear as a submenu on this page', 'cmb2' ),
		'id'			=> $prefix . 'submenu',
		'type'		=> 'text',
	) );

	$cmb_page_box->add_field( array(
		'name'		=> __( 'File Embed', 'cmb2' ),
		'desc' => __( "Use to reveal a single file to the front end from Wordpress' Media area. Used on index pages to load a video.", 'cmb2' ),
		'id'			=> $prefix . 'file',
		'type'		=> 'file',
	) );

	$cmb_page_box->add_field( array(
		'name'             => __( 'Gallery Type', 'cmb2' ),
		'desc'             => __( "If any galleries appear on the page, this determines the gallery's layout between standard thumbs and movie thumbs", 'cmb2' ),
		'id'               => $prefix . 'gallery_type',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'standard-gallery'  => __( 'Standard Gallery', 'cmb2' ),
			'movie-gallery' 	=> __( 'Movie Gallery', 'cmb2' ),
		),
	) );

}

add_action( 'cmb2_init', 'gurustump_register_show_metabox' );

function gurustump_register_show_metabox() {
	$prefix = '_gurustump_show_';
	
	$cmb_show_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Show Information - All fields are optional', 'cmb2' ),
		'object_types'  => array( 'shows'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
/*
	$cmb_show_box->add_field( array(
		'name'		=> __( 'Video Embed', 'cmb2' ),
		'desc' => __( 'Enter embed code of your video. You can change the width and height in the embed code to 1280 by 720 if you want the video to start out larger. If this is filled in, it will override the "Video Link" below.', 'cmb2' ),
		'id'			=> $prefix . 'video_embed',
		'type'		=> 'textarea_code',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Video Link', 'cmb2' ),
		'desc' => __( 'Upload/Select a video or enter a URL', 'cmb2' ),
		'id'			=> $prefix . 'video_link',
		'type'		=> 'file',
	) );
*/

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Video ID', 'cmb2' ),
		'desc' => __( 'Input the ID of the YouTube video', 'cmb2' ),
		'id'			=> $prefix . 'video_ID',
		'type'		=> 'text',
	) );

	$cmb_show_box->add_field( array(
		'name' => __( 'Offsite Video URL', 'cmb2' ),
		'desc' => __( 'Enter the URL of where the movie can be viewed on the internet. Use only if the video is not available on YouTube, as this will override the Video', 'cmb2' ),
		'id'   => $prefix . 'offsite_url',
		'type' => 'text_url',
		'protocols' => array('http', 'https'), // Array of allowed protocols
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Next Video', 'cmb2' ),
		'desc'       => __( 'Select the video that will play when the show ends.', 'cmb2' ),
		'id' 			=> $prefix . 'next_video',
		'type'		=> 'post_search_text',
		'post_type'=> 'shows'
	) );
	$cmb_show_box->add_field( array(
		'name'		=> __( 'Beginning of Credits Timecode', 'cmb2' ),
		'desc'       => __( 'Ender the elapsed time, IN SECONDS, when the credits start to play. Used to calculate when the Next Play overlay should pop up.', 'cmb2' ),
		'id' 			=> $prefix . 'credits_timecode',
		'type'		=> 'text',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Gallery Heading', 'cmb2' ),
		'desc'       => __( 'The heading that will appear over the image gallery.', 'cmb2' ),
		'id' 			=> $prefix . 'gallery_heading',
		'type'		=> 'text',
	) );
	$cmb_show_box->add_field( array(
		'name'		=> __( 'Show Gallery', 'cmb2' ),
		'desc' => __( 'Insert a Wordpress Gallery for this show, especially for behind the scenes photos', 'cmb2' ),
		'id'			=> $prefix . 'gallery',
		'type'		=> 'wysiwyg',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Director', 'cmb2' ),
		'desc'       => __( 'Enter the ID of a "Person", or click the search button to find it.', 'cmb2' ),
		'id'			=> $prefix . 'director',
		'type'		=> 'post_search_text',
		'post_type'=> 'people',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Producer', 'cmb2' ),
		'desc'       => __( 'Enter the ID of a "Person", or click the search button to find it.', 'cmb2' ),
		'id'			=> $prefix . 'producer',
		'type'		=> 'post_search_text',
		'post_type'=> 'people',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Writer', 'cmb2' ),
		'desc'       => __( 'Enter the ID of a "Person", or click the search button to find it.', 'cmb2' ),
		'id' 			=> $prefix . 'writer',
		'type'		=> 'post_search_text',
		'post_type'=> 'people',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Director of Photography', 'cmb2' ),
		'desc'       => __( 'Enter the ID of a "Person", or click the search button to find it.', 'cmb2' ),
		'id' 			=> $prefix . 'dp',
		'type'		=> 'post_search_text',
		'post_type'=> 'people',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Editor', 'cmb2' ),
		'desc'       => __( 'Enter the ID of a "Person", or click the search button to find it.', 'cmb2' ),
		'id' 			=> $prefix . 'editor',
		'type'		=> 'post_search_text',
		'post_type'=> 'people',
	) );

	/*$cmb_show_box->add_field( array(
		'name'		=> __( 'Cast', 'cmb2' ),
		'desc'       => __( 'Enter the names of the actors here', 'cmb2' ),
		'id' 			=> $prefix . 'cast',
		'type'		=> 'textarea_small',
	) );*/
	
	$cast_group_field_id = $cmb_show_box->add_field( array(
		'id'          => $prefix . 'cast',
		'type'        => 'group',
		'description' => __( 'Add cast members', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Cast Member {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Cast Member', 'cmb2' ),
			'remove_button' => __( 'Remove Cast Member', 'cmb2' ),
			'sortable'      => true, // beta
		),
	) );
	$cmb_show_box->add_group_field( $cast_group_field_id, array(
		'name'       => __( 'Character', 'cmb2' ),
		'id'         => 'character',
		'type'       => 'text',
	) );
	$cmb_show_box->add_group_field( $cast_group_field_id, array(
		'name'       => __( 'Castmember', 'cmb2' ),
		'id'         => 'name',
		'desc'       => __( 'Enter the ID of a "Person", or click the search button to find it.', 'cmb2' ),
		'type'		=> 'post_search_text',
		'post_type'=> 'people'
	) );
	
	$crew_group_field_id = $cmb_show_box->add_field( array(
		'id'          => $prefix . 'other_crew',
		'type'        => 'group',
		'description' => __( 'Add other crew positions', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Crew Position {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Crew Member', 'cmb2' ),
			'remove_button' => __( 'Remove Crew Member', 'cmb2' ),
			'sortable'      => true, // beta
		),
	) );
	$cmb_show_box->add_group_field( $crew_group_field_id, array(
		'name'       => __( 'Crew Position Title', 'cmb2' ),
		'id'         => 'title',
		'type'       => 'text',
	) );
	$cmb_show_box->add_group_field( $crew_group_field_id, array(
		'name'       => __( 'Crewmember', 'cmb2' ),
		'desc'       => __( 'Enter the ID of a "Person", or click the search button to find it.', 'cmb2' ),
		'id'         => 'name',
		'type'		=> 'post_search_text',
		'post_type'=> 'people',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Duration', 'cmb2' ),
		'desc'       => __( 'Enter the duration in minutes. Do not include the word "min" or "minutes." It will be added automatically.', 'cmb2' ),
		'id' 			=> $prefix . 'duration',
		'type'		=> 'text_small',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Country', 'cmb2' ),
		'id' 			=> $prefix . 'country',
		'type'		=> 'text',
	) );

	$cmb_show_box->add_field( array(
		'name'		=> __( 'Age Restriction', 'cmb2' ),
		'id' 			=> $prefix . 'age_restriction',
		'type'		=> 'text',
	) );

	$cmb_show_box->add_field( array(
		'name' => __( 'IMDb URL', 'cmb2' ),
		'desc' => __( 'Enter the URL of the IMDb page for this film', 'cmb2' ),
		'id'   => $prefix . 'imdb_url',
		'type' => 'text_url',
		'protocols' => array('http', 'https'), // Array of allowed protocols
	) );

	$cmb_show_box->add_field( array(
		'name' => __( 'Link to film on the web', 'cmb2' ),
		'desc' => __( 'Enter the URL of where the movie can be viewed on the internet', 'cmb2' ),
		'id'   => $prefix . 'view_url',
		'type' => 'text_url',
		'protocols' => array('http', 'https'), // Array of allowed protocols
	) );

}

add_action( 'cmb2_init', 'gurustump_register_person_metabox' );

function gurustump_register_person_metabox() {
	$prefix = '_gurustump_person_';
	
	$cmb_person_box = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Person Information - All fields are optional', 'cmb2' ),
		'object_types'  => array( 'people'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_person_box->add_field( array(
		'name' => __( 'IMDb URL', 'cmb2' ),
		'desc' => __( 'Enter the URL of the IMDb page for this person', 'cmb2' ),
		'id'   => $prefix . 'imdb_url',
		'type' => 'text_url',
		'protocols' => array('http', 'https'), // Array of allowed protocols
	) );

	$cmb_person_box->add_field( array(
		'name' => __( 'Personal Home Page', 'cmb2' ),
		'desc' => __( "Enter the URL of the person's home page", 'cmb2' ),
		'id'   => $prefix . 'homepage_url',
		'type' => 'text_url',
		'protocols' => array('http', 'https'), // Array of allowed protocols
	) );

}

?>
