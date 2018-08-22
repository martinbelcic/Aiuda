$(document).ready(function(){
	$('.custom-control-check').on('click', function(){
		if($('this').is(':checked'))
			$('#tags').tagsinput('add',$('this').attr('value'));
		else
			$('#tags').tagsinput('remove', $('this').attr('value'));
	});
});