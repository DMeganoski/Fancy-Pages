/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

(function($){
  updatePages = function() {
    $.post('/fancypages/settings/getlayout', {},
		function(data) {
			$('ol.Pages').html(data);
	});
  };
})(jQuery);

(function($){
  submitChild = function(parentID, childID) {
   $.post('/fancypages/settings/linkpages', {"ChildID": childID, "ParentID": parentID},
		function(data) {
			updatePages();
		});
  };
})(jQuery);