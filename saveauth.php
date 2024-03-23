<?php
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
};
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH.'wp-admin/includes/plugin.php');
$path = WP_PLUGIN_DIR.'/vtupress/functions.php';
if(file_exists($path) && in_array('vtupress/vtupress.php', apply_filters('active_plugins', get_option('active_plugins')))){
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');
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

vp_updateoption("cardsairtel",$_REQUEST["cardsairtel"]);
vp_updateoption("cardsglo",$_REQUEST["cardsglo"]);
vp_updateoption("cardsmtn",$_REQUEST["cardsmtn"]);
vp_updateoption("cards9mobile",$_REQUEST["cards9mobile"]);
vp_updateoption("mtndiscount",$_REQUEST["mtndiscount"]);
vp_updateoption("glodiscount",$_REQUEST["glodiscount"]);
vp_updateoption("airteldiscount",$_REQUEST["airteldiscount"]);
vp_updateoption("9mobilediscount",$_REQUEST["9mobilediscount"]);
echo "100";
?>