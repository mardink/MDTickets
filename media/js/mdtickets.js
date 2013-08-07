jQuery(document).ready(function(){
    jQuery("#show-edit").hide();
    jQuery("#show-update").hide();
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
    jQuery( "#toevoegen" ).click(function() {
        jQuery("#form_edit").hide();
        jQuery("#show-update").show();
    });
    jQuery( "#edit-button" ).click(function() {
        jQuery("#tekst").hide();
        jQuery("#show-edit").show()

    });
});     // Einde ITONCALL
//Begin click functie
