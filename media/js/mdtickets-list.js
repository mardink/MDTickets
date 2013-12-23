jQuery(document).ready(function(){
    var filter_prio =  jQuery('#prio option:selected').val();
    var filter_status =  jQuery('#status option:selected').val();
    var filter_category =  jQuery('#category option:selected').val();
    var filter_assigned =  jQuery('#assigned option:selected').val();
    var filter_dateOverview =  jQuery('#dateOverview option:selected').val();
    var filter_requester =  jQuery('#requester option:selected').val();
    var filter_fromdate =  jQuery('#fromdate').val();
    var filter_todate =  jQuery('#todate').val();
    var filter_actie =  jQuery('#actie').val();

    jQuery('.row-finished td .prio').removeClass("label label-success label-warning label-info label-inverse label-important");
    jQuery('.row-finished td .requester').removeClass("label label-success label-warning label-info label-inverse label-important");
    jQuery('.row-finished td .assigned').removeClass("label label-success label-warning label-info label-inverse label-important");

    jQuery('.expand').click(function() {
        if( jQuery(this).hasClass('hidden_detail') )
            jQuery('img', this).attr("src", "media/com_mdtickets/images/plus.png");
        else
            jQuery('img', this).attr("src", "media/com_mdtickets/images/minus.png");
        jQuery(this).toggleClass('hidden_detail');
        jQuery(this).parent().next('tr').toggle();
    });
    jQuery('#expand_all').click(function() {
        if( jQuery(this).hasClass('hidden_detail') ) {
            jQuery('img', this).attr("src", "media/com_mdtickets/images/plus.png");
            jQuery('.detail_row').hide();
            jQuery('.expand').removeClass('hidden_detail');
            jQuery('img', '.expand').attr("src", "media/com_mdtickets/images/plus.png");
        }

        else {
            jQuery('img', this).attr("src", "media/com_mdtickets/images/minus.png");
            jQuery('.detail_row').show();
            jQuery('.expand').addClass('hidden_detail');
            jQuery('img', '.expand').attr("src", "media/com_mdtickets/images/minus.png");
        }
        jQuery(this).toggleClass('hidden_detail');

    });

    jQuery('#checkbox_dateoverview').click(function () {
    if (jQuery(this).is(':checked')) {
        jQuery("#date_overview").show();
    } else {
        jQuery("#date_overview").hide();
        jQuery("#fromdate").val("");
        jQuery("#dateOverview").val("");
        jQuery("#todate").val("");
        jQuery("#adminForm").submit();
        jQuery(this).attr({checked: false});
    }
});
    if (filter_prio != '') {
        jQuery("#prio").css("background-color", "yellow");
    }
    if (filter_actie != '') {
        jQuery("#actie").css("background-color", "yellow");
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
    if (filter_requester != '') {
        jQuery("#requester").css("background-color", "yellow");
    }
    if (filter_dateOverview != '') {
        jQuery("#dateOverview").css("background-color", "yellow");
        jQuery('#checkbox_dateoverview').attr('checked', true);
        jQuery("#date_overview").show();
    }
    if (filter_fromdate != '') {
        jQuery("#fromdate").css("background-color", "yellow");
        jQuery('#checkbox_dateoverview').attr('checked', true);
        jQuery("#date_overview").show();
    }
    if (filter_todate != '') {
        jQuery("#todate").css("background-color", "yellow");
        jQuery('#checkbox_dateoverview').attr('checked', true);
        jQuery("#date_overview").show();
    }


});

