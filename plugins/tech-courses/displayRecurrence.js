// JavaScript Document
function displayRecurrence (mode) {
	if (mode == 'none') {
		jQuery("#row_day").css("display","none");
		jQuery(".row_monthly").css("display","none");
	} else if (mode == 'day') {
		jQuery("#row_day").css("display","table-row");
		jQuery(".row_monthly").css("display","none");
	} else if (mode == 'monthly') {
		jQuery("#row_day").css("display","none");
		jQuery(".row_monthly").css("display","table-row");
	} else {
		jQuery("#row_day").css("display","none");
		jQuery(".row_monthly").css("display","none");
	}
}