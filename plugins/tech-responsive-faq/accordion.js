jQuery(document).ready(function($) {
	jQuery(".accordion").accordion({autoHeight: false, collapsible: true, active: false}).css("height","auto");
	$(".accordion,.categoryName").show();
})();