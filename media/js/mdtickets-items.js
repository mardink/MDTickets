jQuery(document).ready(function(){
    alert("We hebben jquery");
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
});

