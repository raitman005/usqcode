/**
* Load plugins
*/

var $el1 = $("#apartment-photos");
$el1.fileinput({
	uploadUrl: photoUploadUrl,
	previewFileType: 'any',
	allowedFileExtensions: ['jpg', 'png', 'gif'],
	overwriteInitial: false,
	maxFileSize:20000,
	maxFilesNum: 10,
	multiple: true,
	uploadAsync: false,
	showUpload: false, // hide upload button
	showRemove: false, // hide remove button
	theme: "fas",
	initialPreviewAsData: true,
}).on("filebatchselected", function(event, files) {
	$el1.fileinput("upload");
}).on('filesorted', function(e, params) {
	reorderPhotos(params.stack);
});;




$('#txtbox-date').datepicker({
	uiLibrary: 'bootstrap4',
	format: 'yyyy-mm-dd',
	container: '#dropdown-bedrooms',
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

$(document).on('click', '.btn-save', function() {
	$('.ajax-status').addClass('d-none');
	var id = $(this).attr('data-id');

	var noFee = $("#chkbox-tag-nofee-"+id).is(":checked") ? 1 : 0;
	var exclusive = $("#chkbox-tag-exclusive-"+id).is(":checked") ? 1 : 0;
	var data = {
		price: $('#txtbox-name-'+id).val(),
		street: $('#txtbox-street-'+id).val(),
		apartment_number: $('#txtbox-apartment-number-'+id).val(),
		bedrooms: $('#dropdown-number-of-beds-'+id).val(),
		remarks: $('#txtarea-remarks-'+id).val(),
		date: $('#txtbox-date-'+id).val(),
		id: id,
		_token: csrfToken,
		noFeeTag: noFee,
		exclusiveTag: exclusive,
	};
	
	$.ajax({
		url: updateApartmentUrl,
		type: "PUT",
		data: data,
		beforeSend: function() {
			$('.ajax-status-info').removeClass("d-none");
		},
		success: function(e) {
			if (e.result) {
				$('.ajax-status').addClass('d-none');
				$('.ajax-status-success').removeClass("d-none");
				$('#text-price-'+id).text(e.data.price)
				$('#text-number-of-beds-'+id).text(e.data.bedrooms)
				$('#text-street-'+id).text(e.data.street)
				$('#text-remarks-'+id).attr('data-content', e.data.remarks)
				$('#text-date-'+id).text(e.data.date)
				$('#text-apartment-number-'+id).text(e.data.apartment_number)
				$('#apartment-data-number-of-beds'+id).addClass("text-white");
				$('#apartment-data-number-of-beds'+id).addClass("bg-success");
				
				if (noFee == 1) {
					$('#apartment-data-price'+id).addClass("text-white")
					$('#apartment-data-price'+id).addClass("bg-"+noFeeColor)
				} else {
					$('#apartment-data-price'+id).removeClass("text-white")
					$('#apartment-data-price'+id).removeClass("bg-"+noFeeColor)
				}
				if (exclusive == 1) {
					$('#apartment-data-exclusive'+id).addClass("text-white")
					$('#apartment-data-exclusive'+id).addClass("bg-"+exclusiveColor)
				} else {
					$('#apartment-data-exclusive'+id).removeClass("text-white")
					$('#apartment-data-exclusive'+id).removeClass("bg-"+exclusiveColor)
				}
				closeEdit(id);
			} else {
				$('.ajax-status').addClass('d-none');
				$('.ajax-status-danger').removeClass("d-none");
			}
		},
		error: function() {
			$('.ajax-status').addClass('d-none');
			$('.ajax-status-danger').removeClass("d-none");
		}
	});
});

function reorderPhotos(stack)
{
	$.ajax({
		type: "POST",
		data: {'stack': stack},
		url: reorderUrl,
	})
}