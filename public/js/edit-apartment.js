/**
* Load plugins
*/

var $el1 = $("#apartment-photos");
$el1.fileinput({
	uploadUrl: photoUploadUrl,
	previewFileType: 'any',
	allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
	overwriteInitial: false,
	maxFileSize:6000,
	maxFilesNum: 10,
	multiple: true,
	uploadAsync: false,
	showUpload: false, // hide upload button
	showRemove: false, // hide remove button
	theme: "fas",
	initialPreviewAsData: true,
	initialPreview: currentPhotos,
	initialPreviewConfig: currentPhotosConfig,
}).on("filebatchselected", function(event, files) {
	$el1.fileinput("upload");
}).on('filesorted', function(e, params) {
	reorderPhotos(params.stack);
});;

$("#dropdown-street").select2({
	tags: true,
	createTag: function (params) {
		return {
			id: params.term,
			text: params.term,
			newOption: true
		}
	},
	templateResult: function (data) {
		var $result = $("<span></span>");
		$result.text(data.text);
		if (data.newOption) {
			
			$result.append(" <em>(new)</em>");
		}
		return $result;
	}
});

$("#dropdown-neighborhood_id").select2();

$('#txtbox-date').datepicker({
	uiLibrary: 'bootstrap4',
	format: 'yyyy-mm-dd',
});

/**
* Events
*/

$(document).on('change', '#txtbox-zip_code, #dropdown-street', function(){
	$('#map-latitude').val("");
	$('#map-longitude').val("");
	if ($('#dropdown-street').val() != "" && $('#txtbox-zip_code').val() != "") {
		var address = $('#dropdown-street').val() + " Manhattan, New York " + $('#txtbox-zip_code').val();
		$.get(location.protocol + '//nominatim.openstreetmap.org/search?format=json&q='+address, function(data){
			if (typeof data[0] != 'undefined') {
				var suggestedLocation = data[0];
				layerGroup.clearLayers();
				var newMarker = new L.marker([suggestedLocation.lat, suggestedLocation.lon]).addTo(layerGroup);
				map.panTo(new L.LatLng(suggestedLocation.lat, suggestedLocation.lon));
				$('#map-latitude').val(suggestedLocation.lat);
				$('#map-longitude').val(suggestedLocation.lon);
			}
		});
	}
})

function reorderPhotos(stack)
{
	$.ajax({
		type: "POST",
		data: {'stack': stack},
		url: reorderUrl,
	})
}