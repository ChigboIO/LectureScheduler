$(document).ready(function(e) {
	
	$('select.department_select').change(function(e) {
        //alert($(this).val());
		$.post($(this).attr('loc'), {dept : $(this).val()}, function(data){
			$('select.lecturer_select').html(data);
		}).fail(function(){alert('failed')});
    });
	
	$('form#create_form').submit(function(e) {
        e.preventDefault();
		if(window.confirm("Are you sure you want to clear the current time table and create a new one?")){
			
			$('.fields').attr('disabled', 'disabled');
			$('#waiting_span').html('<img src="../../images/loading4.gif" width="15px"/> creating time-table...');
			
			$form = $(this);
			values = $form.serialize();
			//alert(values);
			$.post($form.attr('action'), {semester : $form.find('select').val()}, function(data){
				
				$('#waiting_span').html(data);
				
			}).fail(function(){
				$('#waiting_span').html('Ajax post error occured');
			}).always(function(){
				$('.fields').removeAttr('disabled');
			});
		}
    });
	
	$('a.delete_link').click(function(e) {
        if(!window.confirm("Are you sure you want to delete this?")){
			e.preventDefault();
		}
    });
	
	$('div#tabs').tabs({ 
		event : 'click', 
		active   : $.cookie('activetab'),
		activate : function( event, ui ){
			$.cookie( 'activetab', ui.newTab.index(),{
				expires : 10
			});
		} 
	});
	
	$('div#dailyTab').tabs({ 
		event : 'click',
		active : day_of_week-1		
	});
	
	// fix the classes
	$( ".tabs-bottom .ui-tabs-nav, .tabs-bottom .ui-tabs-nav > *" )
		.removeClass( "ui-corner-all ui-corner-top" )
		.addClass( "ui-corner-bottom" );

	// move the nav to the bottom
	$( ".tabs-bottom .ui-tabs-nav" ).appendTo( ".tabs-bottom" );
	
});
