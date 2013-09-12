jQuery(document).ready(function(){
    var filter_prio =  jQuery('#prio option:selected').val();
    var filter_status =  jQuery('#status option:selected').val();
    var filter_category =  jQuery('#category option:selected').val();
    var filter_assigned =  jQuery('#assigned option:selected').val();

    jQuery('.expand').click(function() {
        if( jQuery(this).hasClass('hidden_detail') )
            jQuery('img', this).attr("src", "media/com_mdtickets/images/plus.png");
        else
            jQuery('img', this).attr("src", "media/com_mdtickets/images/minus.png");
        jQuery(this).toggleClass('hidden_detail');
        jQuery(this).parent().next('tr').toggle();
    });
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

