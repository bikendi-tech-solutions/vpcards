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

if(isset($_REQUEST["add_pin"])){
	
	$network = strtolower($_REQUEST["network"]);
	$pin = $_REQUEST["pin"];
	$delimiter = strtolower($_REQUEST["delimiter"]);
	$value = $_REQUEST["value"];
	
$str = explode($delimiter,$pin);
if(!empty($pin) && !empty($value)){

if(empty($str) && $delimiter != "none" && !empty($delimiter)){
	
$obj = new stdClass;
$obj->code = "200";
$obj->message = "Delimiter Not Found In The Pin(s)";

die(json_encode($obj));
}
elseif($delimiter == "none" || empty($delimiter) && empty(strpos($pin,",")) && empty(strpos($pin,";"))  && empty(strpos($pin,"/")) ){
	$valid = "true";
	global $wpdb;
	$table_name = $wpdb->prefix.'vpcards';
	$resultfad = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $table_name WHERE status='unused' ORDER BY %s DESC", 'ID'));

foreach($resultfad as $pinsa){
	if($pinsa->pin == $pin){
$valid = "false";
$where = $pinsa->network;
	}		
}

if($valid == "true"){
$network =  $_REQUEST["network"];
$pin = $pin;
$status ='unused';
$table_name = $wpdb->prefix.'vpcards';
$wpdb->insert($table_name, array(
'network' => $network,
'value' => $value,
'pin' => $pin,
'status' => $status,
'the_time' => current_time('mysql', 1)
));
$obj = new stdClass;
$obj->code = "100";
$obj->message = "Pin [$pin] Added For $network";
die(json_encode($obj));
}
else{
	
$obj = new stdClass;
$obj->code = "200";
$obj->message = "[$pin] Already Exist In $where";
die(json_encode($obj));	
	
}

}
elseif(!empty($str)){
	
	$valid = "true";
		
global $wpdb;	
$array = explode($delimiter,$pin);

$num = 0;


	$table_name = $wpdb->prefix.'vpcards';
	$resultfad = $wpdb->get_results("SELECT pin FROM  $table_name WHERE status='unused'");
	
$not = 0;


foreach($array as $pinsa){
foreach($resultfad as $res){
	if($pinsa == $res->pin){
		$valid = "false";
		$not = $not+1;
	}
}
	
if($valid == "true"){
	if(!empty($pinsa)){
	$num = $num +1;	
$network = $_REQUEST["network"];
$status ='unused';
$table_name = $wpdb->prefix.'vpcards';
$wpdb->insert($table_name, array(
'network' => $network,
'pin' => $pinsa,
'value' => $value,
'status' => $status,
'the_time' => current_time('mysql', 1)
));
		
	}
	


}
}
if($valid == "true"){
$obj = new stdClass;
$obj->code = "100";
$obj->message = "$num Pins Added For $network And $not Already Exist";
die(json_encode($obj));
}
else{
$obj = new stdClass;
$obj->code = "200";
$obj->message = "$num Pins Added For $network And $not Already Exist";
die(json_encode($obj));
}


}
elseif($delimiter == "none" || !empty($delimiter) || !empty(strpos($pin,",")) || !empty(strpos($pin,";"))  || !empty(strpos($pin,"/")) ){
$obj = new stdClass;
$obj->code = "200";
$obj->message = "Use None in Delimiter If You Wanna Import A Single Pin Or Separate Pins By Comma Sign[,] And Enter Comma Sign[,] In Delimiter";

die(json_encode($obj));	
}
else{
$obj = new stdClass;
$obj->code = "200";
$obj->message = "Unknown Error";

die(json_encode($obj));	
}
}
else{
$obj = new stdClass;
$obj->code = "200";
$obj->message = "Pin And Value Can't Be Empty";

die(json_encode($obj));		
}

}

?>