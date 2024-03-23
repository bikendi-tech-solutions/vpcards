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


if(is_user_logged_in()){
	if(isset($_REQUEST["print_cards"])){
 extract(vtupress_user_details());
		$id = get_current_user_id();
	
	echo "
	<!DOCTYPE html>
	<html>
	<head>
	<title>Print Cards</title>
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0\">
	<link rel=\"stylesheet\" href=". $template_url."/default/csss"."/fontawesome-all.css?v=1\">
<link rel=\"stylesheet\" href=".esc_url(plugins_url("vtupress/css/bootstrap.min.css?v=1")).">
<style>
*{
	margin:0;
	padding:0;
	box-sizing:border-box;
}

</style>
	";
	vtupress_js_css_user_plain();
	echo"
	</head>
	<body>
	<div class='container-fluid my-4'>
		<div class='row px-1 gx-1 gy-2'>
	";
	if($_REQUEST["print_cards"] == "all"){
		
		
	global $wpdb;
	$table_name = $wpdb->prefix."scards";
	$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $table_name WHERE user_id= %d ORDER BY id DESC", $id));

if(empty($results)){
	die("NO CARDS TO PRINT");
}
	foreach($results as $result){
		$biz_name = ucfirst(esc_html($_REQUEST["biz_name"]));
		$network = strtoupper($result->type);
		$pi = $result->pin;
		$amount = $result->value;
		if($network == "MTN"){
			$col = 'bg-warning bg-gradient text-dark';

		}
		elseif($network == "GLO"){
			$col = 'bg-success bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
		}
		elseif($network == "9MOBILE"){
			$col = 'bg-success bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
		}
		else{
			$col = 'bg-danger bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
		}
		
	if(stripos($pi,'-')){
		$p = explode('-',$pi);
		$pin = trim($p[0]);
		$sn = $p[1];
		
		if(strtoupper($network) == "MTN"){
			
	if(strlen($pin) == 10){
			$load = 'Dial *3551*pin# To Recharge';
			}
		else{
			$load = 'Dial *311*pin# To Recharge';
		}

		$imgurl = plugins_url("vtupress/images/mtn.png");

		}
		elseif(strtoupper($network) == "GLO"){
			$imgurl = plugins_url("vtupress/images/glo.png");
		}
		elseif(strtoupper($network) == "AIRTEL"){
			$imgurl = plugins_url("vtupress/images/airtel.png");
		}
		elseif(strtoupper($network) == "9MOBILE"){
			$imgurl = plugins_url("vtupress/images/9mobile.png");
		}
		
		echo "
			<div class='col-12 col-md-6 col-lg-3 border $col bg  p-2 ' style='text-align:center;'>
				<div class='' style='float:left; '><h6>[ $biz_name ]</h6></div>
				<div class='' style='float:right; '><h5>₦$amount</h5></div>
				
				<div class='content' style='clear:both;'>
				<div class='mr-auto ml-auto '><img src='".$imgurl."' alt='".$network."' style='width:3em; height:3em;'/></div>
				<div class='mr-auto ml-auto '><h3>$pin</h3></div>
				</div>
			
				<div class='' ><small>$load || S/N: $sn</small></div>
			
			</div>
		";
	}
	else{
	
		if(strtoupper($network) == "MTN"){
			if(strlen($pi) == 10){
					$load = 'Dial *3551*pin# To Recharge';
					}
				else{
					$load = 'Dial *311*pin# To Recharge';
				}
		
				$imgurl = plugins_url("vtupress/images/mtn.png");
		
				}
				elseif(strtoupper($network) == "GLO"){
					$imgurl = plugins_url("vtupress/images/glo.png");
				}
				elseif(strtoupper($network) == "AIRTEL"){
					$imgurl = plugins_url("vtupress/images/airtel.png");
				}
				elseif(strtoupper($network) == "9MOBILE"){
					$imgurl = plugins_url("vtupress/images/9mobile.png");
				}
				
		echo "
			<div class='col-12 col-md-6 col-lg-3 border $col bg  p-2 ' style='text-align:center;'>
			<div class='' style='float:left; '><h6>[ $biz_name ]</h6></div>
				<div class='' style='float:right; '><h5>₦$amount</h5></div>
				<div class='content' style='clear:both;'>
				<div class='mr-auto ml-auto '><img src='".$imgurl."' alt='".$network."' style='width:3em; height:3em;'/></div>
				<div class='mr-auto ml-auto '><h3>$pi</h3></div>
				</div>
			<div class='' >$load</div>
			
			</div>
		";
		
	}
	
	
	}
	
	}
	
	elseif(!empty($_REQUEST["print_cards"])){
		$pins = $_REQUEST["print_cards"];
		$each = explode(',',$pins);
		
$pin = '';
#print_r($each);
foreach($each as $pi){
	
	if($pi == "0"){
	$pin .= "id = $pi ";
	}
	else{
	$pin .= " OR id = $pi ";
	}
}

	global $wpdb;
	$table_name = $wpdb->prefix."scards";
	$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $table_name WHERE user_id= %d AND ($pin) ORDER BY id DESC", $id));
if(empty($results)){
	die("NO CARDS TO PRINT");
}
	foreach($results as $result){
		$biz_name = ucfirst(esc_html($_REQUEST["biz_name"]));
		$network = strtoupper($result->type);
		$pi = trim($result->pin);
		$amount = $result->value;

		
	if(stripos($pi,'-')){
		$p = explode('-',$pi);
		$pin = trim($p[0]);
		$sn = $p[1];
		
				if($network == "MTN"){
			$col = 'bg-warning bg-gradient text-dark';
						
	if(strlen($pin) == 10){
		$load = 'Dial *3551*pin# To Recharge';
		}
	else{
		$load = 'Dial *311*pin# To Recharge';
	}
			$imgurl = plugins_url("vtupress/images/mtn.png");
		}
		elseif($network == "GLO"){
			$col = 'bg-success bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
			$imgurl = plugins_url("vtupress/images/glo.png");
		}
		elseif($network == "9MOBILE"){
			$col = 'bg-success bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
			$imgurl = plugins_url("vtupress/images/9mobile.png");
		}
		else{
			$col = 'bg-danger bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
			$imgurl = plugins_url("vtupress/images/airtel.png");
		}

		
		echo "
			<div class='col-12 col-md-6 col-lg-3 border $col bg  p-2 ' style='text-align:center;'>
				<div class='' style='float:left; '><h6>[ $biz_name ]</h6></div>
				<div class='' style='float:right; '><h5>₦$amount</h5></div>
				
				<div class='content' style='clear:both;'>
				<div class='mr-auto ml-auto '><img src='".$imgurl."' alt='".$network."' style='width:3em; height:3em;'/></div>
				<div class='mr-auto ml-auto '><h3>$pin</h3></div>
				</div>
			
				<div class='' ><small>$load || S/N: $sn</small></div>
			
			</div>
		";
	}
	else{
		
						if($network == "MTN"){
			$col = 'bg-warning bg-gradient text-dark';
						
	if(strlen($pi) == 10){
		$load = 'Dial *3551*pin# To Recharge';
		}
	else{
		$load = 'Dial *311*pin# To Recharge';
	}
			$imgurl = plugins_url("vtupress/images/mtn.png");
		}
		elseif($network == "GLO"){
			$col = 'bg-success bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
			$imgurl = plugins_url("vtupress/images/glo.png");
		}
		elseif($network == "9MOBILE"){
			$col = 'bg-success bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
			$imgurl = plugins_url("vtupress/images/9mobile.png");
		}
		else{
			$col = 'bg-danger bg-gradient text-white';
			$load = 'Dial *311*pin# To Recharge';
			$imgurl = plugins_url("vtupress/images/airtel.png");
		}
		
		echo "
			<div class='col-12 col-md-6 col-lg-3 border $col bg  p-2 ' style='text-align:center;'>
			<div class='' style='float:left; '><h6>[ $biz_name ]</h6></div>
				<div class='' style='float:right; '><h5>₦$amount</h5></div>
				<div class='content' style='clear:both;'>
				<div class='mr-auto ml-auto '><img src='".$imgurl."' alt='".$network."' style='width:3em; height:3em;'/></div>
				<div class='mr-auto ml-auto '><h3>$pi</h3></div>
				</div>
			<div class='' >$load</div>
			
			</div>
		";
		
	}
	
	
	}
	


	}
	else{

	die("NO CARDS TO PRINT");

	}
	
	
	echo "
	<div class='fixed-bottom'> <button class='btn btn-primary print'>PRINT</button></div>
	<script>
	
	jQuery('.print').on('click',function(){
		window.print();
	});
	</script>
		</div>
	</div>
	</body>
	</html>
	";
	
	}
}

?>