 $().ready(function() {
        $('.nav > .left > a').mouseover(function() {
            var type = $(this).attr('class');
            $('.nav .right > div').each(function() {
                $(this).hide();
            });
            $("#"+type).show();
        });
        
        $('.nav').hover(function() {
        }, function() {
            $('.nav .right > div').each(function() {
                $(this).hide();
            });
            $("#default").show();
        });
});

jQuery(document).ready(function(){
    
    jQuery('.menu-btn').click(function() {
        var parent = jQuery(this).parent('header');
        if(parent.hasClass('down')) {
            jQuery(parent).find('.mobile-nav').slideUp(0);
            parent.removeClass('down');
        } else {
            jQuery(parent).find('.mobile-nav').slideDown(0);
            parent.addClass('down');
        }
    });
    
    $(".fastening .open").click(function(){
       $(".fastening .text").hide(0);
       $(".fastening .select").show(0);
       $(".fastening").addClass('select-bg');
    });
    $(".fastening .close").click(function(){
       $(".fastening .text").show(0);
       $(".fastening .select").hide(0);
       $(".fastening").removeClass('select-bg');
    });
    
    jQuery('.dropdown-click').click(function() {
        var parent = jQuery(this).parent('.dropdown-select');
        if(parent.hasClass('down')) {
            jQuery(parent).find('ul').slideUp('slow');
            parent.removeClass('down');
        } else {
            jQuery(parent).find('ul').slideDown('slow');
            parent.addClass('down');
        }
    });
    
    
    $.fn.colorbox.settings.bgOpacity = "0.8";
    $.fn.colorbox.settings.transition = "fade";
    //Examples of how to assign the ColorBox event to elements.
     $("a[rel='popup']").colorbox({iframe:true, height:358, width:483, scrolling:false});
    $("a[rel='popup2']").colorbox({iframe:true, height:547, width:392, scrolling:false}); 
    $("a[rel='popupTimeline']").colorbox({iframe:true, height:660, width:767, scrolling:false}); 
    
})