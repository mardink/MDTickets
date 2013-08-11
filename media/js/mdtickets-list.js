jQuery(document).ready(function(){
    var filter_prio =  jQuery('#prio option:selected').val();
    var filter_status =  jQuery('#status option:selected').val();
    var filter_category =  jQuery('#category option:selected').val();
    var filter_assigned =  jQuery('#assigned option:selected').val();

    if (filter_prio != '') {
        jQuery("#prio").css("background-color", "yellow");
    }
    if (filter_status != '') {
        jQuery("#status").css("background-color", "yellow");
    }
    if (filter_category != '') {
        jQuery("#category").css("background-color", "yellow");
    }
    if (filter_assigned != '') {
        jQuery("#assigned").css("background-color", "yellow");
    }

});

