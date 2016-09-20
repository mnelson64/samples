/**
 * Created by Valentin-Marian Voilean on 24/05/14.
 */

(function($){

    var mapContainer = $('<div></div>').addClass('mapContainer').html($('#theMap').html()),
		twTitle=$('<div></div>').addClass('twTitle'),
		twInfo=$('<div>').addClass('twInfo');

    var subcontent = $('<div></div>').addClass('themap subcontent').append(mapContainer,twTitle,twInfo);

    $('#nav2').find('li').eq(3).append(subcontent);

    var usaMap = $('.usaMap'),
		GetTitleAndDate = function(product){
			/** Get Workshop Title & Date **/
			var splitTitle = product.title.split(/ workshop /ig);

			if (splitTitle.length > 1){
				return splitTitle;
			}
			else alert ('The "workshop" word is not present in the title. Make sure the product title match this pattern: "City, ST Workshop d-d,yyyy"');
		},
		getState = function(product){
			/** Obtain State from Product Title **/
			var n = product.title.search(/^A[ABELKPRSZ]|BC|C[AOT]|D[EC]|F[LM]|G[ALMU]|HI|I[ADLN]|K[SY]|LA|M[ABDEHINOPSTX]|N[CDEFHJKMSUVWY]|O[HKNRT]|P[AERW]|QC|RI|S[CDN]|T[NX]|U[ST]|V[AIT]|W[AIKVY]|YT/g);

			if (n != -1) return product.title.substr(n,2);
			else alert('No state in this product title: ' + product.title);
		},
		countdown = function(isAvailable, isLast, variantDate){
			var days, message;
			days = parseInt((variantDate - new Date()) / (1000 * 60 * 60 * 24));
			if (isAvailable) {
				if (days <= 10){
				if (days == 0){ message = 'Sale ends today';}
				else if (days == 1){ message = 'Sale ends tomorrow'; }
				else if (isLast) { message = 'Workshop starts in '+days+' days';}
				else { message = 'Sale ends in '+days+' days'; }
			}
			else {
				message = "Sold out";
			}
			return message;
		},
		buildWorkshop= function(product){
			var variants, lastVariant, workshopLocation, wTitle, wDate, variantTitleArray, firstTwoWords, hRibbon, hRibbonTitle, ribbonRight;

			variants = product.variants;
			lastVariant = variants[variants.length-1];

			//Add available variants in the product table
			for (var i=0; i < variants.length; i++){
				var currentVariant, currentTitle, variantDate;
				var today = new Date();

				currentVariant = variants[i];
				var isLast = (i == variants.length-1) ? true : false;

				currentTitle = currentVariant.option1;

				variantDate = new Date(currentVariant.sku);
				variantDate.setDate(variantDate.getDate() + 1);

				if ( today < variantDate ) {

					var ribbonMsg = countdown(currentVariant.available, isLast, variantDate);

					/**
					 * Build the Workshop Location Item
					 */

					workshopLocation = $('<a></a>')
						.addClass('workshopLocation')
						.attr({
							'href': '/products/'+product.handle
						});

					if (ribbonMsg !== undefined){
						workshopLocation.css({
							'left' : currentVariant.option3+'px',
							'top' : currentVariant.option2+'px'
						})
					}
					else{
						workshopLocation.css({
							'left' : lastVariant.option3+'px',
							'top' : lastVariant.option2+'px'
						})
					}
					wTitle = $('<span></span>').addClass('workshopTitle').text(GetTitleAndDate(product)[0] /* Return Title */);
					wDate = $('<span></span>').addClass('workshopDate').text(GetTitleAndDate(product)[1] /* Return Date */);

					workshopLocation.append(wTitle,wDate);



					/** Get the product's special offer and create the ribbon **/


					hRibbon = $('<div></div>').addClass('hRibbon');
					hRibbonTitle = $('<div></div>').addClass('ribbonTitle').text(ribbonMsg);
					ribbonRight = $('<div></div>').addClass('ribbon-right');
					hRibbon.append(hRibbonTitle, ribbonRight);

					/*if (variantTitleArray[0].search(/regular|one|One|full/ig) == -1){
						workshopLocation.append(hRibbon);
					}*/
					if (ribbonMsg !== undefined){
						workshopLocation.append(hRibbon);
					}
					/** Get the product's special offer and create the ribbon **/

					$('.mapContainer').append(workshopLocation);
					break;



				}
			}

		},
		expired = function(product){

			var workshopDate, filteredDate, today;

			workshopDate = GetTitleAndDate(product)[1];
			filteredDate = workshopDate.replace(/(\d\d-)|(\d-)|(\d - )|(\d\d - )|(\d -)|(\d\d -)/g, "");
			today = new Date();

			workshopDate = new Date(filteredDate);

			return (workshopDate < today); // True or False

		};

    $.fn.buildMap = function(products) {
		for (var i=0; i<products.length; i++){
			var product = products[i];

			if (!expired(product)){ // Checks if the workshop date has expired
				this.find('.'+ getState(product) ).attr('fill','#ceab6a');
				buildWorkshop(product);
			}


		}

    };

    $.getJSON('/collections/workshops-map/products.json', function(data, textStatus){
		if (textStatus == 'success'){
			usaMap.buildMap(data.products);

			// If the current page is the Workshops Page (/pages/workshops)
			var workshopPage = $('#leftSideWorkshop');
			if (workshopPage.length){
				var mapContainer2 = mapContainer.clone();
				workshopPage.prepend(mapContainer2);
			}

		}
    })



})(jQuery)