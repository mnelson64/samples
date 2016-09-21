// JavaScript Document
function toggleStatus (regID) {
	//alert ('Status='+pluginPath.URL);
	currentStatus = jQuery("#status"+regID).text();
	jQuery.post( pluginPath.URL+'/manageRegistrations.php', { toggleStatusID: regID, status: currentStatus}, 
					function() { 
						if (jQuery("#status"+regID).text() == 'Pending') {
							jQuery("#status"+regID).text('Paid');
							jQuery("#regRow"+regID).addClass('background_approved').removeClass('background_pending');
						} else {
							jQuery("#status"+regID).text('Pending');
							jQuery("#regRow"+regID).addClass('background_pending').removeClass('background_approved');
						}
					} 
				); 
}
