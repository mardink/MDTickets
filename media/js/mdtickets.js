jQuery(document).ready(function(){
    // ITONCall veld Bepaal wie de assigned is. Als ITON dan een itoncall vel plaatsen
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
});     // Einde ITONCALL
//Begin click functie
