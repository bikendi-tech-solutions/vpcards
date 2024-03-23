<?php
if(current_user_can("vtupress_admin")){

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
$option_array = json_decode(get_option("vp_options"),true);





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

                

                
                <div class="form-check form-switch card-title d-flex">
<div class="input-group">
<label class="form-check-label float-start input-group-text" for="flexSwitchCheckChecked">Recharge Card Status</label>
<input onchange="changestatus('cards')" value="checked" class="form-check-input cards input-group-text h-100 float-start" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo vp_option_array($option_array,"cardscontrol");?>>
</div>
</div>
<script>
function changestatus(type){
var obj = {}
if(jQuery("input."+type).is(":checked")){
  obj["set_status"] = "checked";
}
else{
  obj["set_status"] = "unchecked";
}
obj["spraycode"] = "<?php echo vp_getoption("spraycode");?>";
obj["set_control"] = type;



  jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vtupress/controls.php'));?>",
  data: obj,
  dataType: "text",
  "cache": false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery(".preloader").hide();
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
	jQuery(".preloader").hide();
        if(data == "100" ){
	location.reload();
	  }
	  else{
		  
	jQuery(".preloader").hide();
	 swal({
  title: "Error",
  text: data,
  icon: "error",
  button: "Okay",
});
	  }
  },
  type: "POST"
});

}

</script>


                  <div class="table-responsive">
<div class="p-4">

<div id="cardseasyaccess">
<div class="alert alert-primary mb-2" role="alert">
<b>ECARDS NOTE:</b>
<br>
<br>
<h5>Determining User Prices</h5>
<p>The <span style="color:blue;"> blue</span> bordered field is where you are to set <b.discount</b. price such as 2 for 2% because you might want to sell #100 for #98 to your users. Set the field to zero if you want your user to buy #100 card for #100 i.e zero discount. Each field is next to a network</p>
<h5>Determining Discount</h5>
<p>The <span style="color:green;"> green </span> bordered field is where you are to set discount . it operates same way as the step above but for different plan</p>
<h5>Adding ECards Pin</h5>
<ol>
<li>Select the Network Such as MTN, GLO e.t.c you wanna add pin for. The Drop-Down is next to [NETWORK] below</li>
<li>In the large textarea next to NETWORK which you\'ve selected is where you have to enter the pin. Enter PIN and SERIAL Number. To do that, kindly enter the pin and serial number in this format <b>12345-6789</b>. Where 12345 is the pin and 6789 is the serial number. for any pin that doesn\'t need serial number, just enter the pin alone</li>
<li>Set DELIMITER: if you are uploading one pin for a network, kindly leave the delimiter as none or enter comma [,] to let the system know you are entering multiple PINS. NOTE: if you enter commer [,] in the delimiter, make sure you separate each pin in the step above with comma [,]. E.g 12345-6789, 5678-9355</li>
<li> Click the Add Pins Button</li>
</ol>

<b>Read more by clicking this link: <a href="https://vtupress.com/doc/setting-up-ecards-recharge-pins/">ECARDS</a></b>
</div>



<div class="neglect border border-secondary">
<!--BEGINNING OF GREY-->
<div style="background-color:grey;">
<label style="color:white;" class="ml-2">ADD NETWORK PIN[s]</label>
<div class="p-2">
<form class="dpins">
<div class="input-group md-3">
<span class="input-group-text">NETWORK</span>
<select class="network form-control" name="network">
<option value="mtn">MTN</option>
<option value="glo">GLO</option>
<option value="9mobile">9MOBILE</option>
<option value="airtel">AIRTEL</option>
</select>
<span class="input-group-text form-control">VALUE</span>
<input type="number" class="value" name="value" placeholder="(e.g 100, 200, 500, 1000)">
</div>

<textarea name="pin" class="pin form-control" placeholder="Enter Pin(s). Separate Pins By Comma sign and enter Comma sign in the delimiter field if you are importing more than one pin"></textarea>
<div class="input-group mb-3">
<span class="input-group-text" title="[use none if you are uploading a single pin or separate each pins by {, or / or ;}]">DELIMITER </span>
<input type="text" class="delimiter" name="delimiter" value="none" placeholder="separate pins by comma \',\'">
<span class="input-group-text">ACTION</span>
<input type="button" name="add_pin" class="add_pin btn btn-success" value="ADD PIN[s]">
</div>


</form>
</div>
</div>
 </div>
<?php
    global $wpdb;
    $table_name = $wpdb->prefix.'vpcards';
    $resultfad = $wpdb->get_results("SELECT * FROM  $table_name WHERE status = 'unused' ORDER BY id DESC");
    $used = $wpdb->get_results("SELECT * FROM  $table_name WHERE status = 'used' ORDER BY id DESC");


    ?>


<div  style='background-color:grey;'>
<label style='color:white;' class='ml-2'>SHOW NETWORK(s)</label>
<div class='p-2'>
<div class='input-group mb-3'>
<span class='input-group-text'>FIND NETWORK</span>
<select class='network thenetwork group-text' name='network'>
<option value='all'>ALL</option>
<option value='mtn'>MTN</option>
<option value='glo'>GLO</option>
<option value='airtel'>AIRTEL</option>
<option value='9mobile'>9MOBILE</option>
</select>
<span class='input-group-text'>STATUS</span>
<select class='nvisibility group-text' name='network'>
<option value='unused'>UNUSED</option>
<option value='used'>USED</option>
</select>
<input type='button' value='SHOW NETWORK' name='submitnetwork' class='btn btn-primary group-text searchnetwork'>
</div>
</div>
</div>



<div  style='background-color:grey;'>
<label style='color:white;' class='ml-2'>ACTION</label>
<div class='p-2'>
<div class='input-group mb-3'>
<span class='input-group-text'>TARGET</span>
<select class='target1 group-text' name='target'>
<option value='checked'>CHECKED</option>
<option value='unchecked'>UNCHECKED</option>
</select>
<span class='input-group-text'>STATUS</span>
<select class='targetstatus1 group-text' name='targetstatus1'>
<option value='used'>USED</option>
<option value='unused'>UNUSED</option>
</select>
<span class='input-group-text'>ACTION</span>
<select class='target-action group-text' name='target-action'>
<option value='delete'>DELETE</option>
</select>
<input type='button' value='RUN' name='runtarget' class='btn btn-primary group-text runtarget'>
</div>
</div>
</div>



<div class='input-group'>
<input class='usedbtn btn btn-primary' type='button' value='USED' name=''> <input class='unusedbtn btn btn-primary' type='button' value='UN USED' name=''>
</div>

	<div class='container dtable d-flex justify-content-start' >
  <table class='table table-striped table-hover table-bordered table-responsive'>
	<thead>
	<tr>
	<th scope='col'><input type='checkbox' class='unused mastercheckbox border-success'> <input type='checkbox' class='used mastercheckbox border-danger'></th>
	<th scope='col'>Id</th>
	<th scope='col'>Network</th>
	<th scope='col'>Pin - Serial No:</th>
	<th scope='col'>Value</th>
	<th scope='col'>Time</th>
	<th scope='col'>Status</th>
	</tr>
	</thead>
	<tbody>
<?php
foreach($resultfad as $pins){
	
	$id = $pins->id;
	$pin = $pins->pin;
	$value = $pins->value;
	$network = $pins->network;
	$time = $pins->the_time;
	$status = $pins->status;	
	echo"
	<tr class='unused $network networkresult all'>
	<th scope='col'><input type='checkbox' class='unusedcheckbox border-success' value='$id'></th>
	<th scope='row'>$id</th>
	<td>$network</td>
	<td>$pin</td>
	<td>$value</td>
	<td>$time</td>
	<td>$status</td>
	</tr>
	";

	
}	

foreach($used as $pins){
	
	$id = $pins->id;
	$pin = $pins->pin;
	$value = $pins->value;
	$network = $pins->network;
	$time = $pins->the_time;
	$status = $pins->status;	
	echo"
	<tr class='used $network networkresult all'>
	<th scope='col'><input type='checkbox' class='usedcheckbox border-danger' value='$id'></th>
	<th scope='row'>$id</th>
	<td>$network</td>
	<td>$pin</td>
	<td>$value</td>
	<td>$time</td>
	<td>$status</td>
	</tr>
	";

	
}
?>
	</tbody>
</table>
</div>


<script>

	
jQuery(document).ready(function(){
jQuery("input[type=checkbox].used").removeProp("checked");
jQuery("input[type=checkbox].unused").removeProp("checked");
});
		 
	jQuery(".used.mastercheckbox").on("change",function(){

	 jQuery("input[type=checkbox].usedcheckbox").prop("checked", jQuery(this).prop("checked"));

	});
	
	jQuery(".unused.mastercheckbox").on("change",function(){

	 jQuery("input[type=checkbox].unusedcheckbox").prop("checked", jQuery(this).prop("checked"));

	});
	
	
	jQuery(".runtarget").on("click",function(){
	jQuery("#cover-spin").show();
	var targetstatus1 = jQuery(".targetstatus1").val();
	var ids = "-";
	var target = jQuery(".target1").val();
	
	var targetaction = jQuery(".target-action").val();
	
	if(target == "checked"){
	jQuery("."+targetstatus1+"checkbox:checked").each(function(){
	ids = ids+"-"+jQuery(this).val();
	});
	
	}
	else{
	jQuery("."+targetstatus1+"checkbox:not(:checked)").each(function(){
	ids = ids+"-"+jQuery(this).val();
	});	
	}
	
	obj = {};
	obj["target"] = target;
	obj["targetstatus"] = targetstatus1;
	obj["targetaction"] = targetaction;
	obj["keys"] = ids;
	
	jQuery.ajax({
  url: "<?php echo esc_url(plugins_url("vpcards/index.php"));?>",
  data: obj,
  dataType: "json",
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
		  swal({
  title: "Successfully Added",
  text: data.message,
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else{
	swal(data.message, {
      icon: "error",
    }); 
	  }
  },
  type: "POST"
});
	
	
	});
	
	
	
	
jQuery(".used").hide();
jQuery(".unusedbtn").on("click",function(){
	jQuery(".used").hide();
	jQuery(".unused").show();
});
jQuery(".usedbtn").on("click",function(){
	jQuery(".unused").hide();
	jQuery(".used").show();
});

jQuery(".searchnetwork").on("click",function(){
	var val = jQuery(".thenetwork").val();
	var vis = jQuery(".nvisibility").val();
	jQuery(".networkresult").hide();
	jQuery(".mastercheckbox").hide();
	jQuery("."+val+"."+vis).show();
	jQuery("."+vis+".mastercheckbox").show();
	
});



jQuery(".savecard").click(function(){

jQuery("#cover-spin").show();
	
var obj = {};
var toatl_input = jQuery(".cardeasy input,.cardeasy select").length;
var run_obj;

for(run_obj = 0; run_obj <= toatl_input; run_obj++){
var current_input = jQuery(".cardeasy input,.cardeasy select").eq(run_obj);


var obj_name = current_input.attr("name");
var obj_value = current_input.val();

if(typeof obj_name !== typeof undefined && obj_name !== false){
obj[obj_name] = obj_value;
}

	
}

	jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vpcards/saveauth.php'));?>",
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
        if(data == "100" ){
	
		  swal({
  title: "SAVED",
  text: "Update Completed",
  icon: "success",
  button: "Okay",
}).then((value) => {
});
	  }
	  else{
		  
	jQuery("#cover-spin").hide();
	swal({
  buttons: {
    cancel: "Why?",
    defeat: "Okay",
  },
  title: "Update Wasn\'t Successful",
  text: "Click \'Why\' To See reason",
  icon: "error",
})
.then((value) => {
  switch (value) {
 
    case "defeat":
      break;
    default:
      swal({
		title: "Details",
		text: data,
      icon: "info",
    });
  }
}); 

  }
  },
  type: "POST"
});

	
});


jQuery(".dpins .add_pin").on("click",function(){
		  jQuery("#cover-spin").show();
var obj = {};
obj["network"] = jQuery(".dpins .network").val();
obj["pin"] = jQuery(".dpins .pin").val();
obj["value"] = jQuery(".dpins .value").val();
obj["add_pin"] = jQuery(".dpins .pin").val();
obj["delimiter"] = jQuery(".dpins .delimiter").val();
jQuery.ajax({
  url: '<?php echo esc_url(plugins_url("vpcards/pins.php"));?>',
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
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
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
		  swal({
  title: "Successfully Added",
  text: data.message,
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
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
              </div>
</div>


</div>



</div>
<?php   
}
    
?>