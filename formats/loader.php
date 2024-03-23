<?php
  $option_array = json_decode(get_option("vp_options"),true);
if(current_user_can("vtupress_access_users")){
?>

<div class="container-fluid license-container">
            <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
            <style>
                div.vtusettings-container *{
                    font-family:roboto;
                }
                .swal-button.swal-button--confirm {
                    width: fit-content;
                    padding: 10px !important;
                }
            </style>

<p style="visibility:hidden;">
Please take note to always have security system running and checked. DO not disclose your login details to anyone except for confidential reasons. 
Not even the developers of this plugin should be trusted enough to grant access anyhow.

                  </p>


<?php
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
}
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH .'wp-content/plugins/vtupress/admin/pages/history/functions.php');
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');

?>

<div class="row">

    <div class="col-12">
    <link
      rel="stylesheet"
      type="text/css"
      href="<?php echo esc_url(plugins_url("vtupress/admin")); ?>/assets/extra-libs/multicheck/multicheck.css"
    />
    <link
      href="<?php echo esc_url(plugins_url("vtupress/admin")); ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
      rel="stylesheet"
    />
<div class="card">
                <div class="card-body">
                  <h5 class="card-title">RECHARGE CARD IMPORTER</h5> 
                  <div class="table-responsive">
<div class="p-4">

    <div class="row mb-3 p-4 border border-secondary">
            <div class="col col-1">
                <li class="fas fa-info-circle align-middle"></li>
            </div>
            <div class="col col-11">
            Please note that the listed vendors does not belong to vtupress and issues with them should be directed to their admins/customer care reps.
          </div>
    </div>


<div class="row">

<div class="col recharge">

<span class="input-group-text">SELECT PROVIDER:</span>
<select name="recharge_select" class="recharge_select" >
<option value="<?php echo vp_option_array($option_array,"recharge_select");?>"><?php echo vp_option_array($option_array,"recharge_select");?></option>

<?php
$data = file_get_contents("https://vtupress.com/wp-content/plugins/vpimporter/vpimporter.php?recharge_names");
$json = json_decode($data, true);
foreach($json as $key => $value){
	?>
	<option value='<?php echo $value;?>'><?php echo ucfirst($key);?></option>
	<?php
}
?>
</select>
<input type="button" name="recharge_import" class="recharge_import" value="IMPORT">

</div>


</div>

<script>

jQuery(".recharge_import").click(function(){
	jQuery("#cover-spin").show();
var obj = {};
var toatl_input = jQuery(".recharge select, .recharge input").length;
var run_obj;

for(run_obj = 0; run_obj <= toatl_input; run_obj++){
var current_input = jQuery(".recharge select, .recharge input").eq(run_obj);


var obj_name = current_input.attr("name");
var obj_value = current_input.val();

if(typeof obj_name !== typeof undefined && obj_name !== false){
obj[obj_name] = obj_value;
}
	
}

jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vpcards/importer.php'));?>",
  data: obj,
  dataType: "text",
  "cache": false,
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
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
			   swal({
  title: msg,
  text: jqXHR.responseText,
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
        if(data == "100" ){
	
		  swal({
  title: "Imported!",
  text: "Go To The Service To See Changes",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else if(data == "101" ){
jQuery("#cover-spin").hide();
var select = jQuery(".recharge_select option:selected").text();
	swal({
  title: "Error",
  text: jQuery(".recharge_select option:selected").text()+" Importer Doesn\'t Exist  For This Service",
  icon: "error",
  button: "Okay",
});	  
	  }
	  else{
		  
	jQuery("#cover-spin").hide();
	 swal({
  title: "Error!",
  text: data,
  icon: "warning",
  button: "Okay",
});
	  }
  },
  type: "POST"
});

});

</script>

</div>







<?php   
}

/*
1. The name
2. Plan ID associated to the name
3. format
4. url

*/
//LOADER

//$recharge_select = vp_getoption("recharge_select");
$recharge_baseurl = vp_getoption("recharge_baseurl");
$recharge_format = vp_getoption("recharge_format");
$recharge_apikey = vp_getoption("recharge_apikey");
$recharge_plans = vp_getoption("recharge_plans");

?>


<label class="d-none">FORMAT:</label><br>
<input type="text" class="form-control mb-1 d-none card_format" name="rechargeformat" value="<?php echo lcfirst($recharge_format);?>" />

<label  class="d-none">BASE URL:</label><br>
<input type="text" class="form-control mb-1 d-none card_baseurl" name="rechargebaseurl" value="<?php echo lcfirst($recharge_baseurl);?>" />

<label>API KEY:</label><br>
<input type="text" class="form-control mb-1 card_apikey" name="rechargeapikey" value="<?php echo $recharge_apikey;?>" />

<label>SELECT NETWORK:</label><br>
<select class="form-control mb-1 card_plan" name="rechargenetwork">
    <?php
    $each_plan_data = explode(",",$recharge_plans);
    
    foreach($each_plan_data as $rechargelist){
        $ddatas = explode("-",$rechargelist);

        if(!empty($ddatas) && isset($ddatas[1])){
        ?>
    <option plan-network="<?php echo  trim($ddatas[0]);?>"  plan-network-name="<?php echo  trim($ddatas[1]);?>" ><?php echo ucfirst(trim($ddatas[1]));?></option>
    <?php
    }
  }

    ?>
</select>


<label>AMOUNT:</label><br>
<input type="text" class="form-control mb-1 card_amount" name="rechargeamount" value="" />

<label>SELECT QUANTITY:</label><br>
<select class="form-control mb-1 card_quantity" name="rechargeplan">
<option value="1"> 1 </option>
<option value="2"> 2 </option>
<option value="5"> 5 </option>
<option value="10"> 10 </option>
<option value="15"> 15 </option>
<option value="20"> 20 </option>
<option value="25"> 25 </option>
<option value="30"> 30 </option>
<option value="40"> 40 </option>
<option value="50"> 50 </option>
<option value="60"> 60 </option>
<option value="70"> 70 </option>
<option value="80"> 80 </option>
<option value="90"> 90 </option>
<option value="100"> 100 </option>
</select>

<input type="button" value="PURCHASE" onclick="purchase_pins()" />


<script>

function purchase_pins(){
	jQuery("#cover-spin").show();
var obj = {};
var format = jQuery(".card_format").val();
var baseurl = jQuery(".card_baseurl").val();
var apikey = jQuery(".card_apikey").val();
var network = jQuery(".card_plan").find(':selected').attr('plan-network');
var network_name = jQuery(".card_plan").find(':selected').attr('plan-network-name');
var amount = jQuery(".card_amount").val();
var quantity = jQuery(".card_quantity").val();





obj["format"] = format;
obj["baseurl"] = baseurl;
obj["apikey"] = apikey;
obj["network"] = network;
obj["network_name"] = network_name;
obj["amount"] = amount;
obj["quantity"] = quantity;


jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vpcards/vend.php'));?>",
  data: obj,
  dataType: "text",
  "cache": false,
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
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
			   swal({
  title: msg,
  text: jqXHR.responseText,
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
        if(data == "100" ){
	
		  swal({
  title: "LOADED!",
  text: quantity+" Pins Successfully Loaded",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else{
jQuery("#cover-spin").hide();
var select = jQuery(".recharge_purchase_select option:selected").text();
	swal({
  title: "Error Loading",
  text: data,
  icon: "error",
  button: "Okay",
});	  
	  }
  },
  type: "POST"
});

};

</script>

</div>
                </div>
              </div>


</div>


</div>



</div>