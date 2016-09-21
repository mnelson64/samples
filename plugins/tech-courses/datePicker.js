(function($) {
    $(function() {
 
        // Check to make sure the input box exists
        if( 0 < $('#courseStartDate').length ) {
            $('#courseStartDate,#courseEndDate').datepicker({
					showOn: "button",
					buttonImage: "images/date-button.gif",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					dateFormat: 'M d, yy',
					defaultDate: +0
			});
        } // end if
 
    });
}(jQuery));