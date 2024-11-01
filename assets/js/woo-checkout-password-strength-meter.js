jQuery(document).ready(function(){

	jQuery('#pass-strength-result').hide();

	jQuery('input#createaccount').change(function(){
		jQuery('#pass-strength-result').hide();
		if (jQuery(this).is(':checked')) {
			jQuery('#pass-strength-result').slideDown();
		}
	}).change();
	
  if(jQuery("#pass-strength-result").length > 0){
        jQuery("#account_password").bind("keyup", function(){
        var pass1 = jQuery("#account_password").val();
        var pass2 = jQuery("#account_password-2").val();
        var username = jQuery("#account_username").val();
        var strength = passwordStrength(pass1, username, pass2);
        updateStrength(strength);
        });
        jQuery("#account_password-2").bind("keyup", function(){
        var pass1 = jQuery("#account_password").val();
        var pass2 = jQuery("#account_password-2").val();
        var username = jQuery("#account_username").val();
        var strength = passwordStrength(pass1, username, pass2);
        updateStrength(strength);
        });
    }
    
	function updateStrength(strength){
	    var status = new Array('short', 'weak', 'good', 'strong', 'mismatch');
	    var dom = jQuery("#pass-strength-result");
	    switch(strength){
	    case 1:
	      dom.removeClass().addClass(status[0]).text( wcpsm_vars.i18n_too_short );
	      break;
	    case 2:
	      dom.removeClass().addClass(status[1]).text( wcpsm_vars.i18n_weak );
	      break;
	    case 3:
	      dom.removeClass().addClass(status[2]).text( wcpsm_vars.i18n_good );
	      break;
	    case 4:
	     dom.removeClass().addClass(status[3]).text( wcpsm_vars.i18n_strong );
	      break;
	    case 5:
	      dom.removeClass().addClass(status[4]).text( wcpsm_vars.i18n_mismatch );
	      break;
	    default:
	      //alert('something is wrong!');
	    }
	}
    
});


