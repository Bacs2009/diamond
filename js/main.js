$(document).ready(function() {
	$('#menu a').on('click',function(){
		$(this).parent().toggleClass('hide');
		$('nav').toggleClass('visible');
		$('header, section, footer, #tabs').toggleClass('move');
	});
	$('label').on('click',function(){
		if ($(this).hasClass('checked')) { 
			$(this).children('input').prop('checked',false);
			$(this).removeClass('checked');
		}
		else { 
			$(this).children('input').prop('checked',true);
			$(this).addClass('checked');
		} 
		return false;
	});		
});