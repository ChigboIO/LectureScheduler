// JavaScript Document
$('#bank_alert_form, .fm').submit(function(e) {
    e.preventDefault();
	$('.sb').attr('disabled', 'disabled');
	$('.response_div').html('<img src="../images/loading4.gif" width="15px"/> submiting form...');
	
	$form = $(this);
	values = $form.serialize();
	
	$.post($form.attr('action'), values, function(data){
		$('.response_div').html(data.response);
		if(data.status == true)
		{
			$form.find("input[type=text], input[type=number], input[type=date]").val('');
			if($form.attr('name') == 'bank_alert_form')
				$('#new_r').after(data.new_row);
			else if($form.attr('class') == 'fm')
				$form.replaceWith("<img src='../images/good.png' alt='Comfirmed'>");
		}
	}, "json").fail(function(){
		$('.response_div').html('Ajax post error occured');
	}).always(function(){
		$('.sb').removeAttr('disabled');
	});
});


$('#test').click(function(e) {
    alert('Function is connected');
});