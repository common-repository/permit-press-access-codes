<?php
/*
Plugin Name: Press Permit Access Codes
Description: Allows registered users to be added to a permission group based on which access code or password they entered.
Plugin URI: http://slickorange.co.za
Author: Hendre Page
Author URI: http://#
Version: 1.0
License: GPL2
*/

$plugin_url = WP_PLUGIN_URL . "/press-permit-access-codes.php";
$options = array();

/*Add link to plugin admin menu*/

function pp_access_codes_menu(){
	add_options_page(
		'Press Permit Group Access Codes', //Page Title
		'PP Access Codes', //Menu Title
		'manage_options', //Capability
		'pp-access-codes', //Slug
		'pp_access_codes_options_page' //Function
		);
}

add_action('admin_menu', 'pp_access_codes_menu');

function pp_access_codes_options_page(){
	if(!current_user_can('manage_options')){
		wp_die("You do not have sufficient permission to access this page.");
	}

	global $plugin_url;
	global $options;

		if(isset($_POST['pp_access_codes_form_submitted'])){
		$hidden_field = esc_html($_POST['pp_access_codes_form_submitted']);

		if($hidden_field == 'Y'){
			$pp_access_codes_group = esc_html($_POST['pp_access_codes_group']);
			$pp_access_code = esc_html($_POST['pp_access_code']);
			
			if(empty($pp_access_code))
				delete_option('access_code:'.$pp_access_codes_group);
			else
				update_option('access_code:'.$pp_access_codes_group, $pp_access_code );
		}

	}
	require("options-page.php");
}

//Generates the admin group selector dropdown
function pp_access_codes_groups_drop_down(){
	$groups_array = pp_get_groups();
	$dropdown_html = "<select name='pp_access_codes_group' id='pp_access_codes_group'>";

	foreach ($groups_array as $group){
		$dropdown_html .="<option value='".$group->ID."'>".$group->name."</option>";
	}
	
	$dropdown_html.="</select>";
	return $dropdown_html;
}

//Gets all the group:accesscode combinations
function pp_access_codes_get_combinations()
{
	$groups_array = pp_get_groups();
	$combinations = array();
	
	foreach ($groups_array as $group){
		$option=get_option('access_code:'.$group->ID);
		if(!empty($option))
			$combinations[$group->ID] = get_option('access_code:'.$group->ID);
	}
	return $combinations;
}

//Gets groups with active access codes
function pp_access_codes_get_active_combinations()
{
	$groups_array = pp_get_groups();
	$combinations = array();
	
	foreach ($groups_array as $group){
	$option=get_option('access_code:'.$group->ID);
		if(!empty($option))
			$combinations[$group->ID] = $group->name;
	}
	return $combinations;
}

//Prints list of the groups with active access codes
function pp_access_codes_list_active_combinations()
{
	$combinations =pp_access_codes_get_active_combinations();
	$list_html="<ul>";
	foreach($combinations as $combination){
		$list_html.= "<li>".$combination."</li>";
	}
	$list_html.="</ul>";

	return $list_html;
}

function pp_access_codes_shortcode($atts, $content = null){
	if ( is_user_logged_in() ){
		global $post;

		if(isset($_POST['pp_access_codes_frontend_form_submitted'])){
		$hidden_field = esc_html($_POST['pp_access_codes_frontend_form_submitted']);

		if($hidden_field == 'Y'){
			$pp_access_code_frontend = esc_html($_POST['pp_access_code_frontend']);
			$combinations=pp_access_codes_get_combinations();
			
			if(array_search($pp_access_code_frontend, $combinations)!=false)
			{
				$group_id = array_search($pp_access_code_frontend, $combinations);
				
				pp_add_group_user($group_id, get_current_user_id());
				
				$group_name = pp_get_group($group_id)->name;
				echo "You have been added to the '".$group_name."' group!";
			}
			else
				echo "Access code incorrect!";
		}

	}
	else{

	extract(shortcode_atts(array(), $atts));

	ob_start();
	require('front-end.php');
	$content = ob_get_clean();
	}
	return $content;
	}
	}

add_shortcode('pp-access-codes', 'pp_access_codes_shortcode' );

?>