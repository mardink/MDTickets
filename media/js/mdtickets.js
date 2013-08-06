jQuery(document).ready(function(){
    jQuery("#show-edit").hide()
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
        var tekst = jQuery("#tekst").text();
        var date = new Date();
        jQuery("#detail").text(date + '<br /><hr>' + tekst);
        jQuery("#show-edit").show();
        var detail_tekst = jQuery("#detail").text();
        alert (detail_tekst);
    });
    jQuery( "#edit-button" ).click(function() {
        var tekst = jQuery("#tekst").text();
        jQuery("#tekst").hide();
        jQuery("#show-edit").show()

    });
});     // Einde ITONCALL
//Begin click functie
