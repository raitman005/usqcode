const choicesRoom = new Choices('.dropdown-choices-neighborhood', {
	removeItemButton: true,
	itemSelectText: '',
	shouldSort: false,
});

const choicesNeighborhood  = new Choices('.dropdown-choices-room', {
	removeItemButton: true,
	itemSelectText: '',
	shouldSort: false,
});

/**
Functions
*/
function searchListing(url, data, append = false) 
{
	if (!append) {
		page = 1;
		data.page = page;
		document.querySelector('#div-search-result').innerHTML = 
		el.innerHTML = "<div class='loading-wrapper'><div class='lds-ring'><div></div></div></div>" + el.innerHTML;
	} else {
		divLazyLoad.classList.remove('d-none');
	}
	
	var params = typeof data == 'string' ? data : Object.keys(data).map(
			function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
		).join('&');

	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xhr.open('POST', url);
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200) { 
			render(JSON.parse(xhr.responseText), append); 
			mutextLazyIsLoading = false;
		}
	};
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.send(JSON.stringify(data));
	return xhr;
}

function render(data, append = false)
{
	if (append) {
		el.innerHTML = el.innerHTML+data.html;
	} else {
		el.innerHTML = data.html;
		
	}
	
	var textCountTitle = document.querySelectorAll('.text-counts');
	var listingCounts = document.querySelectorAll('.span-listing-cnt');
	var paginationWrapper = document.querySelectorAll('.pagination-wrapper');
	
	for (var i = 0; i < textCountTitle.length; i++) {
		textCountTitle[i].classList.remove('d-none');
	}
	for (var i = 0; i < listingCounts.length; i++) {
		listingCounts[i].innerHTML = data.apartment_cnt;
	}
	divLazyLoad.classList.add('d-none');
	if (data.paginateApartmentCnt <= 0) {
		canLazyLoad = false;
	} else {
		canLazyLoad = true;
	}


	const element = document.querySelectorAll('img.card-img-top');
	const observer = lozad(element); // passing a `NodeList` (e.g. `document.querySelectorAll()`) is also valid
	observer.observe();
	// $('.fotorama'+data.page).fotorama({
	// 	nav: false,
	// 	shadows: false,
	// 	transition: 'crossfade',
	// 	swipe: true,
	// 	maxwidth: "100%",
	// 	ratio: "800/600",
	// 	width: "100%",
	// });
	setInView();


		console.log('DOM fully loaded and parsed');
		if ("scrollPosition" in localStorage) {
			let scrollPos = localStorage.getItem('scrollPosition');
				if(scrollPos){
					console.log(scrollPos);
					window.scrollTo(0, scrollPos);
				}
			localStorage.clear();
		}
}

function showRefineSearchForm()
{
	document.querySelector('#div-refine-search').classList.remove('d-none');
	document.querySelector('#div-listing-search').classList.remove('col-lg-12');
	document.querySelector('#div-listing-search').classList.add('col-lg-9');

	var dynamicCol = document.querySelectorAll('.dynamic-col');
}

function hideRefineSearchForm()
{
	document.querySelector('#div-refine-search').classList.add('d-none');
	document.querySelector('#div-listing-search').classList.remove('col-lg-9');
	document.querySelector('#div-listing-search').classList.add('col-lg-12');

	var dynamicCol = document.querySelectorAll('.dynamic-col');
}

function testInView($el){
	var wTop = $(window).scrollTop();
	var wBot = wTop + $(window).height();
	var eTop = $el.offset().top;
	var eBot = eTop + $el.height() - 100;
	return ((eBot <= wBot) && (eTop >= wTop));
}

function setInView(){
	$("div.dynamic-col").each(function(){
		var $currentDiv = $(this);
		if(testInView($currentDiv)){
			//put a marker
			newLat = $currentDiv.attr('data-lat');
			newLng = $currentDiv.attr('data-lng');
			if (newLat != currentLat || newLng != currentLng) {
				layerGroup.clearLayers();
				var newMarker = new L.marker([newLat, newLng]).addTo(layerGroup);
				map.panTo(new L.LatLng(newLat, newLng));
			}
			currentLat = newLat;
			currentLng = newLng;
		}
	});
}

/**
	Events
*/
document.addEventListener("DOMContentLoaded", function() {
	searchListing(searchUrl, data);
});

choicesNeighborhood.passedElement.element.addEventListener('addItem', (event) => {
	data.neighborhood_ids.push(event.detail.value)
	searchListing(searchUrl, data)
}, true);

choicesNeighborhood.passedElement.element.addEventListener('removeItem', (event) => {
	data.neighborhood_ids = data.neighborhood_ids.filter(function( obj ) {
		return obj !== event.detail.value;
	});
	searchListing(searchUrl, data)
}, true);

choicesRoom.passedElement.element.addEventListener('addItem', (event) => {
	data.rooms.push(event.detail.value)
	searchListing(searchUrl, data)
}, true);

choicesRoom.passedElement.element.addEventListener('removeItem', (event) => {
	data.rooms = data.rooms.filter(function( obj ) {
		return obj !== event.detail.value;
	});
	searchListing(searchUrl, data)
}, true);

btnRefineSearch.addEventListener('click', (event) => {
	if (!refineSearchCollapsed) {
		showRefineSearchForm()
		refineSearchCollapsed = true;
	} else {
		hideRefineSearchForm()
		refineSearchCollapsed = false;
	}
	
}, true);

minPrice.addEventListener('change', (event) => {
	data.min_price = event.target.value;
	searchListing(searchUrl, data)
}, true);

maxPrice.addEventListener('change', (event) => {
	data.max_price = event.target.value;
	searchListing(searchUrl, data)
}, true);

window.onscroll = function(ev) {
    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight && mutextLazyIsLoading == false && canLazyLoad == true) {
		mutextLazyIsLoading = true;
		ev.stopPropagation();
		page++;
		var url = $(this).attr('href');
		var urlParams = new URLSearchParams(url)
		data.page = page;
		searchListing(searchUrl, data, true)
		return false;
    }

    
	
};



$(document).scroll(function(){
	setInView();
});
$(document).resize(function(){
	setInView();
});
$(document).ready(function(){
	osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	osm = L.tileLayer(osmUrl ,{
		maxZoom: 18,
		attribution: osmAttrib
	})

	map = L.map('map-preview').setView([40.758896, -73.985130], 15).addLayer(osm);
	
	layerGroup = L.layerGroup().addTo(map);	
	setInView();
});