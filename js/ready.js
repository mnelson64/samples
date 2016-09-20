/*
Copyright 2014 Tumbleweed Tiny House Co. All rights reserved.
Created by Martin Adams, October-November 2014.
*/


$(document).ready(function() {

var isLive = true;																		//	Google Analytics has to be turned off in sandbox environment.

/* INSTRUCTIONS:
	I.		LAUNCH VARIABLES
	II.		INITIALIZE (do not modify)
	III.	STARTUP SELECTION
	IV.		MAIN
	V.		SKYLIGHTS
	VI.		USA MAP
	VII.	FINANCING CALCULATOR
	VIII.	SAFETY CHECK
	IX.		MAILCHIMP
	X.		ELEMENT FUNCTIONS (do not modify)
*/



/*** LAUNCH VARIABLES ***/
//	ENTER GROUP # AND NUMBER OF ELEMENTS FOR EACH GROUP:
var elements = new Array(33);		//	*** SET NUMBER OF ARRAYS ***
	elements[0] = new Array(7);		//	MODELS
	elements[1] = new Array(23);	//	FLOOR PLANS
	elements[2] = new Array(32);	//	FLOOR PLAN OPTIONS
	elements[3] = new Array(1);		//	[UNUSED]
	elements[4] = new Array(1);		//	[UNUSED]
	elements[5] = new Array(1);		//	[UNUSED]
	elements[6] = new Array(1);		//	[UNUSED]
	elements[7] = new Array(1);		//	[UNUSED]
	elements[8] = new Array(29);	//	EXTERIOR - SIDING AND TRIM
	elements[9] = new Array(12);	//	EXTERIOR - PORCH
	elements[10] = new Array(5);	//	EXTERIOR - WINDOWS
	elements[11] = new Array(15);	//	EXTERIOR - DOOR(S)
	elements[12] = new Array(17);	//	EXTERIOR - ROOF
	elements[13] = new Array(1);	//	INTERIOR - DOOR
	elements[14] = new Array(9);	//	INTERIOR - FINISH
	elements[15] = new Array(4);	//	INTERIOR - FLOOR
	elements[16] = new Array(3);	//	INTERIOR - LIGHTS
	elements[17] = new Array(3);	//	INTERIOR - STORAGE
	elements[18] = new Array(8);	//	INTERIOR - EXTRAS
	elements[19] = new Array(3);	//	KITCHEN - COUNTERTOPS
	elements[20] = new Array(5);	//	KITCHEN - COOKING
	elements[21] = new Array(2);	//	KITCHEN - REFRIGERATOR
	elements[22] = new Array(19);	//	KITCHEN - STORAGE
	elements[23] = new Array(2);	//	[UNUSED]
	elements[24] = new Array(3);	//	BATH - TOILET
	elements[25] = new Array(8);	//	SLEEPING - UPSTAIRS LOFT
	elements[26] = new Array(7);	//	SLEEPING - DOWNSTAIRS
	elements[27] = new Array(6);	//	UTILITIES - PACKAGES
	elements[28] = new Array(3);	//	UTILITIES - PLUMBING/WASHING
	elements[29] = new Array(1);	//	[UNUSED]
	elements[30] = new Array(2);	//	DELIVERY
	elements[31] = new Array(5);	//	FINANCING
	elements[32] = new Array(8);	//	Form
/*** LAUNCH VARIABLES ***/



/*** INITIALIZE: DO NOT MODIFY ***/
var randomNumber = Math.floor((Math.random() * 100) + 1); // set number between 1 and 2
var beginProcess = false;																//	Set to false so that when user selects first element, variable is set to true
var completeProcess = false;															//	Set to false so that only when user has selected/filled-out all necessary fields variable is set to true
var _gaq = _gaq || [];																	//	Google Analytics
_gaq.push(['_setAccount', 'UA-1771070-1']);
_gaq.push(['_trackPageview']);
(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
if(isLive) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', 'Page loaded');}						//	Google Analytics event: page loaded, but process not necessarily begun.
for (var i=0; i<=elements.length-1; i++) {
	for (var j=0; j<=elements[i].length-1; j++) {
		var x=(i>9)?i:"0"+i; var y=(j>9)?j:"0"+j;										//	Create global variable "elements[groupID][elementID]" to reference input fields by id, e.g. elements[3][9] => ready-ID-03-09
		elements[i][j] = "ready-ID-"+x+"-"+y;											//	Variable references IDs of <input> elements
		if (j==0) {
			if (i==0) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item"}).html("<strong>MODEL</strong>"));}
			else if (i==1) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>FLOOR PLAN</strong>"));}
			else if (i==8) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>EXTERIOR</strong>"));}
			else if (i==13) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>INTERIOR</strong>"));}
			else if (i==19) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>KITCHEN</strong>"));}
			else if (i==23) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>BATH</strong>"));}
			else if (i==25) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>SLEEPING</strong>"));}
			else if (i==27) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>UTILITIES</strong>"));}
			else if (i==30) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>DELIVERY</strong>"));}
			else if (i==32) {$("#ready-orderItems").append($("<div>", {id:"ready-header-"+x, class: "ready-item ready-margin-top-20"}).html("<strong>CONSULTATION</strong>"));}
		}
		$("#ready-orderItems").append($("<div>", {id:"ready-item-"+x+"-"+y, class: "ready-item"}));		//	Create <div id="ready-item-00-00" class="ready-item"></div>, etc.
		$("#ready-orderItems").append($("<div>", {id:"ready-amount-"+x+"-"+y, class: "ready-amount"}));	//	Create <div id="ready-amount-00-00" class="ready-amount"></div>, etc.
	}
}
// MAP
var usaMapState = {"AL":["Alabama","#714434","#8c5541","$2,000"],"AR":["Arkansas","#55728b","#6588a6","$1,000"],"AZ":["Arizona","#55728b","#6588a6","$1,000"],"CA":["California","#714434","#8c5541","$2,000"],"CO":["Colorado","#beb29c","#d7cab1","$500"],"CT":["Connecticut","#bb844d","#d39557","$3,000"],"DC":["Washington D.C.","#bb844d","#d39557","$3,000"],"DE":["Delaware","#bb844d","#d39557","$3,000"],"FL":["Florida","#bb844d","#d39557","$3,000"],"GA":["Georgia","#bb844d","#d39557","$3,000"],"IA":["Iowa","#55728b","#6588a6","$1,000"],"ID":["Idaho","#55728b","#6588a6","$1,000"],"IL":["Illinois","#714434","#8c5541","$2,000"],"IN":["Indiana","#714434","#8c5541","$2,000"],"KS":["Kansas","#55728b","#6588a6","$1,000"],"KY":["Kentucky","#714434","#8c5541","$2,000"],"LA":["Louisiana","#714434","#8c5541","$2,000"],"MA":["Massachusetts","#bb844d","#d39557","$3,000"],"MD":["Maryland","#bb844d","#d39557","$3,000"],"ME":["Maine","#bb844d","#d39557","$3,000"],"MI":["Michigan","#714434","#8c5541","$2,000"],"MN":["Minnesota","#714434","#8c5541","$2,000"],"MO":["Missouri","#55728b","#6588a6","$1,000"],"MS":["Mississippi","#714434","#8c5541","$2,000"],"MT":["Montana","#55728b","#6588a6","$1,000"],"NC":["North Carolina","#bb844d","#d39557","$3,000"],"ND":["North Dakota","#55728b","#6588a6","$1,000"],"NE":["Nebraska","#55728b","#6588a6","$1,000"],"NH":["New Hampshire","#bb844d","#d39557","$3,000"],"NJ":["New Jersey","#bb844d","#d39557","$3,000"],"NM":["New Mexico","#55728b","#6588a6","$1,000"],"NV":["Nevada","#714434","#8c5541","$2,000"],"NY":["New York","#bb844d","#d39557","$3,000"],"OH":["Ohio","#714434","#8c5541","$2,000"],"OK":["Oklahoma","#55728b","#6588a6","$1,000"],"OR":["Oregon","#714434","#8c5541","$2,000"],"PA":["Pennsylvania","#bb844d","#d39557","$3,000"],"RI":["Rhode Island","#bb844d","#d39557","$3,000"],"SC":["South Carolina","#bb844d","#d39557","$3,000"],"SD":["South Dakota","#55728b","#6588a6","$1,000"],"TN":["Tennessee","#714434","#8c5541","$2,000"],"TX":["Texas","#55728b","#6588a6","$1,000"],"UT":["Utah","#55728b","#6588a6","$1,000"],"VT":["Vermont","#bb844d","#d39557","$3,000"],"VA":["Virginia","#bb844d","#d39557","$3,000"],"WA":["Washington","#714434","#8c5541","$2,000"],"WV":["West Virginia","#bb844d","#d39557","$3,000"],"WI":["Wisconsin","#714434","#8c5541","$2,000"],"WY":["Wyoming","#55728b","#6588a6","$1,000"]};
$("#map").usmap({																		//	Customize map
	stateSpecificStyles: {"AL":{fill:usaMapState["AL"][1]},"AR":{fill:usaMapState["AR"][1]},"AZ":{fill:usaMapState["AZ"][1]},"CA":{fill:usaMapState["CA"][1]},"CO":{fill:usaMapState["CO"][1]},"CT":{fill:usaMapState["CT"][1]},"DC":{fill:usaMapState["DC"][1]},"DE":{fill:usaMapState["DE"][1]},"FL":{fill:usaMapState["FL"][1]},"GA":{fill:usaMapState["GA"][1]},"IA":{fill:usaMapState["IA"][1]},"ID":{fill:usaMapState["ID"][1]},"IL":{fill:usaMapState["IL"][1]},"IN":{fill:usaMapState["IN"][1]},"KS":{fill:usaMapState["KS"][1]},"KY":{fill:usaMapState["KY"][1]},"LA":{fill:usaMapState["LA"][1]},"MA":{fill:usaMapState["MA"][1]},"MD":{fill:usaMapState["MD"][1]},"ME":{fill:usaMapState["ME"][1]},"MI":{fill:usaMapState["MI"][1]},"MN":{fill:usaMapState["MN"][1]},"MO":{fill:usaMapState["MO"][1]},"MS":{fill:usaMapState["MS"][1]},"MT":{fill:usaMapState["MT"][1]},"NC":{fill:usaMapState["NC"][1]},"ND":{fill:usaMapState["ND"][1]},"NE":{fill:usaMapState["NE"][1]},"NH":{fill:usaMapState["NH"][1]},"NJ":{fill:usaMapState["NJ"][1]},"NM":{fill:usaMapState["NM"][1]},"NV":{fill:usaMapState["NV"][1]},"NY":{fill:usaMapState["NY"][1]},"OH":{fill:usaMapState["OH"][1]},"OK":{fill:usaMapState["OK"][1]},"OR":{fill:usaMapState["OR"][1]},"PA":{fill:usaMapState["PA"][1]},"RI":{fill:usaMapState["RI"][1]},"SC":{fill:usaMapState["SC"][1]},"SD":{fill:usaMapState["SD"][1]},"TN":{fill:usaMapState["TN"][1]},"TX":{fill:usaMapState["TX"][1]},"UT":{fill:usaMapState["UT"][1]},"VT":{fill:usaMapState["VT"][1]},"VA":{fill:usaMapState["VA"][1]},"WA":{fill:usaMapState["WA"][1]},"WV":{fill:usaMapState["WV"][1]},'WI': {fill: '#714434'},"WY":{fill:"#55728b"}},
	stateSpecificHoverStyles: {"AL":{fill:usaMapState["AL"][2]},"AR":{fill:usaMapState["AR"][2]},"AZ":{fill:usaMapState["AZ"][2]},"CA":{fill:usaMapState["CA"][2]},"CO":{fill:usaMapState["CO"][2]},"CT":{fill:usaMapState["CT"][2]},"DC":{fill:usaMapState["DC"][2]},"DE":{fill:usaMapState["DE"][2]},"FL":{fill:usaMapState["FL"][2]},"GA":{fill:usaMapState["GA"][2]},"IA":{fill:usaMapState["IA"][2]},"ID":{fill:usaMapState["ID"][2]},"IL":{fill:usaMapState["IL"][2]},"IN":{fill:usaMapState["IN"][2]},"KS":{fill:usaMapState["KS"][2]},"KY":{fill:usaMapState["KY"][2]},"LA":{fill:usaMapState["LA"][2]},"MA":{fill:usaMapState["MA"][2]},"MD":{fill:usaMapState["MD"][2]},"ME":{fill:usaMapState["ME"][2]},"MI":{fill:usaMapState["MI"][2]},"MN":{fill:usaMapState["MN"][2]},"MO":{fill:usaMapState["MO"][2]},"MS":{fill:usaMapState["MS"][2]},"MT":{fill:usaMapState["MT"][2]},"NC":{fill:usaMapState["NC"][2]},"ND":{fill:usaMapState["ND"][2]},"NE":{fill:usaMapState["NE"][2]},"NH":{fill:usaMapState["NH"][2]},"NJ":{fill:usaMapState["NJ"][2]},"NM":{fill:usaMapState["NM"][2]},"NV":{fill:usaMapState["NV"][2]},"NY":{fill:usaMapState["NY"][2]},"OH":{fill:usaMapState["OH"][2]},"OK":{fill:usaMapState["OK"][2]},"OR":{fill:usaMapState["OR"][2]},"PA":{fill:usaMapState["PA"][2]},"RI":{fill:usaMapState["RI"][2]},"SC":{fill:usaMapState["SC"][2]},"SD":{fill:usaMapState["SD"][2]},"TN":{fill:usaMapState["TN"][2]},"TX":{fill:usaMapState["TX"][2]},"UT":{fill:usaMapState["UT"][2]},"VT":{fill:usaMapState["VT"][2]},"VA":{fill:usaMapState["VA"][2]},"WA":{fill:usaMapState["WA"][2]},"WV":{fill:usaMapState["WV"][2]},'WI': {fill: '#8c5541'},"WY":{fill:"#6588a6"}},
	stateSpecificLabelBackingStyles: {"CT":{fill:usaMapState["CT"][1]},"DC":{fill:usaMapState["DC"][1]},"DE":{fill:usaMapState["DE"][1]},"MA":{fill:usaMapState["MA"][1]},"MD":{fill:usaMapState["MD"][1]},"NH":{fill:usaMapState["NH"][1]},"NJ":{fill:usaMapState["NJ"][1]},"RI":{fill:usaMapState["RI"][1]},"VT":{fill:"#bb844d"}},
	stateSpecificLabelBackingHoverStyles: {"CT":{fill:usaMapState["CT"][2]},"DC":{fill:usaMapState["DC"][2]},"DE":{fill:usaMapState["DE"][2]},"MA":{fill:usaMapState["MA"][2]},"MD":{fill:usaMapState["MD"][2]},"NH":{fill:usaMapState["NH"][2]},"NJ":{fill:usaMapState["NJ"][2]},"RI":{fill:usaMapState["RI"][2]},"VT":{fill:"#d39557"}}
});
$(".fancybox").fancybox({																//	Lightbox functionality
	helpers: {
		overlay: {locked: false}
	}
});
$(".ready-zoom").elevateZoom({zoomType:"lens", lensShape:"round", lensSize:350, borderSize:1});		//	Enable lens zoom
$(".sidebar").draggable();																//	Running total
$(".sidebar-financing").draggable();													//	Financing
debiki.Utterscroll.enable({scrollstoppers: '.sidebar, .sidebar-financing, .ready-slider' });		//	Enable utterscroll (scrolling by pressing mouse on page)
//	FINANCING CALCULATOR
$("#slider").slider({
	value:6,
	min: 4,
	max: 12,
	step: 0.25,
	slide: function(event, ui) {
		$("#"+elements[31][3]).val(ui.value + "%");
		financingCalculator();
	}
});
$("#"+elements[31][3]).val($("#slider").slider("value") + "%");
$(".ready-slider").bind("click change", function(e) {financingCalculator()});
if (navigator.userAgent.match(/iPad/i)) {
	var viewportmeta = document.querySelector('meta[name="viewport"]');
	if (viewportmeta) {
		window.onorientationchange = function detectOrientation() {
			if (orientation == 0) {/* Portrait Mode Home Button bottom */ viewportmeta.content = 'user-scalable=yes, width=1400, initial-scale=0.65';}
			else if (orientation == 90) {/* Landscape Mode, Home Button right */ viewportmeta.content = 'user-scalable=yes, width=1100, initial-scale=0.7';}
			else if (orientation == -90) {/* Landscape Mode, Home Button left */ viewportmeta.content = 'user-scalable=yes, width=1100, initial-scale=0.7';}
			else if (orientation == 180) {/* Portrait Mode, Home Button top */ viewportmeta.content = 'user-scalable=yes, width=1400, initial-scale=0.65';}
		}
	}
}
/*** INITIALIZE: DO NOT MODIFY ***/



/*** STARTUP SELECTION ***/
checkElement(8, 0);																		//	Exterior - Siding:		Cedar Lapboard (standard)
checkElement(8, 2);																		//	Exterior - Siding:		Clear Sealed (standard)
disableGroup(8, 5, 8);																	//	Exterior - Siding:		Disable stain options
disableGroup(8, 9, 28);																	//	Exterior - Siding:		Disable paint options
checkElement(9, 2);																		//	Exterior - Porch:		Standard Post(s)
hideElement(12, 6);																		//	Exterior - Roof:		Show short skylight floor plan
checkElement(14, 0);																	//	Interior:				Untreated Interior (standard)
checkElement(15, 0);																	//	Interior - Floor:		Natural Cork (standard)
checkElement(16, 0);																	//	Interior - Lighting:	Chandelier (standard)
checkElement(19, 0);																	//	Kitchen - Countertops:	Butcher Block Countertops (standard)
checkElement(20, 0);																	//	Kitchen - Cooking:		Induction Burner Cooktop
disableElement(20, 4);																	//	Kitchen - Cooking:		Disable Propane Range Hood
checkElement(21, 0);																	//	Kitchen - Refrigerator:	Undercounter Refrigerator (standard)
checkElement(22, 2);																	//	Kitchen - Storage:		Upper Shelving (standard)
checkElement(24, 0);																	//	Bathroom - Toilet:		RV Toilet (standard)
checkElement(25, 5);																	//	Sleeping - Loft:		Library Ladder (standard)
checkElement(27, 0);																	//	Utilities:				All electric option
checkElement(31, 1);																	//	Financing:				Add 10% down as default
main();																			//	Initialize: disables/removes elements that need to be disabled/removed
/*** STARTUP SELECTION ***/



/*** MAIN ***/

/*	USE THE FOLLOWING COMMANDS FOR CUSTOMIZING THE CHECKOUT PROCESS:
	*********************************************************************************************************************************************************************************************************


	---	GROUP FUNCTIONS
	radioGroupReq		(groupID, elementID, elementStart, elementEnd);			Groups checkboxes together to simulate radio checkboxes. Will not allow user to deselect.
	radioGroupOpt		(groupID, elementID, elementStart, elementEnd);			Groups checkboxes together to simulate radio checkboxes. Allows user to deselect.


	---	HOUSE FUNCTIONS
	houseType			(elementID);										Returns house type (optional: use elementID of group 0). For example: "Cypress"
	houseSize			(elementID);										Returns house size (optional: use elementID of group 0). For example: 18
	houseTypeSize		(elementID);										Returns house type and size (optional: use elementID of group 0). For example: "Cypress-18"
	getHouseTypeByFloorPlan (floorPlan);									Returns house type by floor plan #. For example: floor plan #11 returns "Elm" (floor plan #11 is Elm 18' Equator).
	getHouseSizeByFloorPlan (floorPlan);									Returns house size by floor plan #. For example: floor plan #11 returns 18 (floor plan #11 is Elm 18' Equator).
	getFloorPlan		(floorPlan);										Returns floor plan name by floor plan #. For example: floor plan #11 returns "Equator" (floor plan #11 is Elm 18' Equator).
	getFloorPlanOption	(floorPlan);										Returns which options to bring up by floor plan.
	hasDownstairsBedroom();													Returns true if house has downstairs bedroom (currently only for "Equator", "Horizon", and "Vantage" models)


	---	SIDEBAR FUNCTIONS
	numberWithCommas	(number);											Displays thousands comma, e.g. 1,000
	calculateTotal		();													Returns sidebar total.
	addItem				(groupID, elementID);								Adds item to running total.
	addItemCustom		(groupID, elementID, name, amount);					Adds item to running total and manually assign it an item name and amount.
	removeItem			(groupID, elementID);								Removes item from running total.
	removeItemGroup		(groupID, elementStart, elementEnd);				Removes all items in a group.
	removeItemName		(elementName);										Adds item to running total by element name.


	---	SEARCH FUNCTIONS
	findElement			(groupID, elementStart, elementEnd);				Finds the selected elementID of a selected group. EXCEPTION: returns double-digit element, e.g. "03"
	findElementName		(groupID, elementID);								Finds the name of a selected element.


	---	QUERY FUNCTIONS
	isChecked			(groupID, elementID);								Determines if checkbox is checked.
	isCheckedActive		(groupID, elementID, x, y);							Returns TRUE if a certain element[x][y] has been actively selected. Function used to save time and prevent unnecessary loops.
	isCheckedActiveOne	(groupID, elementID, x, elementStart, elementEnd);	Returns TRUE if a certain element in group = x and in range of certain elements has been actively selected.
	isUnCheckedActive	(groupID, elementID, x, y);							Returns TRUE if a certain element[x][y] has been actively deselected. Function used to save time and prevent unnecessary loops.
	isUnCheckedActiveOne(groupID, elementID, x, elementStart, elementEnd);	Returns TRUE if a certain element in group = x and in range of certain elements has been actively deselected.
	isCheckedAny		(groupID, elementStart, elementEnd);				Returns TRUE if at least one checkbox in a group of elements is checked.
	isCheckedOne		(groupID, elementID, elementStart, elementEnd);		Returns TRUE if element selected is in range of certain elements.
	isEnabled			(groupID, elementID);								Determines if element is enabled.
	isVisible			(elementName);										CURRENTLY NOT IN USE | Checks to see if an element is visible.


	---	ACTION FUNCTIONS
	checkElement		(groupID, elementID);								Also enables the element and adds it to running total.
	checkGroup			(groupID, elementStart, elementEnd);				Checks all elements in a group. Elements must not be in a radio group!
	unCheckElement		(groupID, elementID);								Deselects element and removes it from running total.
	unCheckGroup		(groupID, elementStart, elementEnd);				Deselects any elements in a group.
	enableElement		(groupID, elementID);								Allows user to check an element.
	enableGroup			(groupID, elementStart, elementEnd);				Allows user to check an element in a group.
	disableElement		(groupID, elementID);								Prevents user from being able to check an element.
	disableGroup		(groupID, elementStart, elementEnd);				Prevents user from being able to check an element in a group.
	showElement			(groupID, elementID);								Also enables element. Surrounding div requires "-container", for example: <div id="ready-ID-07-00-container">element(s) to be hidden</div>
	hideElement			(groupID, elementID);								Also unchecks element. Surrounding div requires "-container", for example: <div id="ready-ID-07-00-container">element(s) to be hidden</div>
	showGroup			(groupID, elementStart, elementEnd);				Shows all elements in a group.
	hideGroup			(groupID, elementStart, elementEnd);				Hides all elements in a group.


	--- Other functions
	addToMailChimp		(groupID, elementStart, elementEnd, mcGroup);		Finds which element is checked and adds it to MailChimp group
	createDialog		(alert text, "confirm", yes-function, no-function);	Alert with "Yes" and "No" button.
	createDialog		(alert text, "alert", function);					Alert with "OK" button.
	*********************************************************************************************************************************************************************************************************
*/

function main (groupID, elementID) {
  
	console.log('Execute Main');
	//	RADIO CHECKBOXES: ALLOW ONLY ONE CHECKBOX PER GROUP
	if (groupID == 0) {radioGroupReq(groupID, elementID, 0, 6);}						//	All models
	if (groupID == 1) {
		radioGroupReq(groupID, elementID, 0, 1);										//	Cypress 18'
		radioGroupReq(groupID, elementID, 2, 5);										//	Cypress 20'
		radioGroupReq(groupID, elementID, 6, 10);										//	Cypress 24'
		radioGroupReq(groupID, elementID, 11, 12);										//	Elm 18'
		radioGroupReq(groupID, elementID, 13, 15);										//	Elm 20'
		radioGroupReq(groupID, elementID, 16, 19);										//	Elm 24'
		radioGroupReq(groupID, elementID, 20, 22);										//	Linden 20'
	}
	if (groupID == 2) {
		radioGroupReq(groupID, elementID, 0, 0);										//	Equator-A
		radioGroupOpt(groupID, elementID, 1, 2);										//	Equator-A-B
		radioGroupOpt(groupID, elementID, 3, 4);										//	Equator-A-C
		radioGroupOpt(groupID, elementID, 5, 7);										//	Equator-A-B-C
		radioGroupReq(groupID, elementID, 8, 8);										//	Horizon-A-X
		radioGroupReq(groupID, elementID, 9, 9);										//	Horizon-A-X
		radioGroupOpt(groupID, elementID, 10, 11);										//	Horizon-A-B-X-Y
		radioGroupOpt(groupID, elementID, 12, 13);										//	Horizon-A-B-X-Y
		radioGroupOpt(groupID, elementID, 14, 16);										//	Horizon-A-B-C-X
		radioGroupReq(groupID, elementID, 17, 17);										//	Horizon-A-B-C-X
		radioGroupOpt(groupID, elementID, 18, 20);										//	Horizon-A-B-C-X-Y
		radioGroupOpt(groupID, elementID, 21, 22);										//	Horizon-A-B-C-X-Y
		radioGroupOpt(groupID, elementID, 23, 24);										//	Overlook-A-B
		radioGroupOpt(groupID, elementID, 25, 26);										//	Vantage-A-B-X
		radioGroupReq(groupID, elementID, 27, 27);										//	Vantage-A-B-X
		radioGroupOpt(groupID, elementID, 28, 29);										//	Vantage-A-B-X-Y
		radioGroupOpt(groupID, elementID, 30, 31);										//	Vantage-A-B-X-Y
	}
	if (groupID == 8) {
		radioGroupReq(groupID, elementID, 0, 1);										//	Exterior - siding and trim: board type
		radioGroupReq(groupID, elementID, 2, 4);										//	Exterior - siding and trim: seal type
		radioGroupReq(groupID, elementID, 5, 8);										//	Exterior - siding and trim: stain options
		radioGroupReq(groupID, elementID, 9, 18);										//	Exterior - siding and trim: paint options
		radioGroupReq(groupID, elementID, 19, 28);										//	Exterior - siding and trim: trim options
	}
	if (groupID == 9) {
		radioGroupReq(groupID, elementID, 2, 3);										//	Exterior - porch: standard or square post
		radioGroupReq(groupID, elementID, 4, 9);										//	Exterior - porch: post and railing orientation
	}
	if (groupID == 10) {
		radioGroupReq(groupID, elementID, 0, 4);										//	Exterior - windows: paint colors
		// radioGroupOpt(groupID, elementID, 5, 7);										//	Exterior - windows: shutters
	}
	if (groupID == 11) {
		radioGroupReq(groupID, elementID, 0, 9);										//	Exterior - door: paint color
		radioGroupReq(groupID, elementID, 11, 12);										//	Exterior - door: side door location
	}
	if (groupID == 12) {radioGroupReq(groupID, elementID, 0, 3);}						//	Exterior - roof: color
	if (groupID == 14) {
		radioGroupReq(groupID, elementID, 0, 2);										//	Interior - finishing: type
		radioGroupReq(groupID, elementID, 3, 8);										//	Interior - finishing: stain options
	}
	if (groupID == 15) {radioGroupReq(groupID, elementID, 0, 3);}						//	Interior - floor: type
	if (groupID == 16) {radioGroupReq(groupID, elementID, 0, 1);}						//	Interior - lights: type / fan
	if (groupID == 19) {radioGroupReq(groupID, elementID, 0, 1);}						//	Kitchen - countertop: type
	if (groupID == 20) {radioGroupReq(groupID, elementID, 0, 3);}						//	Kitchen - cooking: type
	if (groupID == 21) {radioGroupReq(groupID, elementID, 0, 1);}						//	Kitchen - refrigerator
	if (groupID == 22) {
		radioGroupOpt(groupID, elementID, 0, 1);										//	Kitchen - toe kick drawers
		radioGroupReq(groupID, elementID, 2, 3);										//	Kitchen - upper shelving / cabinet
		radioGroupReq(groupID, elementID, 4, 17);										//	Kitchen - storage stain and paint options
	}
	if (groupID == 24) {radioGroupReq(groupID, elementID, 0, 1);}						//	Bathroom - toilet
	if (groupID == 25) {radioGroupReq(groupID, elementID, 5, 7);}						//	Sleeping - library ladder, stairs or storage stairs
	if (groupID == 26) {radioGroupOpt(groupID, elementID, 4, 5);}						//	Sleeping - downstairs bedroom or office
	if (groupID == 27) {radioGroupReq(groupID, elementID, 0, 2);}						//	Utilities - one package
	if (groupID == 28) {radioGroupOpt(groupID, elementID, 1, 2);}						//	Utilities - washer/dryer
	if (groupID == 31) {radioGroupReq(groupID, elementID, 0, 2);}						//	Financing - downpayment
	if (groupID == 32) {																//	Form
		radioGroupReq(groupID, elementID, 0, 3);
		radioGroupReq(groupID, elementID, 4, 5);
		radioGroupReq(groupID, elementID, 6, 7);
	}

	//	GOOGLE ANALYTICS
	if(isLive) {
		var count = 0;
		if (isCheckedActive(groupID, elementID, 0, 0)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '1. Models: Cypress 18'); count++;}
		if (isCheckedActive(groupID, elementID, 0, 1)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '1. Models: Cypress 20'); count++;}
		if (isCheckedActive(groupID, elementID, 0, 2)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '1. Models: Cypress 24'); count++;}
		if (isCheckedActive(groupID, elementID, 0, 3)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '1. Models: Elm 18'); count++;}
		if (isCheckedActive(groupID, elementID, 0, 4)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '1. Models: Elm 20'); count++;}
		if (isCheckedActive(groupID, elementID, 0, 5)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '1. Models: Elm 24'); count++;}
		if (isCheckedActive(groupID, elementID, 0, 6)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '1. Models: Linden 20'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '1. Models'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 1, 0, 1)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '2. Floor Plans: Cypress 18'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 1, 2, 5)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '2. Floor Plans: Cypress 20'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 1, 6, 10)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '2. Floor Plans: Cypress 24'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 1, 11, 12)) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '2. Floor Plans: Elm 18'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 1, 13, 15)) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '2. Floor Plans: Elm 20'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 1, 16, 19)) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '2. Floor Plans: Elm 24'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 1, 20, 22)) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '2. Floor Plans: Linden 20'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '2. Floor Plans'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 8, 0, 1)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '3. Exterior - Siding and Trim: Board Type'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 8, 2, 4)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '3. Exterior - Siding and Trim: Board Seal/Stain/Paint'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 8, 5, 8)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '3. Exterior - Siding and Trim: Stain Options'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 8, 9, 18)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '3. Exterior - Siding and Trim: Paint Options'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 8, 19, 28)) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '3. Exterior - Siding and Trim: Trim Options'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '3. Exterior - Siding and Trim'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 9, 2, 3)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '4. Exterior - Porch: Post Type'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 9, 4, 9)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '4. Exterior - Porch: Porch Orientation'); count++;}
		if (isCheckedActive(groupID, elementID, 9, 10)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '4. Exterior - Porch: Front Steps'); count++;}
		if (isCheckedActive(groupID, elementID, 9, 11)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '4. Exterior - Porch: Vestibule'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '4. Exterior - Porch'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 10, 0, 4)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '5. Exterior - Windows: Window Color'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '5. Exterior - Windows'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 11, 0, 9)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '6. Exterior - Door(s): Door Color'); count++;}
		if (isCheckedActive(groupID, elementID, 11, 10)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '6. Exterior - Door(s): Side Door'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 11, 13, 14)){ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '6. Exterior - Door(s): Screen Door'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '6. Exterior - Door(s)'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 12, 0, 3)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '7. Exterior - Roof: Roof Color'); count++;}
		if (isCheckedActive(groupID, elementID, 12, 4)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '7. Exterior - Roof: Dormers'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '7. Exterior - Roof'); count=0;}
		if (isCheckedActive(groupID, elementID, 13, 0)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '8. Interior - Boards and Doors: Sliding Door'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '8. Interior - Boards and Doors'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 14, 0, 2)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '9. Interior - Finishing: Type'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 14, 3, 8)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '9. Interior - Finishing: Stain Color'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '9. Interior - Finishing'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 15, 0, 3)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '10. Interior - Flooring: Type'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '10. Interior - Flooring'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 16, 0, 1)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '11. Interior - Lighting: Type'); count++;}
		if (isCheckedActive(groupID, elementID, 16, 2)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '11. Interior - Lighting: Other'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '11. Interior - Lighting'); count=0;}
		if (isCheckedActive(groupID, elementID, 17, 0)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '12. Interior - Storage: Railing'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 17, 1, 2)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '12. Interior - Storage: Book Case'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '12. Interior - Storage'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 18, 0, 3)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '13. Interior - Extras: Data/TV Outlet'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 18, 4, 7)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '13. Interior - Extras: USB/Outlet Combo'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '13. Interior - Extras'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 19, 0, 1)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '14. Kitchen - Countertops: Type'); count++;}
		if (isCheckedActive(groupID, elementID, 19, 2)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '14. Kitchen - Countertops: Drop Leaf'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '14. Kitchen - Countertops'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 20, 0, 1)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '15. Kitchen - Cooking: Cooktop'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 20, 2, 3)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '15. Kitchen - Cooking: Range + Oven'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '15. Kitchen - Cooking'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 21, 0, 1)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '16. Kitchen - Refrigerator: Type'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '16. Kitchen - Refrigerator'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 22, 0, 1)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '17. Kitchen - Storage: Toe Kick'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 22, 2, 3)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '17. Kitchen - Storage: Shelving / Cabinet'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 22, 4, 7)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '17. Kitchen - Storage: Stain Options'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 22, 8, 17)) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '17. Kitchen - Storage: Paint Options'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '17. Kitchen - Storage'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 24, 0, 1)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '18. Bathroom - Toilet: Type'); count++;}
		if (isCheckedActive(groupID, elementID, 24, 2)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '18. Bathroom - Toilet: Medicine Cabinet'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '18. Bathroom - Toilet'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 25, 3, 4)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '19. Sleeping - Upstairs Loft: Storage'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 25, 5, 7)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '19. Sleeping - Upstairs Loft: Stairs'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '19. Sleeping - Upstairs Loft'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 26, 4, 5)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '20. Sleeping - Downstairs: Room Type'); count++;}
		if (isCheckedActive(groupID, elementID, 26, 6)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '20. Sleeping - Downstairs: Desk/Daybed'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '20. Sleeping - Downstairs'); count=0;}
		if (isCheckedActiveOne(groupID, elementID, 27, 0, 2)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '21. Utilities - Packages: Type'); count++;}
		if (isCheckedActive(groupID, elementID, 27, 3)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '21. Utilities - Packages: Electric Heater'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 27, 4, 5)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '21. Utilities - Packages: Mini-Split A/C '); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '21. Utilities - Packages'); count=0;}
		if (isCheckedActive(groupID, elementID, 28, 0)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '22. Utilities - Plumbing: Water Tank'); count++;}
		if (isCheckedActiveOne(groupID, elementID, 28, 1, 2)) {	ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '22. Utilities - Plumbing: Washer/Dryer'); count++;}
		if (count>0) {											ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '22. Utilities - Plumbing'); count=0;}
        if (isCheckedActive(groupID, elementID, 30, 0)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '23. Delivery: Pickup');}
      	if (isCheckedActive(groupID, elementID, 32, 0)) {		
          console.log('Timeline 0-6');
          ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '24. Timeline: 0-6');}
      if (isCheckedActive(groupID, elementID, 32, 1)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '24. Timeline: 7-12');}
      if (isCheckedActive(groupID, elementID, 32, 2)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '24. Timeline: 1+');}
      if (isCheckedActive(groupID, elementID, 32, 3)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '24. Timeline: Not Sure');}
      if (isCheckedActive(groupID, elementID, 32, 4)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '24. Location: Yes');}
      if (isCheckedActive(groupID, elementID, 32, 5)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '24. Location: No');}
      if (isCheckedActive(groupID, elementID, 32, 6)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '24. Financing: Yes');}
      if (isCheckedActive(groupID, elementID, 32, 7)) {		ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '24. Financing: No');}
	}


	//	STEP #1: MODEL
	if (groupID == 0) {

		// Floor Plans
		for (var i=0; i<=elements[0].length-1; i++) {
			var floorPlan = houseType(i) + "-" + houseSize(i);
			if (isChecked(0, i)) {
				document.getElementById(floorPlan).style.display = "block";
				$("#FloorPlanNotice").hide();
			}
			else {document.getElementById(floorPlan).style.display = "none";}
		}
		if ((houseType() == "Cypress") && (houseSize() == 18)) {unCheckGroup(1, 2, 22);}	//	Make sure all other floor plans are not checked
		if ((houseType() == "Cypress") && (houseSize() == 20)) {unCheckGroup(1, 0, 1); unCheckGroup(1, 6, 22);}
		if ((houseType() == "Cypress") && (houseSize() == 24)) {unCheckGroup(1, 0, 5); unCheckGroup(1, 11, 22);}
		if ((houseType() == "Elm") && (houseSize() == 18)) {unCheckGroup(1, 0, 10); unCheckGroup(1, 13, 22);}
		if ((houseType() == "Elm") && (houseSize() == 20)) {unCheckGroup(1, 0, 12); unCheckGroup(1, 16, 22);}
		if ((houseType() == "Elm") && (houseSize() == 24)) {unCheckGroup(1, 0, 15); unCheckGroup(1, 20, 22);}
		if ((houseType() == "Linden") && (houseSize() == 20)) {unCheckGroup(1, 0, 19);}

		//	Floor Plan Options
		for (var i=0; i<=elements[1].length-1; i++) {
			var floorPlanOption = getHouseTypeByFloorPlan(i) + "-" + getHouseSizeByFloorPlan(i) + "-" + getFloorPlan(i);
			document.getElementById(floorPlanOption).style.display = "none";
		}

		//	Reset floor plan options
		document.getElementById("Equator-A").style.display = "none";
		document.getElementById("Equator-A-B").style.display = "none";
		document.getElementById("Equator-A-C").style.display = "none";
		document.getElementById("Equator-A-B-C").style.display = "none";
		document.getElementById("Horizon-A-X").style.display = "none";
		document.getElementById("Horizon-A-B-X-Y").style.display = "none";
		document.getElementById("Horizon-A-B-C-X").style.display = "none";
		document.getElementById("Horizon-A-B-C-X-Y").style.display = "none";
		document.getElementById("Overlook-A-B").style.display = "none";
		document.getElementById("Vantage-A-B-X").style.display = "none";
		document.getElementById("Vantage-A-B-X-Y").style.display = "none";
		for (var j=0; j<=elements[2].length-1; j++) {if (isChecked(2, j)) {unCheckElement(2, j);}}

		//	Porch
		if (houseType() == "Cypress") {													//	Enable corner porch for Cypress model and show corner porch floor plans, show vestibule
			hideElement(9, 0); showElement(9, 1); showGroup(9, 4, 9); checkElement(9, 7); showElement(9, 11);
		}
		if (houseType() == "Elm" || houseType() == "Linden") {
			showElement(9, 0); hideElement(9, 1); hideGroup(9, 4, 9); hideElement(9, 11);	//	Enable full porch for Elm and Linden model and hide corner porch floor plans, hide vestibule
		}

		//	Dormers
		if (houseType() == "Elm" || houseType() == "Cypress") {showElement("ready-ID-12-04-container");}	//	Show dormers option
		else {hideElement("ready-ID-12-04-container"); unCheckElement(12, 4);}								//	Hide dormers option
		if ((houseSize() == 18) || (houseSize() == 20)) {showElement(12, 5); hideElement(12, 6);}			//	Show short skylight floor plan
		else {hideElement(12, 5); showElement(12, 6);}														//	Show long skylight floor plan
		hideGroup(12, 8, 17);															//	Remove skylights in case house size has switched
		removeItemGroup(12, 8, 17);														//	Remove skylights from sidebar in case house size has switched

		//	Sleeping
		if ((houseType() == "Cypress") || (houseType() == "Elm")) {enableElement(25, 3);}	//	Enable Triangle loft storage only for Cypress or Elm
		else {disableElement(25, 3);}
		if (houseType() == "Cypress") {enableElement(26, 6);}							//	Desk/daybed only available in Cypress
		if (houseType() == "Elm" || houseType() == "Linden") {disableElement(26, 6);}
	}

	//	STEP #2: FLOOR PLANS
	if (groupID == 1) {
		for (var i=0; i<=elements[1].length-1; i++) {
			var floorPlanOption = getHouseTypeByFloorPlan(i) + "-" + getHouseSizeByFloorPlan(i) + "-" + getFloorPlan(i);
			if ((elementID == i) && isChecked(1, i)) {
				document.getElementById(floorPlanOption).style.display = "block";
				$("#FloorPlanOptionsNotice").hide();
				document.getElementById("Equator-A").style.display = "none";
				document.getElementById("Equator-A-B").style.display = "none";
				document.getElementById("Equator-A-C").style.display = "none";
				document.getElementById("Equator-A-B-C").style.display = "none";
				document.getElementById("Horizon-A-X").style.display = "none";
				document.getElementById("Horizon-A-B-X-Y").style.display = "none";
				document.getElementById("Horizon-A-B-C-X").style.display = "none";
				document.getElementById("Horizon-A-B-C-X-Y").style.display = "none";
				document.getElementById("Overlook-A-B").style.display = "none";
				document.getElementById("Vantage-A-B-X").style.display = "none";
				document.getElementById("Vantage-A-B-X-Y").style.display = "none";
				document.getElementById(getFloorPlanOption()).style.display = "block";
				//	Reset floor plan options when new floor plan is selected
				for (var j=0; j<=elements[2].length-1; j++) {if (isChecked(2, j)) {unCheckElement(2, j);}}
				//	Certain floor plans have only one option
				if (getFloorPlanOption() == "Equator-A") {checkElement(2, 0);}
				if (getFloorPlanOption() == "Horizon-A-X") {checkElement(2, 8); checkElement(2, 9);}
				if (getFloorPlanOption() == "Horizon-A-B-C-X") {checkElement(2, 17);}
				if (getFloorPlanOption() == "Vantage-A-B-X") {checkElement(2, 27);}

			}
			else {
				document.getElementById(floorPlanOption).style.display = "none";
			}
		}
	}

	//	STEP #3: EXTERIOR - SIDING AND TRIM
	if (groupID == 8) {
		if (isCheckedAny(8, 0, 1)) {enableGroup(8, 2, 4);}									//	Stained, Stained & Sealed, and Painted options
		else {disableGroup(8, 2, 4);}
		if (isChecked(8, 3)) {enableGroup(8, 5, 8);}										//	Stained & Sealed options
		else {disableGroup(8, 5, 8);}
		if (isChecked(8, 4)) {enableGroup(8, 9, 28);}										//	Painted options
		else {disableGroup(8, 9, 28);}
	}

	//	STEP #4: EXTERIOR - PORCH
	if (!isCheckedAny(0, 0, 6) || !isCheckedAny(9, 2, 3)) {disableGroup(9, 4, 9);}		//	If no house or porch post has been selected, disable corner porch floor plans
	else {enableGroup(9, 4, 9);}														//	If no house or porch post has been selected, disable corner porch floor plans
	if (!isCheckedAny(0, 0, 6)) {disableElement(9, 11);}								//	If no house has been selected, disable vestibule
	else {enableElement(9, 11);}

	//	STEP #5: EXTERIOR - WINDOWS
	/*
	var alert = "";
	if ((houseSize() == 18) || (houseSize() == 20)) {								//	Maximum shutter pairs
		$("#ready-maxwindows").html("5");
		if ($("#"+elements[10][8]).val() > 5) {
			alert += "<p>You can have a maximum of 5 shutter pairs with the <strong>"+houseType()+" "+houseSize()+"’</strong> model.</p>";
			$("#"+elements[10][8]).val(5)
		}
	}
	if (houseSize() == 24) {
		$("#ready-maxwindows").html("7");
		if ($("#"+elements[10][8]).val() > 7) {
			alert += "<p>You can have a maximum of 7 shutter pairs with the <strong>"+houseType()+" "+houseSize()+"’</strong> model.</p>";
			$("#"+elements[10][8]).val(7)
		}
	}
	if ((houseType() == "Cypress") && ((houseSize() == 20) || (houseSize() == 24))) {alert += "Shutters are not included on the 3 windows on bumpout.";}
	else {alert += "Shutters are not included on the 2 windows next to the door.";}
	if (alert != "") {
		var action = function() {window.location.hash="step-5";}
		createDialog(alert, "alert", action);
	}
	if (isChecked(10, 5)) {$("#"+elements[10][8]).attr("name", "Decorative shutters $" + $("#"+elements[10][8]).val() * 100);}
	if (isChecked(10, 6)) {$("#"+elements[10][8]).attr("name", "Operable shutters $" + $("#"+elements[10][8]).val() * 350);}
	if (isChecked(10, 7)) {$("#"+elements[10][8]).attr("name", "Painted shutters $" + $("#"+elements[10][8]).val() * 50);}
	*/

	//	STEP #6: EXTERIOR - DOOR(S)
	if (isChecked(11, 10)) {enableGroup(11, 11, 12); enableElement(11, 14);}		//	If side door is selected, enable side door options
	else {disableGroup(11, 11, 12); disableElement(11, 14);}

	//	STEP #7: EXTERIOR - ROOF
	//	none

	//	STEP #8: INTERIOR - BOARDS AND DOORS
	//	none

	//	STEP #9: INTERIOR - FINISHING
	if (isChecked(14, 2)) {enableGroup(14, 3, 8);}										//	If interior stain treatment is selected, enable stain options
	else {disableGroup(14, 3, 8);}														//	otherwise disable stain options

	//	STEP #10: INTERIOR - FLOORING
	//	none

	//	STEP #11: INTERIOR - LIGHTING
	//	none

	//	STEP #12: INTERIOR - STORAGE
	//	none

	//	STEP #13: INTERIOR - EXTRAS
	//	none

	//	STEP #14: KITCHEN - COUNTERS
	//	none

	//	STEP #15: KITCHEN - COOKING
	if (groupID == 20) {
		if (isChecked(20, 3)) {enableElement(20, 4);}									//	If propane range is checked, enable range hood ventilator
		else {disableElement(20, 4);}
		if (isChecked(20, 0) || isChecked(20, 2)) {
			enableElement(27, 0);														//	If electric cooktop or range is checked, enable "All Electric" utility package
			if (!isChecked(27, 1) && !isChecked(27, 2)) {checkElement(27, 0);}			//	If no propane utility package is checked, check "All Electric" utility package
		}
		else if (isChecked(20, 1) || isChecked(20, 3)) {disableElement(27, 0);}			//	If propane cooktop or range is checked, disable "All Electric" utility package
		if ((isChecked(20, 1) || isChecked(20, 3)) && !isChecked(27, 1) && !isChecked(27, 2)) {	//	If propane is selected, and if no “Propane” utility package is checked, create dialog
			var alert = "Please be aware that when you select a propane option, your utility package will have to be upgraded to<br /><strong>Propane / Electric</strong>, which costs between $2,500 to $3,000 extra. You can select your utility package further below. Would you like to proceed?";
			var ifYes = function() {checkElement(27, 1);}
			var ifNo = function() {unCheckElement(20, 1); unCheckElement(20, 3); checkElement(20, 0);}	//	Remove propane cooktop / range, and select "All Electric" utility package
			createDialog(alert, "confirm", ifYes, ifNo);
		}
	}

	//	STEP #16: KITCHEN - REFRIGERATOR
	//	none

	//	STEP #17: KITCHEN - STORAGE
	if (!isCheckedAny(0, 0, 6)) {disableGroup(22, 0, 1);}								//	If no house size has been selected, disable toe kick drawer quantity fields
	else {enableGroup(22, 0, 1);}														//	Enable toe kick drawer quantity field
	if (getFloorPlan() == "Overlook") {enableElement(22, 18);}								//	Kitchen pantry only available for the Overlook floor plan
	else {disableElement(22, 18);}														//	Disable pantry if not Overlook

	//	BATHROOM - WASHING
	if (getFloorPlan() == "Overlook") {disableGroup(23, 0, 1);}							//	Hand sink with mirror not available for Overlook floor plan
	else {enableGroup(23, 0, 1);}

	//	STEP #18: BATHROOM - TOILET
	//	none

	//	STEP #19: SLEEPING - UPSTAIRS LOFT
	if (houseType() == "Linden") {disableGroup(25, 0, 1); enableElement(25, 2);}		//	If Linden, disable Elm/Cypress lofts, enable Linden loft
	else {
		disableElement(25, 2);															//	Otherwise, disable Linden loft
		if (isChecked(12, 4)) {disableElement(25, 0); enableElement(25, 1);}			//	If dormers, disable Elm/Cypress queen loft, enable Elm/Cypress dormers loft
		else {enableElement(25, 0); disableElement(25, 1);}								//	Otherwise, enable Elm/Cypress queen loft, disable Elm/Cypress dormers loft
	}
	if ((houseType() == "Linden") || isChecked(12, 4)) {enableElement(25, 4);}			//	If dormers or Linden, enable dormer cabinets
	else {disableElement(25, 4);}

	//	STEP #20: SLEEPING - DOWNSTAIRS AND STORAGE
	if (hasDownstairsBedroom()) {enableGroup(26, 0, 5);}								//	Downstairs bedroom only available in Equator, Horizon, and Vantage floor plans
	else {disableGroup(26, 0, 5);}
	if (!isCheckedAny(0, 0, 6)) {disableElement(26, 6);}								//	If no house has been selected, disable daybed.

	//	STEP #21: UTILITIES - PACKAGES
	if (isChecked(27, 0)) {enableElement(27, 3);}
	else {disableElement(27, 3);}
	if (isChecked(27, 1)) {enableElement(27, 4);}
	else {disableElement(27, 4);}
	if (isChecked(27, 2)) {enableElement(27, 5);}
	else {disableElement(27, 5);}

	//	STEP #22: UTILITIES - PLUMBING
	if (hasDownstairsBedroom() && isChecked(26, 5)) {enableElement(28, 0);}				//	Extra-large water tank only in models that have downstairs bedroom and that have a bed platform
	else {disableElement(28, 0);}

	//	STEP #23: DELIVERY
	if (isChecked(30, 0)) {
		for (key in usaMapState) {$("#"+key).css("fill", usaMapState[key][1]);}			//	Restore all previously selected states to default color
		unCheckElement(30, 1);
	}

	financingCalculator();
}
/*** MAIN ***/



/*** SKYLIGHTS ***/
var clickEvent = false;
$('#ready-ID-12-05-image').bind("click", function(e) {										//	Determine location of click to activate skylight
	var x = e.pageX - $(this).offset().left; var y = e.pageY - $(this).offset().top;
	if ((x>=145) && (x<=185) && (y>=12) && (y<=42)) {showElement("ready-ID-12-07"); addItem(12, 7); clickEvent = true;}
	if ((x>=220) && (x<=260) && (y>=12) && (y<=42)) {showElement("ready-ID-12-08"); addItem(12, 8); clickEvent = true;}
	if ((x>=145) && (x<=185) && (y>=67) && (y<=97)) {showElement("ready-ID-12-09"); addItem(12, 9); clickEvent = true;}
	if ((x>=220) && (x<=260) && (y>=67) && (y<=97)) {showElement("ready-ID-12-10"); addItem(12, 10); clickEvent = true;}
	financingCalculator();
	if (isLive && clickEvent) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '7. Exterior - Roof: Skylights');}
});
$('#ready-ID-12-06-image').bind("click", function(e) {										//	Determine location of click to activate skylight
	var x = e.pageX - $(this).offset().left; var y = e.pageY - $(this).offset().top;
	if ((x>=145) && (x<=185) && (y>=12) && (y<=42)) {showElement("ready-ID-12-11"); addItem(12, 11); clickEvent = true;}
	if ((x>=220) && (x<=260) && (y>=12) && (y<=42)) {showElement("ready-ID-12-12"); addItem(12, 12); clickEvent = true;}
	if ((x>=296) && (x<=336) && (y>=12) && (y<=42)) {showElement("ready-ID-12-13"); addItem(12, 13); clickEvent = true;}
	if ((x>=145) && (x<=185) && (y>=67) && (y<=97)) {showElement("ready-ID-12-14"); addItem(12, 14); clickEvent = true;}
	if ((x>=220) && (x<=260) && (y>=67) && (y<=97)) {showElement("ready-ID-12-15"); addItem(12, 15); clickEvent = true;}
	if ((x>=296) && (x<=336) && (y>=67) && (y<=97)) {showElement("ready-ID-12-16"); addItem(12, 16); clickEvent = true;}
	financingCalculator();
	if (isLive && clickEvent) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '7. Exterior - Roof: Skylights');}
});
$("#ready-ID-12-07").bind("click", function(e) {hideElement("ready-ID-12-07"); removeItem(12, 7); financingCalculator();});
$("#ready-ID-12-08").bind("click", function(e) {hideElement("ready-ID-12-08"); removeItem(12, 8); financingCalculator();});
$("#ready-ID-12-09").bind("click", function(e) {hideElement("ready-ID-12-09"); removeItem(12, 9); financingCalculator();});
$("#ready-ID-12-10").bind("click", function(e) {hideElement("ready-ID-12-10"); removeItem(12, 10); financingCalculator();});
$("#ready-ID-12-11").bind("click", function(e) {hideElement("ready-ID-12-11"); removeItem(12, 11); financingCalculator();});
$("#ready-ID-12-12").bind("click", function(e) {hideElement("ready-ID-12-12"); removeItem(12, 12); financingCalculator();});
$("#ready-ID-12-13").bind("click", function(e) {hideElement("ready-ID-12-13"); removeItem(12, 13); financingCalculator();});
$("#ready-ID-12-14").bind("click", function(e) {hideElement("ready-ID-12-14"); removeItem(12, 14); financingCalculator();});
$("#ready-ID-12-15").bind("click", function(e) {hideElement("ready-ID-12-15"); removeItem(12, 15); financingCalculator();});
$("#ready-ID-12-16").bind("click", function(e) {hideElement("ready-ID-12-16"); removeItem(12, 16); financingCalculator();});
/*** SKYLIGHTS ***/



/*** USA MAP ***/
$('#map').on('usmapclick', function(event, data) {										//	If user clicks on delivery map
	unCheckElement(30, 0);																//	Uncheck free pickup
	checkElement(30, 1);																//	Check State selected.
	addItemCustom(30, 1, "Delivery: "+usaMapState[data.name][0], usaMapState[data.name][3]);	//	Add state to running total
	for (key in usaMapState) {$("#"+key).css("fill", usaMapState[key][1]);}						//	Restore all previously selected states to default color
	$("#"+data.name).css("fill", "#b8b8b8");											//	Fill selected state with a special color
	financingCalculator();																//	Update financing calculator
	if(isLive) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', '23. Delivery: U.S. State');}	//	Google Analytics event: delivery option selected
});
/*** USA MAP ***/



/*** FINANCING CALCULATOR ***/
function financingCalculator() {
	if ((calculateTotal() > 0) && isCheckedAny(31, 0, 2)) {								//	Only calculate if total > $0 and downpayment option has been selected
		if (isChecked(31, 0))		{var loan = calculateTotal();}
		else if (isChecked(31, 1))	{var loan = 0.9*calculateTotal();}
		else if (isChecked(31, 2))	{var loan = 0.8*calculateTotal();}
		var rateAmount = $("#"+elements[31][3]).val().split("%");
		var rate = rateAmount[0]/1200
		var payment = Math.round(loan * (rate * Math.pow(1 + rate, 180)) / (Math.pow(1 + rate, 180) - 1), 0);
		$("#"+elements[31][4]).val("$"+numberWithCommas(payment));
	}
	else {$("#"+elements[31][4]).val("$0")}
}
/*** FINANCING CALCULATOR ***/



/*** CHECK FIELDS ***/
function checkFields() {
	var gotoReq = new Array(19);														//	Be sure to update array size as more alert possibilities are added.
	var gotoOpt = new Array(5);															//	Be sure to update array size as more alert possibilities are added.
	var i = 0, j = 0;
	var required = "", optional = "";

	//	REQUIRED
	if (!isCheckedAny(0, 0, 6)) {required += "<strong>• House Model</strong><br />"; gotoReq[i] = "step-1"; i++;}
	if (!isCheckedAny(1, 0, 22)) {required += "<strong>• Floor Plan</strong><br />"; gotoReq[i] = "step-2A"; i++;}
	if (!isCheckedAny(8, 0, 1)) {required += "<strong>• Exterior Siding</strong><br />"; gotoReq[i] = "step-3"; i++;}
	if (!isCheckedAny(8, 2, 4)) {required += "<strong>• Exterior Siding Sealant</strong><br />"; gotoReq[i] = "step-3"; i++;}
	if (isChecked(8, 3) && !isCheckedAny(8, 5, 8)) {required += "<strong>• Exterior Siding (stain option)</strong><br />"; gotoReq[i] = "step-3"; i++;}
	if (isChecked(8, 4) && (!isCheckedAny(8, 9, 18) || !isCheckedAny(8, 19, 28))) {required += "<strong>• Exterior Siding (paint options)</strong><br />"; gotoReq[i] = "step-3"; i++;}
	if (!isChecked(9, 2) && !isChecked(9, 3)) {required += "<strong>• Porch Post</strong><br />"; gotoReq[i] = "step-4"; i++;}
	if ((!isCheckedAny(0, 0, 6) || (houseType() == "Cypress")) && !isCheckedAny(9, 4, 9)) {required += "<strong>• Porch Orientation</strong><br />"; gotoReq[i] = "step-4"; i++;}
	if (isChecked(11, 10) && (!isCheckedAny(11, 11, 12))) {required += "<strong>• Side Door Location</strong><br />"; gotoReq[i] = "step-6"; i++;}
	if (isChecked(14, 2) && !isCheckedAny(14, 3, 8)) {required += "<strong>• Interior Stain Color</strong><br />"; gotoReq[i] = "step-9"; i++;}
	if (!isCheckedAny(20, 0, 3)) {required += "<strong>• Kitchen Cooking Option</strong><br />"; gotoReq[i] = "step-15"; i++;}
	if (!isCheckedAny(27, 0, 2)) {required += "<strong>• Utility Package</strong><br />"; gotoReq[i] = "step-21"; i++;}
	if (!isCheckedAny(30, 0, 1)) {required += "<strong>• Delivery</strong><br />"; gotoReq[i] = "step-23"; i++;}
  	if (randomNumber != 2) {
      if (!isCheckedAny(32, 0, 3)) {required += "<strong>• Timeline</strong><br />"; gotoReq[i] = "step-FREECONSULT"; i++;}
      if (!isCheckedAny(32, 4, 5)) {required += "<strong>• Location</strong><br />"; gotoReq[i] = "step-FREECONSULT"; i++;}
      if (!isCheckedAny(32, 6, 7)) {required += "<strong>• Financing</strong><br />"; gotoReq[i] = "step-FREECONSULT"; i++;}
    }
	if (($("#FNAME").val() == "") || ($("#LNAME").val() == "")) {required += "<strong>• Your Name</strong><br />"; gotoReq[i] = "step-FREECONSULT"; i++;}
	if ($("#PHONE").val() == "") {required += "<strong>• Your Phone Number</strong><br />"; gotoReq[i] = "step-FREECONSULT"; i++;}
	if ($("#EMAIL").val() == "") {required += "<strong>• Your Email Address</strong><br />"; gotoReq[i] = "step-FREECONSULT"; i++;}

	//	OPTIONAL
	if (getFloorPlanOption() == "Equator-A-B") {if (!isCheckedAny(2, 1, 2)) {optional += "<strong>• Floor Plan Options</strong><br />"; gotoOpt[i] = "step-2B"; i++;}}
	if (getFloorPlanOption() == "Equator-A-C") {if (!isCheckedAny(2, 3, 4)) {optional += "<strong>• Floor Plan Options</strong><br />"; gotoOpt[i] = "step-2B"; i++;}}
	if (getFloorPlanOption() == "Equator-A-B-C") {if (!isCheckedAny(2, 5, 7)) {optional += "<strong>• Floor Plan Options</strong><br />"; gotoOpt[i] = "step-2B"; i++;}}
	if (getFloorPlanOption() == "Horizon-A-B-X-Y") {if (!isCheckedAny(2, 10, 11) || !isCheckedAny(2, 12, 13)) {optional += "<strong>• Floor Plan Options</strong><br />"; gotoOpt[i] = "step-2B"; i++;}}
	if (getFloorPlanOption() == "Horizon-A-B-C-X") {if (!isCheckedAny(2, 14, 16)) {optional += "<strong>• Floor Plan Options</strong><br />"; gotoOpt[i] = "step-2B"; i++;}}
	if (getFloorPlanOption() == "Horizon-A-B-C-X-Y") {if (!isCheckedAny(2, 18, 20) || !isCheckedAny(2, 21, 22)) {optional += "<strong>• Floor Plan Options</strong><br />"; gotoOpt[i] = "step-2B"; i++;}}
	
	if (getFloorPlanOption() == "Vantage-A-B-X") {if (!isCheckedAny(2, 25, 26)) {optional += "<strong>• Floor Plan Options</strong><br />"; gotoOpt[i] = "step-2B"; i++;}}
	if (getFloorPlanOption() == "Vantage-A-B-X-Y") {if (!isCheckedAny(2, 28, 29) || !isCheckedAny(2, 30, 31)) {optional += "<strong>• Floor Plan Options</strong><br />"; gotoOpt[i] = "step-2B"; i++;}}
	if (!isCheckedAny(10, 0, 4)) {optional += "<strong>• Window Color</strong><br />"; gotoOpt[j] = "step-5"; j++;}
	if (!isCheckedAny(11, 0, 9)) {optional += "<strong>• Door Color</strong><br />"; gotoOpt[j] = "step-6"; j++;}
	if (!isCheckedAny(12, 0, 3)) {optional += "<strong>• Roof Color</strong><br />"; gotoOpt[j] = "step-7"; j++;}
	if (required != "") {
		var reqMessage = "<p>Please select the following required options before scheduling a free consult.</p><p>"+required+"</p>";
	}
	if (optional != "") {
		var optMessage = "<p>The following options haven’t been selected and you can choose them later on in the buying process.";
		if (required == "") {
			optMessage += " Would you like to schedule a consult without these options?</p><p>"+optional+"</p>";
			var ifYes = function() {
              	
                if (isLive) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', 'End');}	//	Google Analytics event: submit button fired, all required fields filled out

				completeProcess = true;
              	console.log('End - Other');
				$("#SUBMITBUTTON").click();
			}
			var ifNo = function() {window.location.hash=gotoOpt[0];}
			createDialog(optMessage, "confirm", ifYes, ifNo);
			return false;
		}
		else {
			optMessage += "</p><p>"+optional+"</p>";
		}
	}
	if (required != "") {
		if (optional != "") {reqMessage += optMessage;}
		var action = function() {window.location.hash=gotoReq[0];}
		createDialog(reqMessage, "alert", action);
		return false;
	}
  	
    if ((required == "") && (optional == "")) {
      if (isLive) {ga('send', 'event', 'Customize Your Tumbleweed (test-01)', 'End');}			//	Google Analytics event: submit button fired, all required fields filled out
      completeProcess = true;
      console.log('End');
    }
    
}
/*** CHECK FIELDS ***/



/*** MAILCHIMP ***/
function initMailChimp() {
	$("#HOUSE").val("");
	$("#EXTERIOR").val("");
	$("#INTERIOR").val("");
	$("#KITCHEN").val("");
	$("#BATHROOM").val("");
	$("#SLEEPING").val("");
	$("#UTILITIES").val("");
	$("#DELIVERY").val("");
	$("#TOTAL").val("");
	$("#CUSTOMER").val("");
	addToMailChimp("HOUSE", "MODEL");													//	Model
	addToMailChimp("HOUSE", 0, 0, 6);
	addToMailChimp("HOUSE", "FLOOR PLAN");												//	Floor Plan
	addToMailChimp("HOUSE", 1, 0, 22);
	if (getFloorPlanOption() == "Equator-A") {addToMailChimp("HOUSE", 2, 0);}
	if (getFloorPlanOption() == "Equator-A-B") {addToMailChimp("HOUSE", 2, 1, 2);}
	if (getFloorPlanOption() == "Equator-A-C") {addToMailChimp("HOUSE", 2, 3, 4);}
	if (getFloorPlanOption() == "Equator-A-B-C") {addToMailChimp("HOUSE", 2, 5, 7);}
	if (getFloorPlanOption() == "Horizon-A-X") {addToMailChimp("HOUSE", 2, 8); addToMailChimp("HOUSE", 2, 9);}
	if (getFloorPlanOption() == "Horizon-A-B-X-Y") {addToMailChimp("HOUSE", 2, 10, 11); addToMailChimp("HOUSE", 2, 12, 13);}
	if (getFloorPlanOption() == "Horizon-A-B-C-X") {addToMailChimp("HOUSE", 2, 14, 6); addToMailChimp("HOUSE", 2, 17);}
	if (getFloorPlanOption() == "Horizon-A-B-C-X-Y") {addToMailChimp("HOUSE", 2, 18, 20); addToMailChimp("HOUSE", 2, 21, 22);}
	if (getFloorPlanOption() == "Overlook-A-B") {addToMailChimp("HOUSE", 2, 23, 24);}
	if (getFloorPlanOption() == "Vantage-A-B-X") {addToMailChimp("HOUSE", 2, 25, 26); addToMailChimp("HOUSE", 2, 27);}
	if (getFloorPlanOption() == "Vantage-A-B-X-Y") {addToMailChimp("HOUSE", 2, 28, 29); addToMailChimp("HOUSE", 2, 30, 31);}
	addToMailChimp("EXTERIOR", 8, 0, 1);												//	Exterior Siding
	addToMailChimp("EXTERIOR", 8, 2, 4);														//	Exterior Seal
	addToMailChimp("EXTERIOR", 8, 5, 8);														//	Exterior Stain
	addToMailChimp("EXTERIOR", 8, 9, 18);														//	Exterior Body Paint
	addToMailChimp("EXTERIOR", 8, 19, 28);														//	Exterior Trim Paint
	addToMailChimp("EXTERIOR", 9, 2, 3);														//	Porch Post
	addToMailChimp("EXTERIOR", 9, 4, 9);														//	Porch Layout
	addToMailChimp("EXTERIOR", 9, 10);															//	Porch Steps
	addToMailChimp("EXTERIOR", 9, 11);															//	Vestibule
	addToMailChimp("EXTERIOR", 10, 0, 4);														//	Window Color
	addToMailChimp("EXTERIOR", 11, 0, 9);														//	Door Color
	addToMailChimp("EXTERIOR", 11, 11, 12);														//	Side Door
	addToMailChimp("EXTERIOR", 11, 13);															//	Screen Door for Front Door
	addToMailChimp("EXTERIOR", 11, 14);															//	Screen Door for Side Door
	addToMailChimp("EXTERIOR", 12, 0, 3);														//	Roof Color
	addToMailChimp("EXTERIOR", 12, 4);															//	Dormers
	addToMailChimp("EXTERIOR", 12, 7);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 8);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 9);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 10);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 11);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 12);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 13);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 14);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 15);															//	Skylights
	addToMailChimp("EXTERIOR", 12, 16);															//	Skylights
	addToMailChimp("INTERIOR", 13, 0);															//	Sliding Door
	addToMailChimp("INTERIOR", 14, 0, 2);														//	Interior Seal / Stain
	addToMailChimp("INTERIOR", 14, 3, 8);														//	Interior Stain Color
	addToMailChimp("INTERIOR", 15, 0, 3);														//	Floor Type
	addToMailChimp("INTERIOR", 16, 0, 1);														//	Lighting Type
	addToMailChimp("INTERIOR", 16, 2);															//	LED Package
	addToMailChimp("INTERIOR", 17, 0);															//	Railing
	addToMailChimp("INTERIOR", 17, 1);															//	6' Tall Bookcase
	addToMailChimp("INTERIOR", 17, 2);															//	3' Tall Bookcase
	addToMailChimp("INTERIOR", 18, 0);															//	Data/TV Outlet
	addToMailChimp("INTERIOR", 18, 1);															//	Data/TV Outlet
	addToMailChimp("INTERIOR", 18, 2);															//	Data/TV Outlet
	addToMailChimp("INTERIOR", 18, 3);															//	Data/TV Outlet
	addToMailChimp("INTERIOR", 18, 4);															//	Outlet/USB Charger
	addToMailChimp("INTERIOR", 18, 5);															//	Outlet/USB Charger
	addToMailChimp("INTERIOR", 18, 6);															//	Outlet/USB Charger
	addToMailChimp("INTERIOR", 18, 7);															//	Outlet/USB Charger
	addToMailChimp("KITCHEN", 19, 0, 1);														//	Kitchen Countertop
	addToMailChimp("KITCHEN", 19, 2);															//	Kitchen Drop Leaf Table
	addToMailChimp("KITCHEN", 20, 0, 3);														//	Kitchen Cooking
	addToMailChimp("KITCHEN", 21, 0, 1);														//	Kitchen Refrigerator
	addToMailChimp("KITCHEN", 22, 1);															//	Kitchen Toe Kick Drawer
	addToMailChimp("KITCHEN", 22, 2, 3);														//	Kitchen Storage
	addToMailChimp("KITCHEN", 22, 4, 17);														//	Kitchen Stain / Paint Options
	addToMailChimp("KITCHEN", 22, 18);															//	Kitchen Pantry
	addToMailChimp("BATHROOM", 24, 0, 1);														//	Bathroom Toilet
	addToMailChimp("BATHROOM", 24, 2);															//	Bathroom Cabinet
	addToMailChimp("SLEEPING", 25, 3);															//	Sleeping Triangle Storage
	addToMailChimp("SLEEPING", 25, 4);															//	Sleeping Dormer Storage
	addToMailChimp("SLEEPING", 25, 5, 7);														//	Sleeping Ladder
	addToMailChimp("SLEEPING", 26, 4, 5);														//	Sleeping Downstairs Bedroom
	addToMailChimp("SLEEPING", 26, 6);															//	Sleeping Desk / Daybed
	addToMailChimp("UTILITIES", 27, 0, 2);														//	Utility Package
    addToMailChimp("UTILITIES", 27, 3, 5);														//	Utility Package
  	addToMailChimp("UTILITIES", 28, 0);															//	Water Tank
  	addToMailChimp("UTILITIES", 28, 1, 2);														//	Washer/Dryer
	if (isChecked(30, 0)) {addToMailChimp("DELIVERY", 30, 0);}
	else {addToMailChimp("DELIVERY", 30, 1);}
	addToMailChimp("TOTAL", "GRAND TOTAL: " + $("#ready-total-amount").text());
	addToMailChimp("CUSTOMER", 32, 0, 3);														//	Timeline
	addToMailChimp("CUSTOMER", 32, 4, 5);														//	Location
	addToMailChimp("CUSTOMER", 32, 6, 7);														//	Financing
	var leadScore = 0;
	if (isChecked(32, 0)) {leadScore += 5;}
	if (isChecked(32, 1)) {leadScore += 1;}
	if (isChecked(32, 4)) {leadScore += 1;}
	if (isChecked(32, 7)) {leadScore += 3;}
	$("#LEADSCORE").val(leadScore);														//	Leadscore
}
function addToMailChimp (mergeField, groupID, elementStart, elementEnd) {
	if (isNaN(groupID)) {
		var currentValue = $("#"+mergeField).val();
		if (currentValue != "") {currentValue += " - ";}								//	Add divider for subheaders, e.g. "FLOOR PLAN"
		$("#"+mergeField).val(currentValue + groupID + " - ");
	}
	else {
		var currentValue = $("#"+mergeField).val();
		var x=(groupID>9)?groupID:"0"+groupID;
		if(arguments.length == 3) {elementEnd = elementStart;}
		if (isCheckedAny(groupID, elementStart, elementEnd) && $("#ready-item-"+x+"-"+findElement(groupID, elementStart, elementEnd)).text() != "") {
			$("#"+mergeField).val(currentValue + $("#ready-item-"+x+"-"+findElement(groupID, elementStart, elementEnd)).text()+" "+$("#ready-amount-"+x+"-"+findElement(groupID, elementStart, elementEnd)).text() + " - ");
		}
	}
}
/*** MAILCHIMP ***/



/*** ELEMENT FUNCTIONS: DO NOT MODIFY ***/


//	FUNCTIONS - GROUP
//	radioGroupReq, radioGroupOpt
function radioGroupReq (groupID, elementID, elementStart, elementEnd) {
	if ((elementID >= elementStart) && (elementID <= elementEnd)) {
		for (var i=elementStart; i<=elementEnd; i++) {
			if (i!=elementID) {unCheckElement(groupID, i);}
			else if (!isChecked(groupID, elementID)) {checkElement(groupID, i);}
		}
	}
}
function radioGroupOpt (groupID, elementID, elementStart, elementEnd) {
	if ((elementID >= elementStart) && (elementID <= elementEnd)) {
		for (var i=elementStart; i<=elementEnd; i++) {
			if (i!=elementID) {unCheckElement(groupID, i);}
		}
	}
}


//	FUNCTIONS - HOUSES
//	houseType, houseSize, houseTypeSize, getHouseTypeByFloorPlan, getHouseSizeByFloorPlan, getFloorPlan, getFloorPlanOption, hasDownstairsBedroom
function houseType (house) {
	if (house !== undefined) {
		if (house==0 || house==1 || house==2) {return "Cypress";}
		if (house==3 || house==4 || house==5) {return "Elm";}
		if (house==6) {return "Linden";}
	}
	else {
		for (var i=0; i<=elements[0].length-1; i++) {
			if (isChecked(0, i)) {
				if (i==0 || i==1 || i==2) {return "Cypress";}
				if (i==3 || i==4 || i==5) {return "Elm";}
				if (i==6) {return "Linden";}
			}
		}
	}
}
function houseSize (house) {
	if (house !== undefined) {
		if (house==0 || house==3) {return 18;}
		if (house==1 || house==4 || house==6) {return 20;}
		if (house==2 || house==5) {return 24;}
	}
	else {
		for (var i=0; i<=elements[0].length-1; i++) {
			if (isChecked(0, i)) {
				if (i==0 || i==3) {return 18;}
				if (i==1 || i==4 || i==6) {return 20;}
				if (i==2 || i==5) {return 24;}
			}
		}
	}
}
function houseTypeSize (house) {
	var response;
	if (house !== undefined) {
		if (house==0 || house==1 || house==2) {response = "Cypress";}
		if (house==3 || house==4 || house==5) {response = "Elm";}
		if (house==6) {response = "Linden";}
		if (house==0 || house==3) {response += "-18";}
		if (house==1 || house==4 || house==6) {response += "-20";}
		if (house==2 || house==5) {response += "-24";}
	}
	else {
		for (var i=0; i<=elements[0].length-1; i++) {
			if (isChecked(0, i)) {
				if (i==0 || i==1 || i==2) {response = "Cypress";}
				if (i==3 || i==4 || i==5) {response = "Elm";}
				if (i==6) {response = "Linden";}
				if (i==0 || i==3) {response += "-18";}
				if (i==1 || i==4 || i==6) {response += "-20";}
				if (i==2 || i==5) {response += "-24";}
			}
		}
	}
	return response;
}
function getHouseTypeByFloorPlan (floorPlan) {
	if (floorPlan !== undefined) {
		if ((floorPlan>=0) && (floorPlan<=10)) {return "Cypress";}						//	Cypress 18' through Cypress 24' floor plans
		if ((floorPlan>=11) && (floorPlan<=19)) {return "Elm";}							//	Elm 18' through Elm 24' floor plans
		if ((floorPlan>=20) && (floorPlan<=22)) {return "Linden";}						//	Linden 20' floor plans
	}
	else {
		for (var i=0; i<=elements[2].length-1; i++) {
			if (isChecked(1, i)) {
				if ((i>=0) && (i<=10)) {return "Cypress";}
				if ((i>=11) && (i<=19)) {return "Elm";}
				if ((i>=20) && (i<=22)) {return "Linden";}
			}
		}
	}
}
function getHouseSizeByFloorPlan (floorPlan) {
	if (floorPlan !== undefined) {
		if ((floorPlan>=0) && (floorPlan<=1)) {return 18;}								//	Cypress 18'
		if ((floorPlan>=2) && (floorPlan<=5)) {return 20;}								//	Cypress 20'
		if ((floorPlan>=6) && (floorPlan<=10)) {return 24;}								//	Cypress 24'
		if ((floorPlan>=11) && (floorPlan<=12)) {return 18;}							//	Elm 18'
		if ((floorPlan>=13) && (floorPlan<=15)) {return 20;}							//	Elm 20'
		if ((floorPlan>=16) && (floorPlan<=19)) {return 24;}							//	Elm 24'
		if ((floorPlan>=20) && (floorPlan<=22)) {return 20;}							//	Linden 20'
	}
	else {
		for (var i=0; i<=21; i++) {
			if (isChecked(1, i)) {
				if ((i>=0) && (i<=1)) {return 18;}										//	Cypress 18'
				if ((i>=2) && (i<=5)) {return 20;}										//	Cypress 20'
				if ((i>=6) && (i<=10)) {return 24;}										//	Cypress 24'
				if ((i>=11) && (i<=12)) {return 18;}									//	Elm 18'
				if ((i>=13) && (i<=15)) {return 20;}									//	Elm 20'
				if ((i>=16) && (i<=19)) {return 24;}									//	Elm 24'
				if ((i>=20) && (i<=22)) {return 20;}									//	Linden 20'
			}
		}
	}
}
function getFloorPlan (floorPlan) {
	if (floorPlan !== undefined) {
		if (floorPlan==0) {return "Equator";}											//	Cypress 18'
		if (floorPlan==1) {return "Overlook";}											//	Cypress 18'
		if (floorPlan==2) {return "Arise";}												//	Cypress 20'
		if (floorPlan==3) {return "Equator";}											//	Cypress 20'
		if (floorPlan==4) {return "Horizon";}											//	Cypress 20'
		if (floorPlan==5) {return "Overlook";}											//	Cypress 20'
		if (floorPlan==6) {return "Arise";}												//	Cypress 24'
		if (floorPlan==7) {return "Equator";}											//	Cypress 24'
		if (floorPlan==8) {return "Horizon";}											//	Cypress 24'
		if (floorPlan==9) {return "Overlook";}											//	Cypress 24'
		if (floorPlan==10) {return "Vantage";}											//	Cypress 24'
		if (floorPlan==11) {return "Equator";}											//	Elm 18'
		if (floorPlan==12) {return "Overlook";}											//	Elm 18'
		if (floorPlan==13) {return "Equator";}											//	Elm 20'
		if (floorPlan==14) {return "Horizon";}											//	Elm 20'
		if (floorPlan==15) {return "Overlook";}											//	Elm 20'
		if (floorPlan==16) {return "Equator";}											//	Elm 24'
		if (floorPlan==17) {return "Horizon";}											//	Elm 24'
		if (floorPlan==18) {return "Overlook";}											//	Elm 24'
		if (floorPlan==19) {return "Vantage";}											//	Elm 24'
		if (floorPlan==20) {return "Equator";}											//	Linden 20'
		if (floorPlan==21) {return "Horizon";}											//	Linden 20'
		if (floorPlan==22) {return "Overlook";}											//	Linden 20'
	}
	else {
		if	(isChecked(1, 0) || isChecked(1, 3) || isChecked(1, 7) || isChecked(1, 11) || isChecked(1, 13) || isChecked(1, 16) || isChecked(1, 20)) {return "Equator";}
		else if	(isChecked(1, 1) || isChecked(1, 5) || isChecked(1, 9) || isChecked(1, 12) || isChecked(1, 15) || isChecked(1, 18) || isChecked(1, 22)) {return "Overlook";}
		else if (isChecked(1, 2) || isChecked(1, 6)) {return "Arise";}
		else if (isChecked(1, 4) || isChecked(1, 8) || isChecked(1, 14) || isChecked(1, 17) || isChecked(1, 21)) {return "Horizon";}
		else if (isChecked(1, 10) || isChecked(1, 19)) {return "Vantage";}
	}
}
function getFloorPlanOption() {
	if ((getFloorPlan() == "Equator") && ((houseTypeSize() == "Elm-18") || (houseTypeSize() == "Elm-20") || (houseTypeSize() == "Linden-20"))) {return "Equator-A";}
	if ((getFloorPlan() == "Equator") && (houseTypeSize() == "Elm-24")) {return "Equator-A-B";}
	if ((getFloorPlan() == "Equator") && ((houseTypeSize() == "Cypress-18") || (houseTypeSize() == "Cypress-20"))) {return "Equator-A-C";}
	if ((getFloorPlan() == "Equator") && (houseTypeSize() == "Cypress-24")) {return "Equator-A-B-C";}
	if ((getFloorPlan() == "Horizon") && ((houseTypeSize() == "Elm-20") || (houseTypeSize() == "Linden-20"))) {return "Horizon-A-X";}
	if ((getFloorPlan() == "Horizon") && (houseTypeSize() == "Elm-24")) {return "Horizon-A-B-X-Y";}
	if ((getFloorPlan() == "Horizon") && (houseTypeSize() == "Cypress-20")) {return "Horizon-A-B-C-X";}
	if ((getFloorPlan() == "Horizon") && (houseTypeSize() == "Cypress-24")) {return "Horizon-A-B-C-X-Y";}
	if (getFloorPlan() == "Overlook") {return "Overlook-A-B";}
	if ((getFloorPlan() == "Vantage") && (houseTypeSize() == "Elm-24")) {return "Vantage-A-B-X";}
	if ((getFloorPlan() == "Vantage") && (houseTypeSize() == "Cypress-24")) {return "Vantage-A-B-X-Y";}
	if (getFloorPlan() == "Arise") {return "Arise";}
}
function hasDownstairsBedroom () {
	if ((getFloorPlan() == "Equator") || (getFloorPlan() == "Horizon") || (getFloorPlan() == "Vantage")) {return true;}
	else {return false;}
}


//	FUNCTIONS - SIDEBAR
//	numberWithCommas, calculateTotal, addItem, addItemCustom, removeItem, removeItemGroup, removeItemName
function numberWithCommas (x) {return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");}
function calculateTotal () {
	var itemAmount = 0;
	for (var i=0; i<=elements.length-1; i++) {
		for (var j=0; j<=elements[i].length-1; j++) {
			var x=(i>9)?i:"0"+i; var y=(j>9)?j:"0"+j;
			var isError = isNaN(parseInt($("#ready-amount-"+x+"-"+y).html().substring(1,$("#ready-amount-"+x+"-"+y).html().length).replace(/,/g, ''), 10));
			itemAmount += (isError ? 0 : parseInt($("#ready-amount-"+x+"-"+y).html().substring(1,$("#ready-amount-"+x+"-"+y).html().length).replace(/,/g, ''), 10));
		}
	}
	$("#ready-total-amount").html("$"+numberWithCommas(itemAmount));
	return itemAmount;
}
function addItem (groupID, elementID) {
	if (!$("#"+elements[groupID][elementID]).is(".ready-slider") && (($("#"+elements[groupID][elementID]).val() != undefined) || $("#"+elements[groupID][elementID]).is("div"))) {
		if ($("#"+elements[groupID][elementID]).is("input:text") || $("#"+elements[groupID][elementID]).is("div")) {
			var elementValue = $("#"+elements[groupID][elementID]).attr("name");
		}
		else if (($("#"+elements[groupID][elementID]).val() == "") && ($("#"+elements[groupID][elementID]).attr("name") != "")) {
			groupID = parseInt($("#"+elements[groupID][elementID]).attr("name").substring(9,11));
			elementID = parseInt($("#"+elements[groupID][elementID]).attr("name").substring(12,14));
			var elementValue = $("#"+elements[groupID][elementID]).attr("name");
		}
		else {
			var elementValue = $("#"+elements[groupID][elementID]).val();
		}
		var x=(groupID>9)?groupID:"0"+groupID; var y=(elementID>9)?elementID:"0"+elementID;
		elementValue = elementValue.split("$");
		if (elementValue.length > 1) {													//	If element value has both an item and an amount
			elementValue[0] = elementValue[0].substring(0,elementValue[0].length-1);
			elementValue[1] = "$" + elementValue[1];
			$("#ready-item-"+x+"-"+y).html(elementValue[0]);							//	Fill in item in running total
			$("#ready-amount-"+x+"-"+y).html(elementValue[1]);							//	Fill in amount in running total
			calculateTotal();
		}
		else {$("#ready-item-"+x+"-"+y).html(elementValue[0]);}
	}
}
function addItemCustom (groupID, elementID, name, amount) {
	var x=(groupID>9)?groupID:"0"+groupID; var y=(elementID>9)?elementID:"0"+elementID;
	$("#ready-item-"+x+"-"+y).html(name);
	$("#ready-amount-"+x+"-"+y).html(amount);
	calculateTotal();
}
function removeItem (groupID, elementID) {
	if (($("#"+elements[groupID][elementID]).val() == "") && ($("#"+elements[groupID][elementID]).attr("name") != "") && (!$("#"+elements[groupID][elementID]).is("div"))) {
		groupID = parseInt($("#"+elements[groupID][elementID]).attr("name").substring(9,11));
		elementID = parseInt($("#"+elements[groupID][elementID]).attr("name").substring(12,14));
	}
	var x=(groupID>9)?groupID:"0"+groupID; var y=(elementID>9)?elementID:"0"+elementID;
	$("#ready-item-"+x+"-"+y).html("");
	$("#ready-amount-"+x+"-"+y).html("");
	calculateTotal();
}
function removeItemGroup (groupID, elementStart, elementEnd) {for (var i=elementStart; i<=elementEnd; i++) {removeItem(groupID, i);}}
function removeItemName (elementName) {
	$("#"+elementName).html("");
	$("#"+elementName).html("");
	calculateTotal();
}


//	FUNCTIONS - SEARCH
//	findElement, findElementName
function findElement (groupID, elementStart, elementEnd) {
	for (var i=elementStart; i<=elementEnd; i++) {
		if (isChecked(groupID, i)) {return (i>9)?i:"0"+i;}								//	Exception to the rule: returns element as double-digit, e.g. "03" instead of "3"
	}
}
function findElementName (groupID, elementStart, elementEnd) {
	for (var i=elementStart; i<=elementEnd; i++) {
		if (isChecked(groupID, i)) {
			var elementName = $("#"+elements[groupID][i]).val();
			elementName = elementName.split("$");
			return elementName[0].substring(0,elementName[0].length);
		}
	}
}


//	FUNCTIONS - QUERIES
//	isChecked, isCheckedActive, isCheckedActiveOne, isUnCheckedActive, isUnCheckedActiveOne, isCheckedAny, isCheckedOne, isEnabled, isVisible?
function isChecked(groupID, elementID) {
	if ($("#"+elements[groupID][elementID]).is("div") && $("#"+elements[groupID][elementID]).attr("name") != "") {return true;}
	else {return document.getElementById(elements[groupID][elementID]).checked;}
}
function isCheckedActive(groupID, elementID, x, y) {
	if ((groupID == x) && (elementID == y) && isChecked(groupID, elementID)) {return true;}
	return false;
}
function isCheckedActiveOne(groupID, elementID, x, elementStart, elementEnd) {
	if (x == groupID) {for (var y=elementStart; y<=elementEnd; y++) {if ((y == elementID) && isChecked(groupID, elementID)) {return true;}}}
	return false;
}
function isUnCheckedActive(groupID, elementID, x, y) {
	if ((groupID == x) && (elementID == y) && !isChecked(groupID, elementID)) {return true;}
	return false;
}
function isUnCheckedActiveOne(groupID, elementID, x, elementStart, elementEnd) {
	if (x == groupID) {for (var y=elementStart; y<=elementEnd; y++) {if ((y == elementID) && !isChecked(groupID, elementID)) {return true;}}}
	return false;
}
function isCheckedAny(groupID, elementStart, elementEnd) {
	for (var i=elementStart; i<=elementEnd; i++) {if (isChecked(groupID, i)) {return true;}}
	return false;
}
function isCheckedOne(groupID, elementID, elementStart, elementEnd) {
	for (var j=elementStart; j<=elementEnd; j++) {
		if ((elementID == j) && isChecked(groupID, elementID)) {return true;}
	}
	return false;
}
function isEnabled (groupID, elementID) {
	if (!document.getElementById(elements[groupID][elementID]).disabled) {return true;}
	else {return false;}
}
function isVisible (groupID, elementID) {
	if (isNaN(groupID)) {
		if (!!document.getElementById(groupID)) {
			if (document.getElementById(groupID).style.display != "none") {return true;}
			else {return false;}
		}
	}
	else {
		if (!!document.getElementById(elements[groupID][elementID])) {
			if (document.getElementById(elements[groupID][elementID]).style.display != "none") {return true;}
			else {return false;}
		}
	}
}


//	FUNCTIONS - ACTIONS
//	check/uncheck, enable/disable, show/hide element or group of elements
function checkElement (groupID, elementID) {
	if (!!document.getElementById(elements[groupID][elementID])) {
		if (isLive && !beginProcess) {beginProcess = true; ga('send', 'event', 'Customize Your Tumbleweed (test-01)', 'Begin');}	//	Google Analytics event: first element selected
		enableElement(groupID, elementID);
		document.getElementById(elements[groupID][elementID]).checked = true;
		addItem(groupID, elementID);
	}
}
function checkGroup (groupID, elementStart, elementEnd) {for (var i=elementStart; i<=elementEnd; i++) {checkElement(groupID, i);}}
function unCheckElement (groupID, elementID) {
	if (!!document.getElementById(elements[groupID][elementID])) {
		document.getElementById(elements[groupID][elementID]).checked = false;
		removeItem(groupID, elementID);
	}
}
function unCheckGroup (groupID, elementStart, elementEnd) {for (var i=elementStart; i<=elementEnd; i++) {unCheckElement(groupID, i);}}
function enableElement (groupID, elementID) {
	if (isNaN(groupID)) {
		if (!!document.getElementById(groupID)) {document.getElementById(groupID).disabled = false;}
		if (!!document.getElementById(groupID+"-container")) {
			$(document.getElementById(groupID+"-container")).removeClass("ready-disabled").addClass("ready-enabled");
		}
		else {
			if (!!document.getElementById(groupID+"-image")) {$(document.getElementById(groupID+"-image")).removeClass("ready-disabled").addClass("ready-enabled");}
			if (!!document.getElementById(groupID+"-color")) {$(document.getElementById(groupID+"-color")).removeClass("ready-disabled").addClass("ready-enabled");}
			if (!!document.getElementById(groupID+"-label")) {$(document.getElementById(groupID+"-label")).removeClass("ready-disabled").addClass("ready-enabled");}
		}
	}
	else {
		if (!!document.getElementById(elements[groupID][elementID])) {document.getElementById(elements[groupID][elementID]).disabled = false;}
		if (!!document.getElementById(elements[groupID][elementID]+"-container")) {
			$(document.getElementById(elements[groupID][elementID]+"-container")).removeClass("ready-disabled").addClass("ready-enabled");
		}
		else {
			if (!!document.getElementById(elements[groupID][elementID]+"-image")) {$(document.getElementById(elements[groupID][elementID]+"-image")).removeClass("ready-disabled").addClass("ready-enabled");}
			if (!!document.getElementById(elements[groupID][elementID]+"-color")) {$(document.getElementById(elements[groupID][elementID]+"-color")).removeClass("ready-disabled").addClass("ready-enabled");}
			if (!!document.getElementById(elements[groupID][elementID]+"-label")) {$(document.getElementById(elements[groupID][elementID]+"-label")).removeClass("ready-disabled").addClass("ready-enabled");}
		}
	}
}
function enableGroup (groupID, elementStart, elementEnd) {for (var i=elementStart; i<=elementEnd; i++) {enableElement(groupID, i);}}
function disableElement (groupID, elementID) {
	if (isNaN(groupID)) {
		if (!!document.getElementById(groupID)) {document.getElementById(groupID).disabled = true;}
		if (!!document.getElementById(groupID+"-container")) {
			$(document.getElementById(groupID+"-container")).removeClass("ready-enabled").addClass("ready-disabled");
		}
		else {
			if (!!document.getElementById(groupID+"-image")) {$(document.getElementById(groupID+"-image")).removeClass("ready-enabled").addClass("ready-disabled");}
			if (!!document.getElementById(groupID+"-color")) {$(document.getElementById(groupID+"-color")).removeClass("ready-enabled").addClass("ready-disabled");}
			if (!!document.getElementById(groupID+"-label")) {$(document.getElementById(groupID+"-label")).removeClass("ready-enabled").addClass("ready-disabled");}
		}
	}
	else {
		unCheckElement (groupID, elementID);
		if (!!document.getElementById(elements[groupID][elementID])) {document.getElementById(elements[groupID][elementID]).disabled = true;}
		if (!!document.getElementById(elements[groupID][elementID]+"-container")) {
			$(document.getElementById(elements[groupID][elementID]+"-container")).removeClass("ready-enabled").addClass("ready-disabled");
		}
		else {
			if (!!document.getElementById(elements[groupID][elementID]+"-image")) {$(document.getElementById(elements[groupID][elementID]+"-image")).removeClass("ready-enabled").addClass("ready-disabled");}
			if (!!document.getElementById(elements[groupID][elementID]+"-color")) {$(document.getElementById(elements[groupID][elementID]+"-color")).removeClass("ready-enabled").addClass("ready-disabled");}
			if (!!document.getElementById(elements[groupID][elementID]+"-label")) {$(document.getElementById(elements[groupID][elementID]+"-label")).removeClass("ready-enabled").addClass("ready-disabled");}
		}
	}
}
function disableGroup (groupID, elementStart, elementEnd) {for (var i=elementStart; i<=elementEnd; i++) {disableElement(groupID, i);}}
function showElement (groupID, elementID) {
	if (isNaN(groupID)) {
		if (!!document.getElementById(groupID)) {document.getElementById(groupID).style.display = "block";}
		if (!!document.getElementById(groupID+"-container")) {
			document.getElementById(groupID+"-container").style.display = "block";
		}
		else {
			if (!!document.getElementById(groupID+"-image")) {document.getElementById(groupID+"-image").style.display = "block";}
			if (!!document.getElementById(groupID+"-color")) {document.getElementById(groupID+"-color").style.display = "block";}
			if (!!document.getElementById(groupID+"-label")) {document.getElementById(groupID+"-label").style.display = "block";}
		}
	}
	else {
		if (!!document.getElementById(elements[groupID][elementID])) {enableElement(groupID, elementID);}
		if (!!document.getElementById(elements[groupID][elementID]+"-container")) {
			document.getElementById(elements[groupID][elementID]+"-container").style.display = "block";
		}
		else {
			if (!!document.getElementById(elements[groupID][elementID]+"-image")) {document.getElementById(elements[groupID][elementID]+"-image").style.display = "block";}
			if (!!document.getElementById(elements[groupID][elementID]+"-color")) {document.getElementById(elements[groupID][elementID]+"-color").style.display = "block";}
			if (!!document.getElementById(elements[groupID][elementID]+"-label")) {document.getElementById(elements[groupID][elementID]+"-label").style.display = "block";}
		}
	}
}
function showGroup (groupID, elementStart, elementEnd) {for (var i=elementStart; i<=elementEnd; i++) {showElement(groupID, i);}}
function hideElement (groupID, elementID) {
	if (isNaN(groupID)) {
		if (!!document.getElementById(groupID)) {document.getElementById(groupID).style.display = "none";}
		if (!!document.getElementById(groupID+"-container")) {
			document.getElementById(groupID+"-container").style.display = "none";
		}
		else {
			if (!!document.getElementById(groupID+"-image")) {document.getElementById(groupID+"-image").style.display = "none";}
			if (!!document.getElementById(groupID+"-color")) {document.getElementById(groupID+"-color").style.display = "none";}
			if (!!document.getElementById(groupID+"-label")) {document.getElementById(groupID+"-label").style.display = "none";}
		}
	}
	else {
		unCheckElement (groupID, elementID);
		if (!!document.getElementById(elements[groupID][elementID])) {document.getElementById(elements[groupID][elementID]).style.display = "none";}
		if (!!document.getElementById(elements[groupID][elementID]+"-container")) {
			document.getElementById(elements[groupID][elementID]+"-container").style.display = "none";
		}
		else {
			if (!!document.getElementById(elements[groupID][elementID]+"-image")) {document.getElementById(elements[groupID][elementID]+"-image").style.display = "none";}
			if (!!document.getElementById(elements[groupID][elementID]+"-color")) {document.getElementById(elements[groupID][elementID]+"-color").style.display = "none";}
			if (!!document.getElementById(elements[groupID][elementID]+"-label")) {document.getElementById(elements[groupID][elementID]+"-label").style.display = "none";}
		}
	}
}
function hideGroup (groupID, elementStart, elementEnd) {for (var i=elementStart; i<=elementEnd; i++) {hideElement(groupID, i);}}
  
function hideDiv (ID) {
  	var res = ID.split(",");
  	for (var i = 0; i < res.length; i++) {
        document.getElementById(res[i]).style.display = "none";
    }
	
}

//	FUNCTIONS - OTHER
//	createDialog
function createDialog(alert, type, ifYes, ifNo) {
	if (type == "confirm") {
		vex.dialog.confirm({
			message: alert,
			buttons: [$.extend({}, vex.dialog.buttons.YES, {text:"Yes"}), $.extend({}, vex.dialog.buttons.NO, {text:"No"})],
			callback: function(value) {if (value) {ifYes();} else {ifNo();}}
		});
	}
	if (type == "alert") {
		vex.dialog.alert({
			message: alert,
			callback: function(value) {if (value) {ifYes();}}
		});
	}
}
$("input, .ready-click").bind("click", function(e) {
	if (
		($(this).attr("id") != "FNAME") && ($(this).attr("id") != "LNAME") &&
		($(this).attr("id") != "PHONE") && ($(this).attr("id") != "EMAIL") &&
		($(this).attr("id") != "SUBMITBUTTON")
		) {																				//	Don’t trigger for MailChimp input fields
		var groupID = parseInt($(this).attr("id").substring(9,11));
		var elementID = parseInt($(this).attr("id").substring(12,14));
		if (!isChecked(groupID, elementID)) {checkElement(groupID, elementID);}
		else {unCheckElement(groupID, elementID);}
		main(groupID, elementID);
	}
});
$("#MailChimpForm").submit(function() {
	if (completeProcess) {return true;}
	initMailChimp();																	//	Fill out MailChimp input fields before submitting form
	checkFields();
	if (completeProcess) {return true;}
	return false;
});
/*** ELEMENT FUNCTIONS: DO NOT MODIFY ***/


});																						//	$(document).ready(function() {}); closing bracket