<?php
/**
*Plugin Name: VP Cards
*Plugin URI: http://vtupress.com
*Description: Add E-Recharge/Cards feature to your vtu business . An extension for vtupress plugin
*Version: 1.4.6
*Author: Akor Victor
*Author URI: https://facebook.com/akor.victor.39
*/
//VP CARDS is just an addon for vtupress and a plugin for wordpress to add recharge card printing business to wordpress via vtupress plugin as a addon to iterator_apply
#HELLO
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
};
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH.'wp-admin/includes/plugin.php');
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
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

require __DIR__.'/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/bikendi-tech-solutions/vpcards',
	__FILE__,
	'vpcards'
);
//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');
$myUpdateChecker->setAuthentication('your-token-here');
$myUpdateChecker->getVcsApi()->enableReleaseAssets();


add_action("vtupress_history_condition","addcardsservices");
function addcardsservices(){
  $bill = false;
  if($bill){

  }
  elseif($_GET["subpage"] == "recharge" && $_GET["type"] == "successful"){
    include_once(ABSPATH .'wp-content/plugins/vpcards/pages/scard.php');
  }
  elseif($_GET["subpage"] == "recharge" && $_GET["type"] == "unsuccessful"){
    include_once(ABSPATH .'wp-content/plugins/vpcards/pages/fcard.php');
  }
}


add_action("vtupress_gateway_tab","vpcardtab");
function vpcardtab(){
$tab = false;
if($tab){

}elseif($_GET["subpage"] == "card"){
    include_once(ABSPATH .'wp-content/plugins/vpcards/pages/vpcards.php');
}

}

add_action("vtupress_gateway_submenu","vpcardsubmenu");
function vpcardsubmenu(){
?>
  <li class="sidebar-item">
                    <a href="?page=vtupanel&adminpage=gateway&subpage=card" class="sidebar-link"
                      ><i class="fas fa-hashtag"></i
                      ><span class="hide-menu">Recharge Card</span></a
                    >
  </li>
<?php
}


add_action("vtupress_import_submenu","vpcardsubmenuimp");
function vpcardsubmenuimp(){
?>
  <li class="sidebar-item">
                    <a href="?page=vtupanel&adminpage=import&subpage=rechargecard" class="sidebar-link"
                      ><i class="fas fa-hashtag"></i
                      ><span class="hide-menu">Recharge Card</span></a
                    >
  </li>
<?php
}

add_action("vtupress_admin_list_import","vpcardslistimport");
function vpcardslistimport(){

if($_GET["subpage"] == "rechargecard"){
	include_once(ABSPATH .'wp-content/plugins/vpcards/formats/loader.php');
}
}



add_action("vtupress_history_submenu","addcardsubmenu");
function addcardsubmenu(){
?>
<li class="sidebar-item bg bg-success">
                  <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="fas fa-hashtag"></i
                  ><span class="hide-menu">Recharge Pins</span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                   <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=recharge&type=successful" class="sidebar-link"
                      ><i class="far fa-check-circle"></i
                      ><span class="hide-menu">Successful</span></a
                    >
                  </li>
                  <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=recharge&type=unsuccessful" class="sidebar-link"
                      ><i class="fas fa-ban"></i
                      ><span class="hide-menu">Failed</span></a
                    >
                  </li>
</ul> 
</li>
<?php
}




add_action("user_feature","cards_user_feature");
add_action("template_user_feature","cards_template_user_feature");
add_action("set_control","cards_set_control");
add_action("set_control_post","cards_set_control_post");


vp_addoption("cardsairtel",100);
vp_addoption("cardsglo",100);
vp_addoption("cardsmtn",100);
vp_addoption("cards9mobile",100);
vp_addoption("cardsapikey","abc123");
vp_addoption("cardscontrol","unchecked");
vp_addoption("airteldiscount",0);
vp_addoption("mtndiscount",0);
vp_addoption("glodiscount",0);
vp_addoption("9mobilediscount",0);




function create_cards(){

global $wpdb;
$table_name = $wpdb->prefix.'vpcards';
$charset_collate=$wpdb->get_charset_collate();
$sql= "CREATE TABLE IF NOT EXISTS $table_name(
id int  NOT NULL AUTO_INCREMENT,
network text,
value text,
pin text,
status text,
via text,
the_time text,
PRIMARY KEY (id))$charset_collate;";
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
dbDelta($sql);
}
//Default Datas to sairtime (s-airtime db)
function add_cards(){
global $wpdb;
$network='mtn';
$pin ='1234567890';
$status ='used';
$table_name = $wpdb->prefix.'vpcards';
$wpdb->insert($table_name, array(
'network' => $network,
'value' => '100',
'pin' => $pin,
'status' => $status,
'the_time' => current_time('mysql', 1)
));
}


function create_cards_transaction(){

global $wpdb;
$table_name = $wpdb->prefix.'scards';
$charset_collate=$wpdb->get_charset_collate();
$sql= "CREATE TABLE IF NOT EXISTS $table_name(
id int NOT NULL AUTO_INCREMENT,
name text ,
email varchar(255) DEFAULT '' ,
type text ,
value text ,
pin text ,
quantity text ,
bal_bf text ,
bal_nw text ,
amount text,
user_id int,
via int,
the_time text,
status text,
PRIMARY KEY (id))$charset_collate;";
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
dbDelta($sql);

}
//Default Datas to scards (s-airtime db)
function addcardsdata(){
global $wpdb;
$name='Akor Victor';
$email='vtupress.com@gmail.com';
$type ='mtn';
$value ='100';
$pin ='11111111';
$quantity = '1'; 
$bal_bf ='10';
$bal_nw ='0';
$amount= '0001';
$tid = '1';
$table_name = $wpdb->prefix.'scards';
$wpdb->insert($table_name, array(
'name'=> $name,
'email'=> $email,
'type' => $type,
'value' => $value,
'pin' => $pin,
'quantity' => $quantity,
'bal_bf' => $bal_bf,
'bal_nw' => $bal_nw,
'amount' => $amount,
'user_id' => $tid,
'status' => 'Successful',
'the_time' => current_time('mysql', 1)
));
}








function cards_gateway_tab(){
	

	




}





function cards_template_user_feature(){
	if(isset($_GET["vend"]) && $_GET["vend"]=="cards" && vp_getoption("cardscontrol") == "checked" && vp_getoption("resell") == "yes"){
		$id = get_current_user_id();
		$option_array = json_decode(get_option("vp_options"),true);
		$user_array = json_decode(get_user_meta($id,"vp_user_data",true),true);
		$data = get_userdata($id);
		
		$bal = vp_getuser($id, 'vp_bal', true);
		
		$plan = vp_getuser($id,'vr_plan',true);	
		global $level;	
	?>
			<div id="container">
	
	
			<style>
			.user-vends{
				border: 1px solid grey;
				border-radius: 5px;
				padding: 1rem !important;
			}
			</style>
	
			
			<div id="side-cards-w" class="pt-4 px-3">
	
			<div class="user-vends">
	<form class="for" id="cfor" method="post" <?php echo apply_filters('formaction','target="_self"');?>>
	
			 <div class="visually-hidden">
					<input type="hidden" name="vpname" class="form-control cards-name" placeholder="Name" aria-label="Name" aria-describedby="basic-addon1" value="<?php echo $data->user_login; ?>">
				</div>
				<div class="visually-hidden">
					<input type="hidden" name="vpemail" class="form-control cards-email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" value="<?php echo $data->user_email; ?>">
				</div>
				<div class="visually-hidden">		
					<input type="hidden" id="tcode" name="tcode" value="ccards">
					<input type="hidden" id="url" name="url">
					<input type="hidden" id="uniqidvalue" name="uniqidvalue" value="<?php echo uniqid('VTU-',false);?>">
					<input type="hidden" id="url1" name="url1" value="<?php echo esc_url(plugins_url("vtupress/process.php"));?>">
					<input type="hidden" id="id" name="id" value="<?php echo uniqid('VTU-',false);?>">
				</div>
	
	<div class="input-group mb-2 ">
	<span class="input-group-text">NETWORK</span>
	<select name="edutype" class="form-control form-select edutype">
	<option value="none">---Select---</option>
	<option value="mtn">MTN</option>
	<option value="glo">GLO</option>
	<option value="airtel">AIRTEL</option>
	<option value="9mobile">9MOBILE</option>
	</select>
	 <div id="validationServer04Feedback" class="invalid-feedback">
						  Error: <span class="cards-edutype-message"></span>
							</div>
	</div>
	<div class="input-group mb-2">
	<span class="input-group-text">Quantity</span>
	<select name="edunumber" class="form-control form-select edunumber">
	<option value="1">---Select---</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="10">10</option>
	<option value="20">20</option>
	<option value="30">30</option>
	<option value="40">40</option>
	<option value="50">50</option>
	<option value="100">100</option>
	</select>
	 <div id="validationServer04Feedback" class="invalid-feedback">
						  Error: <span class="cards-sender-error-message"></span>
							</div>
	</div>
	<div class="input-group mb-2">
	<span class="input-group-text">DOMINATION</span>
	<select name="domination" class="form-control form-select domination">
	<option value="100">100</option>
	<option value="200">200</option>
	<option value="500">500</option>
	<option value="1000">1000</option>
	</select>
	 <div id="validationServer04Feedback" class="invalid-feedback">
						  Error: <span class="cards-sender-error-message"></span>
							</div>
	</div>
	<br>
	
	 <div class="input-group mb-2">
						<span class="input-group-text" id="basic-addon1">NGN.</span>
						<input id="amt" name="amount" type="number" class="form-control cards-amount" max="<?php echo $bal;?>" placeholder="Amount" aria-label="Username" aria-describedby="basic-addon1" readonly required>
						<span class="input-group-text" id="basic-addon1">.00</span>
						<div id="validationServer04Feedback" class="invalid-feedback">
						  Error: <span class="cards-amount-error-message"></span>
						  </div>
	 </div>
	   <div class="vstack gap-2">
						<button type="button" class="btn w-full p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow   purchase-cards" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">PRINT</button>
	  </div>	
				
	</form>
	</div>
		  <!--The Modal-->
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
					  <div class="modal-content">
						<div class="modal-header">
						  <h5 class="modal-title" id="exampleModalLabel">cards Purchase Confirmation</h5>
						  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
						<div>
						Network : <span class="cards-network-confirm"></span><br>
						Quantity : <span class="cards-quantity-confirm"></span><br>
						Amount : ₦<span class="cards-amount-confirm"></span><br>
						Status : <span class="cards-status-confirm"></span><br>
						<div class="input-group form">
						<span class="input-group-text">PIN</span>
						<input class="form-control pin" type="number" name="pin">
						</div>
						</div>
						</div>
						<div class="modal-footer">
						  <button type="button" class="p-2 text-xs font-bold text-white uppercase bg-gray-600 rounded shadow  data-proceed-cancled btn-danger" data-bs-dismiss="modal">Cancel</button>
						  <button type="button" name="wallet" id="wallet" class="p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow cards-proceed btn-success" form="cfor">Proceed</button>
						</div>
					  </div>
					</div>
				</div>
			
			
			</div>
			
			<script>
			
			jQuery(".edunumber").on("change",function(){
				domination();
			});
			
					jQuery(".domination").on("change",function(){
						domination();
					});
					
	function domination(){
			
				var str = jQuery(".domination").val();
				var edunumber = jQuery(".edunumber").val();
				var cards = jQuery(".edutype").val();
				var numbers;
				var price;
				var discount;
				switch(cards){
					case"glo":
					
					price = parseFloat(str - ((<?php
	
					$s = (floatval($level[0]->card_glo));
					echo $s;
	
					?>*str)/100) )* edunumber;
					
					jQuery(".cards-amount").val(price);
					jQuery(".cards-amount-confirm").text(price);
					break;
					case "airtel":
					
					price = parseFloat(str - ((<?php
	
					$s = (floatval($level[0]->card_airtel));
					echo $s;
	
					?>*str)/100) ) * edunumber;
					
					jQuery(".cards-amount").val(price);
					jQuery(".cards-amount-confirm").text(price);
					break;
					case "mtn":
					
					price = parseFloat(str - ((<?php
	
					$s = (floatval($level[0]->card_mtn));
					echo $s;
	
					?>*str)/100) ) * edunumber;
				
					jQuery(".cards-amount").val(price);
					jQuery(".cards-amount-confirm").text(price);
					break;
					case "9mobile":
						
					price = parseFloat(str - ((<?php
	
					$s = (floatval($level[0]->card_9mobile));
					echo $s;
	
					?>*str)/100) ) * edunumber;
				
					jQuery(".cards-amount").val(price);
					jQuery(".cards-amount-confirm").text(price);
					break;
				}
	
				var total_amount = price;
				jQuery(".cards-amount").val(total_amount);
				jQuery(".cards-amount-confirm").text(price);
				
			};
			
			jQuery(".edutype").on("change",function(){
				domination();
			});
			
	jQuery(".purchase-cards").click(function(){
		domination();
		var total_amount = 	jQuery(".cards-amount").val();
				
				jQuery(".cards-network-confirm").text(jQuery(".edutype").val());
				jQuery(".cards-quantity-confirm").text(jQuery(".edunumber").val());
	
				
	if( jQuery(".edutype").val() == "none" ){
					jQuery(".edutype").addClass("is-invalid");
					jQuery(".edutype").removeClass("is-valid");
					jQuery(".cards-edutype-message").text("Please Select One");
					jQuery(".cards-proceed").hide();
					jQuery(".cards-status-confirm").text("Please Select One Network");
	}
	else{
		
					
				if(total_amount <= <?php echo $bal;?> && total_amount > 0){
				jQuery(".cards-proceed").show();
					jQuery(".cards-amount").removeClass("is-invalid");
					jQuery(".cards-amount").addClass("is-valid");
					jQuery(".cards-status-confirm").text("Correct");
	jQuery(".cards-proceed").show();
	jQuery(".edutype").addClass("is-valid");
	jQuery(".edutype").removeClass("is-invalid");
	jQuery(".cards-status-confirm").text("Correct");
				}
				else if(total_amount > <?php echo $bal;?> || total_amount <= 0){
				jQuery(".cards-status-confirm").text("Balance Too Low");
				jQuery(".cards-proceed").hide();
				jQuery(".cards-amount").addClass("is-invalid");
				jQuery(".cards-amount-error-message").text("Balance Too Low");
				}
		
	
	}	
			
		
			});
			
			
			
					
	jQuery(".cards-proceed").click(function(){
		
		domination();
		
		jQuery('.btn-close').trigger('click');
		jQuery.LoadingOverlay("show");
		
	var obj = {};
	obj["vend"] = "vend";
	obj["vpname"] = jQuery(".cards-name").val();
	obj["vpemail"] = jQuery(".cards-email").val();
	obj["tcode"] = jQuery("#tcode").val();
	obj["uniqidvalue"] = jQuery("#uniqidvalue").val();
	obj["id"] = jQuery("#id").val();
	obj["amount"] = jQuery("#amt").val();
	obj["quantity"] = jQuery(".edunumber").val();
	obj["edutype"] = jQuery(".edutype").val();
	obj["domination"] = jQuery(".domination").val();
	obj["pin"] = jQuery(".pin").val();
	
	
	jQuery.ajax({
	  url: '<?php echo esc_url(plugins_url("vpcards/index.php"));?>',
	  data: obj,
	  dataType: 'json',
	  'cache': false,
	  "async": true,
	  error: function (jqXHR, exception) {
		  jQuery.LoadingOverlay("hide");
			var msg = "";
			if (jqXHR.status === 0) {
				msg = "No Connection.\n Verify Network.";
		 swal({
	  title: "Error!",
	  text: msg,
	  icon: "error",
	  button: "Okay",
	});
	  
			} else if (jqXHR.status == 404) {
				msg = "Requested page not found. [404]";
				 swal({
	  title: "Error!",
	  text: msg,
	  icon: "error",
	  button: "Okay",
	});
			} else if (jqXHR.status == 500) {
				msg = "Internal Server Error [500].";
				 swal({
	  title:  msg ,
	  text:  jqXHR.responseText,
	  icon: "error",
	  button: "Okay",
	});
			} else if (exception === "parsererror") {
				msg = jqXHR.responseText;
				   swal({
	  title: "Error",
	  text: msg,
	  icon: "error",
	  button: "Okay",
	});
			} else if (exception === "timeout") {
				msg = "Time out error.";
				 swal({
	  title: "Error!",
	  text: msg,
	  icon: "error",
	  button: "Okay",
	});
			} else if (exception === "abort") {
				msg = "Ajax request aborted.";
				 swal({
	  title: "Error!",
	  text: msg,
	  icon: "error",
	  button: "Okay",
	});
			} else {
				msg = "Uncaught Error.\n" + jqXHR.responseText;
				 swal({
	  title: "Error!",
	  text: msg,
	  icon: "error",
	  button: "Okay",
	});
			}
		},
	  
	  success: function(data) {
		jQuery.LoadingOverlay("hide");
			 if(data.code == "100"){
			var val = data.pin;
			var result = val.includes("-");
			if(result === true){
				var split = val.split("-");
				var pin = split[0];
				var ser = split[1];
			  swal({
	  title: "PIN: ["+pin+"]",
	  text: "SERIAL NO: ["+ser+"]",
	  icon: "success",
	  button: "Okay",
	}).then((value) => {
		location.reload();
	});
			}
			else{
		swal({
	  title: "PIN ["+data.pin+"]",
	  text: "Thanks For Your Patronage",
	  icon: "success",
	  button: "Okay",
	}).then((value) => {
		location.reload();
	});	
			}
		  }
		  else{
		swal(data.message, {
		  icon: "error",
		}); 
		  }
	  },
	  type: 'POST'
	});
	
	});
			
			
			
			</script>
			
	</div>
			
			
			<?php
			
	
			}
	}



function cards_user_feature(){
if(isset($_GET["vend"]) && $_GET["vend"]=="cards" && vp_getoption("cardscontrol") == "checked" && vp_getoption("resell") == "yes"){
$id = get_current_user_id();
$option_array = json_decode(get_option("vp_options"),true);
$user_array = json_decode(get_user_meta($id,"vp_user_data",true),true);
$data = get_userdata($id);

$bal = vp_getuser($id, 'vp_bal', true);

$plan = vp_getuser($id,'vr_plan',true);
		
		?>
		<div id="dashboard-main-content">
<section class="container mx-auto">
<div class="p-md-5 p-1">
<div class="bg-white shadow">
<div class="dark-white flex items-center justify-between p-5 bg-gray-100">
<h1 class="text-xl font-bold">
<span class="lg:inline">Ecards</span>
</h1>
<div class="font-bold tracking-wider">
<span class="dark inline-block px-3 py-1 bg-gray-200 border rounded-lg cursor-pointer" x-text="`NGN ${$format(total_sum)}`">NGN<?php echo $bal;?></span>
</div>
</div>
<div class="p-2 bg-white lg:p-5">
<template x-for="transaction in transactions"></template>


		<style>
		.user-vends{
			border: 1px solid grey;
			border-radius: 5px;
			padding: 1rem !important;
		}
		</style>

		
		<div id="side-cards-w">
		cards<br>
<div class="mb-2 row" style="height:fit-content;">
       <span style="float:left;" class="col"> Wallet: ₦<?php echo $bal;
	   
	   global $level;
	   ?></span>
<span style="float:right;" class="col"><a href="?vend=wallet" style="text-decoration:none; float:right;" class="btn-primary btn-sm">Fund Wallet</a></span>

</div>


		<div class="user-vends">
<form class="for" id="cfor" method="post" <?php echo apply_filters('formaction','target="_self"');?>>

		 <div class="visually-hidden">
                <input type="hidden" name="vpname" class="form-control cards-name" placeholder="Name" aria-label="Name" aria-describedby="basic-addon1" value="<?php echo $data->user_login; ?>">
            </div>
            <div class="visually-hidden">
                <input type="hidden" name="vpemail" class="form-control cards-email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" value="<?php echo $data->user_email; ?>">
            </div>
			<div class="visually-hidden">		
				<input type="hidden" id="tcode" name="tcode" value="ccards">
				<input type="hidden" id="url" name="url">
				<input type="hidden" id="uniqidvalue" name="uniqidvalue" value="<?php echo uniqid('VTU-',false);?>">
				<input type="hidden" id="url1" name="url1" value="<?php echo esc_url(plugins_url("vtupress/process.php"));?>">
				<input type="hidden" id="id" name="id" value="<?php echo uniqid('VTU-',false);?>">
			</div>

<div class="input-group mb-2 ">
<span class="input-group-text">NETWORK</span>
<select name="edutype" class="form-control form-select edutype">
<option value="none">---Select---</option>
<option value="mtn">MTN</option>
<option value="glo">GLO</option>
<option value="airtel">AIRTEL</option>
<option value="9mobile">9MOBILE</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="cards-edutype-message"></span>
						</div>
</div>
<div class="input-group mb-2">
<span class="input-group-text">Quantity</span>
<select name="edunumber" class="form-control form-select edunumber">
<option value="1">---Select---</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="10">10</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="cards-sender-error-message"></span>
						</div>
</div>
<div class="input-group mb-2">
<span class="input-group-text">DOMINATION</span>
<select name="domination" class="form-control form-select domination">
<option value="100">100</option>
<option value="200">200</option>
<option value="500">500</option>
<option value="1000">1000</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="cards-sender-error-message"></span>
						</div>
</div>
<br>

 <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1">NGN.</span>
                    <input id="amt" name="amount" type="number" class="form-control cards-amount" max="<?php echo $bal;?>" placeholder="Amount" aria-label="Username" aria-describedby="basic-addon1" readonly required>
                    <span class="input-group-text" id="basic-addon1">.00</span>
                    <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="cards-amount-error-message"></span>
                      </div>
 </div>
   <div class="vstack gap-2">
                    <button type="button" class="btn btn-secondary  w-full p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow   purchase-cards" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Print</button>
  </div>	
			
</form>
</div>
	  <!--The Modal-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">cards Purchase Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div>
                    Network : <span class="cards-network-confirm"></span><br>
                    Quantity : <span class="cards-quantity-confirm"></span><br>
                    Amount : ₦<span class="cards-amount-confirm"></span><br>
                    Status : <span class="cards-status-confirm"></span><br>
					<div class="input-group form">
					<span class="input-group-text">PIN</span>
					<input class="form-control pin" type="number" name="pin">
					</div>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary  p-2 text-xs font-bold text-dark uppercase bg-gray-600 rounded shadow  data-proceed-cancled" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" name="wallet" id="wallet" class="btn btn-primary  p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow cards-proceed" form="cfor">Proceed</button>
                    </div>
                  </div>
                </div>
            </div>
    	
		
		</div>
		
		<script>
		
		jQuery(".edunumber").on("change",function(){
			domination();
		});
		
				jQuery(".domination").on("change",function(){
					domination();
				});
				
function domination(){
		
			var str = jQuery(".domination").val();
			var edunumber = jQuery(".edunumber").val();
			var cards = jQuery(".edutype").val();
			var numbers;
			var price;
			var discount;
			switch(cards){
				case"glo":
				
				price = parseFloat(str - ((<?php

				$s = (floatval($level[0]->card_glo));
				echo $s;

				?>*str)/100) )* edunumber;
				
				jQuery(".cards-amount").val(price);
				jQuery(".cards-amount-confirm").text(price);
				break;
				case "airtel":
				
				price = parseFloat(str - ((<?php

				$s = (floatval($level[0]->card_airtel));
				echo $s;

				?>*str)/100) ) * edunumber;
				
				jQuery(".cards-amount").val(price);
				jQuery(".cards-amount-confirm").text(price);
				break;
				case "mtn":
				
				price = parseFloat(str - ((<?php

				$s = (floatval($level[0]->card_mtn));
				echo $s;

				?>*str)/100) ) * edunumber;
			
				jQuery(".cards-amount").val(price);
				jQuery(".cards-amount-confirm").text(price);
				break;
				case "9mobile":
					
				price = parseFloat(str - ((<?php

				$s = (floatval($level[0]->card_9mobile));
				echo $s;

				?>*str)/100) ) * edunumber;
			
				jQuery(".cards-amount").val(price);
				jQuery(".cards-amount-confirm").text(price);
				break;
			}

			var total_amount = price;
			jQuery(".cards-amount").val(total_amount);
			jQuery(".cards-amount-confirm").text(price);
			
		};
		
		jQuery(".edutype").on("change",function(){
			domination();
		});
		
jQuery(".purchase-cards").click(function(){
	domination();
	var total_amount = 	jQuery(".cards-amount").val();
			
			jQuery(".cards-network-confirm").text(jQuery(".edutype").val());
			jQuery(".cards-quantity-confirm").text(jQuery(".edunumber").val());

			
if( jQuery(".edutype").val() == "none" ){
				jQuery(".edutype").addClass("is-invalid");
				jQuery(".edutype").removeClass("is-valid");
				jQuery(".cards-edutype-message").text("Please Select One");
				jQuery(".cards-proceed").hide();
				jQuery(".cards-status-confirm").text("Please Select One Network");
}
else{
	
				
			if(total_amount <= <?php echo $bal;?> && total_amount > 0){
			jQuery(".cards-proceed").show();
				jQuery(".cards-amount").removeClass("is-invalid");
				jQuery(".cards-amount").addClass("is-valid");
				jQuery(".cards-status-confirm").text("Correct");
jQuery(".cards-proceed").show();
jQuery(".edutype").addClass("is-valid");
jQuery(".edutype").removeClass("is-invalid");
jQuery(".cards-status-confirm").text("Correct");
			}
			else if(total_amount > <?php echo $bal;?> || total_amount <= 0){
			jQuery(".cards-status-confirm").text("Balance Too Low");
			jQuery(".cards-proceed").hide();
			jQuery(".cards-amount").addClass("is-invalid");
			jQuery(".cards-amount-error-message").text("Balance Too Low");
			}
	

}	
		
	
		});
		
		
		
				
jQuery(".cards-proceed").click(function(){
	
	domination();
	
	jQuery('.btn-close').trigger('click');
	jQuery("#cover-spin").show();
	
var obj = {};
obj["vend"] = "vend";
obj["vpname"] = jQuery(".cards-name").val();
obj["vpemail"] = jQuery(".cards-email").val();
obj["tcode"] = jQuery("#tcode").val();
obj["uniqidvalue"] = jQuery("#uniqidvalue").val();
obj["id"] = jQuery("#id").val();
obj["amount"] = jQuery("#amt").val();
obj["quantity"] = jQuery(".edunumber").val();
obj["edutype"] = jQuery(".edutype").val();
obj["domination"] = jQuery(".domination").val();
obj["pin"] = jQuery(".pin").val();


jQuery.ajax({
  url: '<?php echo esc_url(plugins_url("vpcards/index.php"));?>',
  data: obj,
  dataType: 'json',
  'cache': false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery("#cover-spin").hide();
        var msg = "";
        if (jqXHR.status === 0) {
            msg = "No Connection.\n Verify Network.";
     swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
  
        } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
			 swal({
  title:  msg ,
  text:  jqXHR.responseText,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = jqXHR.responseText;
			   swal({
  title: "Error",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "timeout") {
            msg = "Time out error.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "abort") {
            msg = "Ajax request aborted.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else {
            msg = "Uncaught Error.\n" + jqXHR.responseText;
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        }
    },
  
  success: function(data) {
	jQuery("#cover-spin").hide();
         if(data.code == "100"){
		var val = data.pin;
		var result = val.includes("-");
		if(result === true){
			var split = val.split("-");
			var pin = split[0];
			var ser = split[1];
		  swal({
  title: "PIN: ["+pin+"]",
  text: "SERIAL NO: ["+ser+"]",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
		}
		else{
	swal({
  title: "PIN ["+data.pin+"]",
  text: "Thanks For Your Patronage",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});	
		}
	  }
	  else{
	swal(data.message, {
      icon: "error",
    }); 
	  }
  },
  type: 'POST'
});

});
		
		
		
		</script>
		
	</div>
</div>

</div>
</section>
</div>
		
		
		<?php
		

		}
}





function cards_set_control(){
	
	echo'
	if(jQuery("#cardscontrol").is(":checked")){
		var cardsc = "checked";
	}
	else{
		var cardsc = "unchecked";
	}
	
obj["cardscontrol"] = cardsc;
	';
	
}

function cards_set_control_post(){
vp_updateoption("cardscontrol",$_REQUEST["cardscontrol"]);	
}

if(vp_getoption("resolve_cards") != "8"){
	global $wpdb;
	$table_name = $wpdb->prefix.'scards';
    $data = [ 'status' => 'Successful' ];
    $where = [ 'status' => NULL ];
    $updated = $wpdb->update($table_name, $data, $where);
	

vp_updateoption("resolve_cards","8");
}


add_action("transaction_button","vpcards_transaction_button");
add_action("transaction_style","vpcards_transaction_style");
add_action("transaction_failed_case","vpcards_failed");
add_action("transaction_successful_case","vpcards_success");
add_action('vpttab', 'vpcards_tab');

function vpcards_transaction_style(){
	echo'
	.rsuccess{
		display:none;
	}
	.rfailed{
		display:none;
	}
	';
}
function vpcards_transaction_button(){
	echo"
	<option value='cards'>ECards</option>
	";
}






$id = get_current_user_id();
add_action("add_user_history_button","cards_history_button");
add_action("add_user_history_tab","cards_history_tab");

function cards_history_button(){
	echo'
	<a href="?vend=history&for=transactions&type=ecards" class="pe-2 text-decoration-none">	<button class="cards-hist btn-sm btn-primary btn"> <i class="mdi mdi-barcode-scan "></i> >Ecards</button> </a>
	';
	
}



function cards_history_tab(){
	if($_GET["for"] == "transactions"){
		if($_GET["type"] == "ecards"){		
echo'	

	<div id="cardshist" class="thistory bg bg-white">

		<button class="btn download_ecards_s_history btn-primary me-3" style="float:left;">DOWNLOAD ECARDS HISTORY</button>
		<button class="btn print_ecards_s_history btn-primary" style="float:left;">PRINT SUCCESSFUL PINS</button>
		<br>
		<br>
		<br>

		<table class="d-flex justify-content-md-center table table-responsive table-hover history-successful ecards_s_history mt-2" id="ecardsshistory">
		<tbody>
		';
$id = get_current_user_id();
/*
global $wpdb;
$table_name = $wpdb->prefix.'scards';
$resultsad = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $table_name WHERE user_id= %d ORDER BY id DESC", $id));
*/

pagination_before_front("?vend=history","ecards","ecards", "scards", "resultsad", "WHERE user_id = $id");

pagination_after_front("?vend=history","ecards","ecards");

global $resultsad;
echo"
<tr>
<th scope='col'><input type='checkbox' class='checkall' > Id</th>
<th scope='col'>Via</th>
<th scope='col'>Network</th>
<th scope='col'>Pin - Serial No.</th>
<th scope='col'>Value</th>
<th scope='col'>Amount</th>
<th scope='col'>Previous Balance</th>
<th scope='col'>Current Balance</th>
<th scope='col'>Time</th>
<th scope='col'>Receipt</th>
</tr>
";
foreach ($resultsad as $resultsa){ 
echo "
<tr>
<td scope='row'><input type='checkbox' value='".$resultsa->id."' class='checkcards' > ".$resultsa->id."</td>
<td>".$resultsa->via."</td>
<td>".$resultsa->type."</td>
<td>".$resultsa->pin."</td>
<td>".$resultsa->value."</td>
<td>".$resultsa->amount."</td>
<td>".$resultsa->bal_bf."</td>
<td>".$resultsa->bal_nw."</td>
<td>".$resultsa->the_time."</td>
<td>
<button type='button' class=\"btn btn-sm btn-secondary p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow  show_cards".$resultsa->id."\" data-bs-toggle=\"modal\" data-bs-target=\"#cexampleModal".$resultsa->id."\" data-bs-whatever='@getbootstrap'>VIEW</button>
";
echo '
            <div class="modal fade" id="cexampleModal'.$resultsa->id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">'.strtoupper($resultsa->type).' Purchase Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
						<div class="container-fluid border border-secondary" id="ecardsreceipt'.$resultsa->id.'">
								<div class="row bg bg-dark text-white">
									<div class="col bg bg-dark text-white">
										<span class=""><h3>@INVOICE</h3></span>
									</div>
								</div>
							
							
						<div class="row p-4">
							
							<div class="row bg text-dark border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>ID</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.strtoupper($resultsa->id).'</h5></span>
								</div>
							</div>
							
							<div class="row bg text-dark border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>TYPE</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.strtoupper($resultsa->type).'</h5></span>
								</div>
							</div>
							
							<div class="row bg text-dark border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>TIME</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.strtoupper($resultsa->the_time).'</h5></span>
								</div>
							</div>
							
							
							';
							if(stripos(strtoupper($resultsa->pin), '-')){
								$pin = explode('-',strtoupper($resultsa->pin));
								echo'
							<div class="row bg bg-secondary text-white border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>PIN</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.$pin[0].'</h5></span>
								</div>
							</div>
							<div class="row bg bg-secondary text-white border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>Serial Number</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.$pin[1].'</h5></span>
								</div>
							</div>
							';
							}
							else{
							echo'
							<div class="row bg bg-secondary text-white border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>PIN</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.strtoupper($resultsa->pin).'</h5></span>
								</div>
							</div>
';							
								
							}
							
							echo'
							
						</div>
							
						
						
						</div>
		
					</div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary p-2 text-xs font-bold text-black uppercase bg-grey-600 rounded shadow  data-proceed-cancled" data-bs-dismiss="modal">Cancel</button>
					  <button type="button" id="" class="btn btn-info p-2 text-xs font-bold text-white uppercase bg-blue-600 rounded shadow "  onclick="printContent(\'ecardsreceipt'.$resultsa->id.'\');">Print</button>
                      <button type="button" name="cards_receipt" id="cardsreceipt'.$resultsa->id.'" class="btn btn-primary p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow  cards_proceed'.$resultsa->id.'" >Download</button>
                    </div>
                  </div>
                </div>
            </div>
';
echo"
		<script>
jQuery(\".cards_proceed".$resultsa->id."\").on(\"click\",function(){
 var element = document.getElementById(\"ecardsreceipt".$resultsa->id."\");
 jQuery('#cover-spin').show();
html2pdf(element, {
  margin:       10,
  filename:     'cards.pdf',
  image:        { type: 'jpeg', quality: 0.98 },
  html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
  jsPDF:        { unit:'mm', format: 'a4', orientation:'portrait' }
});

 jQuery('#cover-spin').hide();
});
/*
var el = jQuery(\'.cards_s_history\').clone();
            jQuery(\'.clo\').append(el);
			*/
</script>

</td>
</tr>
";
}
echo'</tbody>
		</table>
		<br>

<script>
jQuery(".download_ecards_s_history").on("click",function(){
 var element = document.getElementById("ecardsshistory");
html2pdf(element, {
  margin:       10,
  filename:     \'ecards.pdf\',
  image:        { type: \'jpeg\', quality: 0.98 },
  html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
  jsPDF:        { unit:\'mm\', format: \'a4\', orientation:\'portrait\' }
});
});

	jQuery(".checkall").on("change",function(){

	 jQuery("input[type=checkbox].checkcards").prop("checked", jQuery(this).prop("checked"));

	});

jQuery(".print_ecards_s_history").on("click",function(){
 let person = prompt("Please enter a business name", "");
 
 var pins = 0;
 jQuery(".checkcards:checked").each(function(){
	 var val = jQuery(this).val();
	pins += ","+val;
 });
 
	
 if(person != null && person.length > 0){
	 if(pins == 0){
	window.location.href = "'.get_home_url().'/wp-content/plugins/vpcards/print.php?print_cards=all&biz_name="+person;	
	 }
	 else{
	window.location.href = "'.get_home_url().'/wp-content/plugins/vpcards/print.php?print_cards="+pins+"&biz_name="+person;	 
	 }
 }

});

</script>

</div>	
	
';	
}
	}
}





register_activation_hook(__FILE__,"create_cards_transaction");
register_activation_hook(__FILE__,"addcardsdata");
register_activation_hook(__FILE__,"create_cards");
register_activation_hook(__FILE__,"add_cards");


$version = 6;
if(vp_getoption("recharge_card_database_version") != $version ){
	global $wpdb;
	$table_name = $wpdb->prefix."scards";
	$table_namev = $wpdb->prefix."vpcards";
	maybe_add_column($table_name,"via","ALTER TABLE $table_name ADD via text");
	maybe_add_column($table_namev,"via","ALTER TABLE $table_namev ADD via text");
	vp_updateoption("recharge_card_database_version",$version);
}

