$(document).ready(function() {
	// scrollbar 
	$('#scrollbar').tinyscrollbar();

	// table hsitoric and therapeutic i18n test the attribut lang on html element
	var sInfo = '';
	var sLenghtMenu ='';
	if($('html')[0].lang =='fr') {
		sLenghtMenu ="Afficher _MENU_ résultats par page";
		sInfo = "Résultats _START_ à _END_ sur _TOTAL_ résultats";
		} else {
		sLenghtMenu = "_MENU_ resultaten weergeven";
		sInfo = "_START_ tot _END_ van _TOTAL_ resultaten";
		}
	// settings for table + i18n for labels 
	$('.therapeutics-table').dataTable( {
		"bFilter": false,
		"sDom": '<"top">rt<"bottom"filp><"clear">',
		"sPaginationType": "bootstrap",
		"oLanguage": {
            "sLengthMenu": sLenghtMenu,
            "sZeroRecords": "Nothing found - sorry",
            "sInfo": sInfo,
            "sInfoEmpty": "Showing 0 to 0 of 0 records",
            "sInfoFiltered": "(filtered from _MAX_ total records)"
        }
		
	} );
	$('.therapeutics-table-pro').dataTable( {
		"bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
		"bInfo": false
	} );
	// $('#myModal').modal('toggle');
	$('.table-filter strong').addClass('active');
	$('#table-refinement').on('show', function() {
		$('.table-filter legend').removeClass().addClass('active');
	});
	$('#table-refinement').on('hide', function() {
		$('.table-filter legend').removeClass();
	});
	// datepicker form for refinement 		
	$('#date-input, #thviewform-pro-date-start, #thviewform-pro-date-end').datepicker().on('changeDate', function(){
	$('.datepicker').hide();
	});

	// if advanced or basic checkbox is checked add class strong 
	$('#patient-management form input').click (function() {
		$('#patient-management form label').removeClass('checked');
		$(this).parent('label').addClass('checked');
	});
	
	// tabs consent / therapeutics  expand collapse 
	$('#therapeutics-tabs a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
    })
	// Reset Font Size on top page 
	 var originalFontSize = $('.normal').css('font-size');
	 $(".reset-font").click(function(){
	 $('.normal').css('font-size', originalFontSize);
	 });
	 // Increase Font Size
	 $(".increase-font").click(function(){
	  var currentFontSize = $('.normal').css('font-size');
	 var currentFontSizeNum = parseFloat(currentFontSize, 10);
	   var newFontSize = currentFontSizeNum*1.2;
	 $('.normal').css('font-size', newFontSize);
	 return false;
	 });
	 // Decrease Font Size
	 $(".decrease-font").click(function(){
	  var currentFontSize = $('.normal').css('font-size');
	 var currentFontSizeNum = parseFloat(currentFontSize, 10);
	   var newFontSize = currentFontSizeNum*0.8;
	 $('.normal').css('font-size', newFontSize);
	 return false;
	 });
	 
	 // input deselected for hcpartyform / select patient form 
	 $('#hcpartyform input[type=radio]').click(function() {
		radioId = '';
		radioId = $(this).attr('id'); 
		switch (radioId) {
			case 'hcpartyform:choose:0' :  // eid
			$('#nonlinkeid').hide();
			$('#linkeid').show(); 
			$('#hcpartyform input[type=text]').removeAttr('disabled');
			$('.hcpartyform-eniss, .hcpartyform-sniss').attr("disabled", "disabled");
			break;
			case 'hcpartyform:choose:1' : // ssin and eid 
			$('#nonlinkeid').hide();
			$('#linkeid').show();
			$('#hcpartyform input[type=text]').removeAttr('disabled');
			$('.hcpartyform-eniss').attr("disabled", "disabled");
			break;
			case 'hcpartyform:choose:2' : // ssin and sis
			$('#nonlinkeid').show();
			$('#linkeid').hide();
			$('#hcpartyform input[type=text]').removeAttr('disabled');
			$('.hcpartyform-eid').attr("disabled", "disabled");
			break;
		}
	 });
	// tootltip view therapeutic edit form
	$('a.top-tooltip').tooltip({placement:'top'});
	$('a.left-tooltip').tooltip({placement:'left'});
  // Work around for IE's lack of :focus CSS selector
  if($.browser.msie){
    $('input')
      .focus(function(){$(this).addClass('iefocus');})
      .blur(function(){$(this).removeClass('iefocus');});
  }
	/* remove active for background image filter table */
	$('.table-filter legend, #audit-data-more').click(function(){
	$(this).toggleClass('active');
	});
	
	// modal generic link view
	$("a.modal-link").click(function(event) {
			urlLink = $(this).attr('href');
			titleLink = $(this).attr('title');
            $('<div/>').dialog2({
                title: titleLink, 
                content: urlLink,
				id:"modal-econsent-form",
				showCloseHandle: true,
            	removeOnClose: false, 
				closeOnEscape: false,
				closeOnOverlayClick: false
            });
			$("#modal-econsent-form").dialog2("options", {
                buttons: {
                    "Close": function() {
                        $(this).dialog2("close");
                    }
                }
            });
			
			$(".open-dialog").click(function(event) {
            event.preventDefault();
            $("#sample1-dialog").dialog2("open");
        });

            event.preventDefault();
        });
	// for ie 7 and ie 8 rounded corner 
	if(jQuery.browser.msie && jQuery.browser.version.substring(0, 1) < 9){
	$('.my-account').corner('top');  
	$('#patient-management form, input.btn').corner('3px');  
	}
});

