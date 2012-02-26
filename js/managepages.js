/*
 * The JavaScript file for sorting categories in the fancy pages application
 * Not nearly as fancy as Vanilla's nested sortable, but hey.
 */
$(document).ready(function() {

/*----------------------- Create Function for post ---------------------------*/
/*---------------------------- Create Helper ---------------------------------*/
	function individualHelper( event, ui ) {
		var html = ui.draggable.html();
		return "<li>" + html + "</li>";
	}
/*------------------------ Set Function for Drag -----------------------------*/
	$('.Draggable').draggable({
		"containment": "ol.Pages",
		"cursor": "move",
		"opacity": "1.0",
		"revert": "invalid",
		"stack": ".Draggable",
		"helper": "original",
		"beforeStart": function(event, ui) {
			$(this).addClass('Dragging');
		},
		"stop": function(event, ui) {

		}
	});

/*----------------------- Set Function for Drop ------------------------------*/

	$('.Draggable').droppable({
		"over": function(event, ui) {
			$(this).addClass('Hovered');
		},
		"drop": function(event, ui) {
			// get both page id's
			var childID = $(ui.draggable).attr("pageid");
			var parentID = $(this).attr("pageid");
			// do our custom post function
			var loadingBox = $('<div class="Loading"></div>');
			$('ol.Pages').html(loadingBox);
			submitChild(parentID, childID);
		},
		"out": function(event, ui) {
			$(this).removeClass('Hovered');
		}
	});

});

