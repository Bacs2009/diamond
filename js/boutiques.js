shopsMap =
{
	map : null,
	shops : null,

	init : function()
	{
		var cities = $('.b-map-menu a');

		if(!cities.length) return false;

		var 	options =
		{
			"zoom" : 5,
			"center" : new google.maps.LatLng(cities.attr("data-lat"), cities.attr("data-lng")),
			"mapTypeId" : google.maps.MapTypeId.ROADMAP
		};

		var styles = [{stylers: [{ saturation: -100 }]}];

		this.map = new google.maps.Map(document.getElementById("map_canvas"), options);
		this.map.setOptions({styles : styles});	
	   	  
	  this.setMarkers();
	  //var b = new google.maps.LatLng(49.024975, 31.419096);
	  //var b = new google.maps.LatLng(44.9584400, 34.1055800);
	  //this.map.setCenter(b);
		$('body').on('click', '.b-map-menu a', this.switchCity);
	},

	setShops : function(shops)
	{
		this.shops = shops;
	},
    setCentre1 : function(b){
		//var b = new google.maps.LatLng(49.024975, 31.419096);
        //var b = new google.maps.LatLng(44.9584400, 34.1055800);
		//shopsMap.map.setCenter(b);
	},
	setMarkers : function()
	{
		var i, shop, boxText, position, marker, options;
		
		
		for(i = 0; i < this.shops.length; i++) {
			shop = this.shops[i];
	  
			boxText = document.createElement("div");
			boxText.innerHTML = shop[4];

			position = new google.maps.LatLng(shop[1], shop[2]);
			
			if(shop[3] == 0) {
			  marker = new google.maps.Marker({position : position, map : this.map, icon : "/images/markerButiq.png"});
			} else {
			  marker = new google.maps.Marker({position : position, map : this.map, icon : "/images/markerOnline.png"});
			}
			/*Инф. окно*/
		options =
			{
				content : boxText,
				disableAutoPan : false,
				pixelOffset : new google.maps.Size(-27, -215),
				zIndex : 1,
				boxStyle : {background : "#fff", minWidth : "50px"},
				closeBoxMargin : "10px 10px 0 0",
				closeBoxURL : "/images/close.jpg",
				infoBoxClearance : new google.maps.Size(1, 1),
				isHidden : false,
				pane : "floatPane",
				enableEventPropagation : true,
				
			};

			makeInfoWin(marker, shop[4]);
			console.log(i);
			
			/*
			if(i <= 10) {
				var ib = new InfoBox(options);
			    ib.setContent(shop[4]);
                ib.open(this.map, marker);
                makeInfoWin(marker, shop[4]);
			}
			*/
		}
		
		var ib = new InfoBox(options);
    
		
		function makeInfoWin(marker, data) {
			google.maps.event.addListener(marker, 'mouseover', function(e) {
				ib.setContent(data);
				ib.open(this.map, marker);
			});
		};	
		
		
	},

	
	switchCity : function()
	{
		
	//	$('.b-map-menu a').removeClass('b-active');
	//	$(this).addClass('b-active');

		var b = new google.maps.LatLng(($(this).attr('data-lat')), ($(this).attr('data-lng')));
		shopsMap.map.setCenter(b);
		shopsMap.map.setZoom(14);
        
        
	}
	
	

};