( function($) {
	"use strict";

} )( jQuery );
var yspl_crnt_tab = localStorage.getItem("yspl_usr_fltr_current_tab");
yspl_crnt_tab = ( yspl_crnt_tab  === null ) ? "general-settings" : yspl_crnt_tab;
var yspl_usr_fltr_modal = jQuery("#yspl_wp_usr_fltr_model_options");
var btn = jQuery(`#yspl_wp_usr_fltr_pop_up_btn`);
var span = jQuery(`.yspl_wp_usr_fltr_model_close`);
// When the user clicks on the button, open the modal
jQuery('body').on('click',"#yspl_wp_usr_fltr_pop_up_btn", function () { yspl_usr_fltr_modal.attr("style","display:flex;"); });
jQuery('body').on('click',".yspl_wp_usr_fltr_model_close", function () { yspl_usr_fltr_modal.attr("style","display:none;"); });
// When the user clicks anywhere outside of the modal, close it
jQuery('body').on('click', function (e) {
	if (e.target.className == "yspl_wp_usr_fltr_modal")
		yspl_usr_fltr_modal.attr("style","display:none;");	
});
jQuery('body').on("click",".tablinks", function (e) {
	jQuery(".tablinks").removeClass("set-active");
	jQuery(this).addClass("set-active");
	jQuery(".yspl_wp_usr_fltr-tabcontent").hide();
	jQuery( "#" +jQuery(this).attr("data-id") ).show();
	var crnt_tab_attr = jQuery(this).attr("data-id");
	var splited_ary = crnt_tab_attr.split('_fltr-');
	localStorage.setItem("yspl_usr_fltr_current_tab", splited_ary[1]);
});
jQuery('body').on('click',".remov_date", function () { jQuery(this).parents('.date_wrapper').remove(); });
jQuery('body').on('click',".remov_meta", function () { jQuery(this).parents('tr').remove(); });
jQuery('body').on('click','#yspl_wp_usr_fltr_add_multi_date', function () {
 	const DATE_COPY_CONTENT = jQuery("#yspl_wp_user_fltr_dt_copy_content").html().trim();
 	jQuery("#yspl_wp_user_fltr_dt_append_content").append( DATE_COPY_CONTENT );
});
jQuery('body').on('click','#yspl_wp_usr_fltr_add_meta_query', function () {
	const META_COPY_CONTENT = jQuery("#yspl_wp_user_fltr_meta_copy_content").html().trim();
	jQuery("#advnce_append_content").append( META_COPY_CONTENT );
});
jQuery('body').on('click','#yswp_EXP-csv-BTN', function (e) {
	jQuery(this).attr('type', 'submit');
	jQuery(this).attr('value', '1');
	jQuery(this).click();
});
jQuery('body').on('dblclick','#LETS-make-POST-Form', function (e) {
	var inpt_form = jQuery(this).parents(`form[method]`);
	var frm_method = inpt_form.attr('method');
	if( frm_method === "get" ){
		inpt_form.attr('method','post');
		var msg_ele = document.getElementById("pop-pop");
		msg_ele.innerHTML = 'POST REQUEST ENABLED!';
		msg_ele.className = "show";
	}else{
		inpt_form.attr('method','get');
		var msg_ele = document.getElementById("pop-pop");
		msg_ele.innerHTML = 'GET REQUEST ENABLED!';
		msg_ele.className = "show";
	}
	setTimeout(function(){ msg_ele.className = msg_ele.className.replace("show", ""); }, 3000); 
});
jQuery('body').on("click",".rst_single_dt", function () { jQuery("input[name='one-dt']").val("")});
// last tab should be opened. 
jQuery(`button[data-id='yspl_wp_usr_fltr-${yspl_crnt_tab}']`).click();
