$().ready(function() {
  $.validator.messages.required = "";
  $.validator.messages.email = ""; 
  $.validator.messages.number = "";
  
  $(".frmValidate").validate();
  $("input[rel^=date]").datepicker();
  
  $(".changeState").live("change", function() {
    var country = $(this).val();
    var thisField = $(this).attr("id");
    var stateField = $(this).attr("rel");
    var state = $("[id='"+stateField+"']").val();

    if (country=="US"||country=="CA"||country=="IE") {      
      $.getJSON("options.php",
        {f: (country=="US"?"us_states":(country=="CA"?"ca_provinces":(country=="IE"?"irish_states":""))) },
        function(j){        
          var options = "";
          for (var i = 0; i < j.length; i++) {
            options += "<option value=\"" + j[i].optionValue + "\"" + (j[i].optionValue==state?" selected=\"selected\"":"")+">" + j[i].optionDisplay + "</option>";
          }          
		  $("[id='"+stateField+"']").html(options);
      });
	  
      $("[id='"+stateField+"']").addClass("required");
      $("[id='span_sel_"+stateField+"']").show();
      $("[id='span_sel_"+stateField+"_other']").hide();      
    } else {	
      $("[id='"+stateField+"']").removeClass("required");
      $("[id='span_sel_"+stateField+"']").hide();
      $("[id='span_sel_"+stateField+"_other']").show();
    }
    //$("#span_"+stateField).html((country=="US"||country=="IE"?"State *":(country=="CA"?"Province *":"State")));
  });

  $('.slide-out-div').show();
  $('.slide-out-div').tabSlideOut({
    tabHandle: '.handle',                     //class of the element that will become your tab
    pathToTabImage: 'images/contact_button_new.png', //path to the image for the tab //Optionally can be set using css
    imageHeight: '890px',                     //height of tab image           //Optionally can be set using css
    imageWidth: '49px',                       //width of tab image            //Optionally can be set using css
    tabLocation: 'left',                      //side of screen where tab lives, top, right, bottom, or left
    speed: 300,                               //speed of animation
    action: 'click',                          //options: 'click' or 'hover', action to trigger animation
    topPos: '144px',                          //position from the top/ use if tabLocation is left or right
    leftPos: '20px',                          //position from left/ use if tabLocation is bottom or top
    fixedPosition: false                      //options: true makes it stick(fixed position) on scroll
  });
  
  $("#openContact").click(function() {
    $(".handle").click();
    return false;
  });
  
  $(".clkBrochureDownload").click(function() {
    var dlid = $(this).attr('rel');
    if ($.cookie("rlreg")!="1") {
      $.colorbox({iframe:false, height:586, width:392, scrolling:false, href:"register.php?id="+dlid});  
    } else {
      filedl(dlid);
    }
  });  
});

function colorbox_close() {
  $.colorbox.close();
}

function filedl(id) {
  $("#inputBrochureDownloadId").val(id);
  $("#inputBrochureDownloadDo").val("Download");
  $("#frmBrochureDownload").submit();
}
