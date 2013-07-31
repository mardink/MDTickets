jQuery(document).ready(function(){
    var assigned = jQuery('#assigned option:selected').val();

    if (assigned == 'ITON') {
        jQuery("#iton").show();
    } else {
        jQuery("#iton").hide();
    }

    jQuery("#assigned").focusout(function(){
        var assigned = jQuery('#assigned option:selected').val();

        if (assigned == 'ITON') {
            jQuery("#iton").show();
        } else {
            jQuery("#iton").hide();
        }
    });
});