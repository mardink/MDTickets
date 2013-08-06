jQuery(document).ready(function(){

    jQuery( "#toevoegen" ).click(function() {
        var tekst = jQuery("#tekst").text();
        var date = new Date();
        var displayDate = (myDate.getMonth()+1) + '/' + (myDate.getDate()) + '/' + myDate.getFullYear();
        jQuery("#tekst").hide();
        jQuery("#show-edit").html('<textarea id="detail" name="detail" cols="60" rows="20" wrap="physical" style="width:100%;height:300px;" >' + displayDate + '<br /><hr>' + tekst + '</textarea>')
    });
    jQuery( "#edit-button" ).click(function() {
        var tekst = jQuery("#tekst").text();
        jQuery("#tekst").hide();
        jQuery("#show-edit").html('<textarea id="detail" name="detail" cols="60" rows="20" wrap="physical" style="width:100%;height:300px;" >' + tekst + '</textarea>')

    });
});
