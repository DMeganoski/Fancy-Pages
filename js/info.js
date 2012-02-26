/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
	$('a.Action').hide();
	$('ul.PanelAboutCategories li').hover(function() {
		$(this).find('a.Action').show();
	}, function() {
		$(this).find('a.Action').hide();
	});
	$('ul.SettingsButtons').hide();
	$('.SettingsButton').click(function() {
		$(this).find('ul').slideToggle('400');
		$(this).toggleClass('Open');
	});
});
