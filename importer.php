<?php
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
}
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');

$http_args = array(
'headers' => array(
'cache-control' => 'no-cache',
'Content-Type' => 'application/json'
),
'timeout' => '120',
'user-agent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
'sslverify' => false
);
	
if(vp_getoption("vp_access_importer") == "yes"){
if(isset($_REQUEST["recharge_select"])){
	$recharge_select = $_REQUEST["recharge_select"];
	vp_updateoption("recharge_select",$recharge_select);
$response =  wp_remote_retrieve_body( wp_remote_get( "https://vtupress.com/wp-content/plugins/vpimporter/vpimporter.php?recharge_import=$recharge_select",$http_args));
$json = json_decode($response, true);

if($json["available"] == "yes"){
foreach($json as $key => $value){
	switch($key){
            case"baseurl":
            vp_updateoption("recharge_baseurl","$value");
            break;
            case"format":
                vp_updateoption("recharge_format","$value");
            break;
		case"data":
            $plans = "";
		foreach($value as $key2 => $value2){
				//vp_updateoption("vtuaddheaders4","$key2");
				//vp_updateoption("vtuaddvalue4","$value2");
                //key2 - network
                //mkey - plan id
                //mvalue - plan name
            if(!empty($key2)){
                $plan_network = $key2;
                $plan_network_name = $value2;

            $plans .= "$plan_network-$plan_network_name,";
            }
		}
        vp_updateoption("recharge_plans","$plans");
		break;
		
	}
	
}
die("100");

}
else{
die("101");
}
	
}
}
?>