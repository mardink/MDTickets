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
    $( ".status" ).each(function() {
    var status = jQuery("this").text();
    if (status == 'Started') {
        jQuery(this).addClass('status-started');
    } else {
        alert(status);
    }
    });
    $(".assigned").each(function()
    {
        var sval = $(this).text();
        //alert(sval);
        if (sval == "MHI")
        {
            alert(sval);
            $(this).css('backgroundColor', 'red');
        }

    });
    jQuery("#toevoegen").Click(function(){
       alert('Button is clciekd');
    });
    jQuery('#edit-button').click(function() {
        jQuery('#show-detail').hide();
            });
});