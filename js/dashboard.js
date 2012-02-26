/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
	var infoBox = $('#Panel div.Box h4:contains("Fancy")');
	var loadingBox = $('<div class="Loading"></div>');
	infoBox.parent().addClass('Information');
	$('ol.Pages').html(loadingBox);
	updatePages();
})

