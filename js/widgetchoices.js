/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
	$('li.WidgetChoice').click(function(e) {
		var subMenu = $(this).find('.WidgetInfo');
		$('.WidgetInfo:visible').not(subMenu).slideToggle('fast');
		$('.WidgetChoice').not(this).removeClass('Expanded');
		subMenu.slideToggle('fast');
		$(this).toggleClass('Expanded');

	});

});
