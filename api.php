<?php
ob_start();
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
};
if(WP_DEBUG == false){
error_reporting(0);	
}

include_once(ABSPATH.'wp-admin/includes/plugin.php');
$path = WP_PLUGIN_DIR.'/vtupress/functions.php';
if(file_exists($path) && in_array('vtupress/vtupress.php', apply_filters('active_plugins', get_option('active_plugins')))){
include_once(ABSPATH.'wp-content/plugins/vtupress/functions.php');
}
else{
	if(!function_exists("vp_updateuser")){
function vp_updateuser(){
	
}

function vp_getuser(){
	
}

function vp_adduser(){
	
}

function vp_updateoption(){
	
}

function vp_getoption(){
	
}

function vp_option_array(){
	
}

function vp_user_array(){
	
}

function vp_deleteuser(){
	
}

function vp_addoption(){
	
}

	}

}

/*
$q = $_REQUEST['q'];
$id = $_REQUEST['id'];
$data = get_userdata($id);
$ud = $_REQUEST['apikey'];
*/

add_action("vtupress_other_api", recharge_card_api());

function recharge_card_api(){
    if(isset($_REQUEST["service"])){
        if($_REQUEST["service"] == "recharge_card"){
        
            echo "works";
        
        
        //LAST
        die();
        }
    }

}

?>