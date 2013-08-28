jQuery(document).ready(function(){
    jQuery("#show-edit").hide();
    jQuery("#show-update").hide();
    var item_id = jQuery('#mdtickets_item_id').val();

     if (item_id) {
         jQuery("#btn_save").hide();
     }
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
    });// Einde ITONCALL
    // Completed by, date veld Bepaal wat de status is. Als cancelled of closed dan velden laten zien
    var status = jQuery('#status option:selected').val();
    if (status == 'Closed' || status == 'Cancelled' ) {
        jQuery("#completedate").show();
        jQuery("#completeby").show();

    } else {
        jQuery("#completedate").hide();
        jQuery("#completeby").hide();

    }

    jQuery("#status").focusout(function(){
        var status = jQuery('#status option:selected').val();

        if (status == 'Closed' || status == 'Cancelled') {
            jQuery("#completedate").show();
            jQuery("#completeby").show();

        } else {
            jQuery("#completedate").hide();
            jQuery("#completeby").hide();

        }
    });// Einde


    jQuery( "#toevoegen" ).click(function() {
        jQuery("#form_edit").hide();
        jQuery("#show-update").show();
    });
    jQuery( "#edit-button" ).click(function() {
        jQuery("#tekst").hide();
        jQuery("#show-edit").show();
        jQuery("#btn_save").show();

    });

});

