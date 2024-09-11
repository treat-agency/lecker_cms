
<div id="googleMap" style="width:100%;height:400px;"></div>

<!-- seo_purpose -->
<? if(!$show_warning): ?>
<script>


if($('#googleMap').length)
{
    //Initialize and add the map
    function initMap() {

      const Center = { lat: 28.8787057, lng: 59.354377 };
      const map = new google.maps.Map(document.getElementById("googleMap"), {
        zoom: 3,
        center: Center,
		    streetViewControl: false,
			    //  Add your markers etc. code HERE
      });

		// Array of your locations (array of objects with name, lat, long properties) RAW DATA need to create a marker out of each and add it
			var locations = <?php echo json_encode($locations); ?>;

			var processedArray = [];

		 locations.forEach(e => {
     let tempElem = {};

     tempElem.id = e.id;
     tempElem.label = e.name;
     tempElem.lat = parseFloat(e.lat);
     tempElem.lng = parseFloat(e.long);
     tempElem.type = "marker";
     processedArray.push(tempElem)
    });


    const icons = {
     marker: {
       icon: rootUrl + "items/frontend/img/geo-tag_icon.png",
       glyphColor: "white",
     },
    };

		  // Add some markers to the map.
      const markers = processedArray.map((item, i) => {

      let catColorCircles = "";


      // you can edit tooltip content here
		  const tooltipContent =
     '<div class="scrollFix"><div class="toolTipHolder">' +

        //  '<div class="toolTipTitle">' + item.label + '</div>' +
         '<div class="toolTipWhat">Hier soll:' +
          //  '<div class="toolTipColorHolder">' + catColorCircles + '</div>' +
         '</div>' +

         // '<a href="' + window.location.href + "/" + item.pretty + '">' +
         // // '<a href="' + rootUrl + "mitschreiben/" + pagePretty + "/location/" + item.pretty + '">' +
         //  '<div class="toolTipLink">Zu allen Forderungen</div>' +
         // '</a>' +
         '<div class="smallTriangle"></div>' +
       '</div></div>';


    let theIcon = icons[item.type].icon;

    const position = { lat: item.lat, lng: item.lng };

    const marker = new google.maps.Marker({
      position,
      icon: theIcon
    });

    return marker;


		})

		console.log(markers)

    // processing of marker clusters
	  const markerCluster = new markerClusterer.MarkerClusterer({ map, markers });

		}
	}

</script>


<script async="true" src="https://maps.googleapis.com/maps/api/js?key=<YOUR_API_KEY>&callback=initMap" defer></script>
<? endif ?>
