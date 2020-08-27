const choices = new Choices('[data-trigger]',
{
	searchEnabled: false,
	itemSelectText: '',
	shouldSort: false,
});

document.addEventListener('change', function (event) {
	if (!event.target.matches('.chkbox-neighborhood-section')) return;

	event.preventDefault();

	var evt = new Event('change', { bubbles: true });

	var sectionGroup = event.target.getAttribute("dropdown-data-group");
	var neighborhoods = document.querySelectorAll('input[type="checkbox"][dropdown-group="'+sectionGroup+'"]')

	for (var i = 0; i < neighborhoods.length; i++ ) {
		if (event.target.checked) {
			neighborhoods[i].checked = true;
			neighborhoods[i].dispatchEvent(evt);
		} else {
			neighborhoods[i].checked = false;
			neighborhoods[i].dispatchEvent(evt);
		}
	}
	
}, false);

document.addEventListener('change', function (event) {
	if (!event.target.matches('.chkbox-neighborhoods')) {
		return;
	} 
	event.preventDefault();
	var neighborhoods = document.querySelectorAll('.chkbox-neighborhoods');
	var totalChecked = 0;
	var neighborhoodsLabels = [];
	var neighborhoodsLabelsSelectedText = "";

	for (var i = 0; i < neighborhoods.length; ++i)
	{
		if(neighborhoods[i].checked) {
			totalChecked++;
			neighborhoodsLabels.push(neighborhoods[i].getAttribute("data-label"));
			document.getElementById(pathMap[neighborhoods[i].value]).classList.add('selected');
		} else {
			document.getElementById(pathMap[neighborhoods[i].value]).classList.remove('selected');
		}
	}

	for (var i = 0; i < neighborhoodsLabels.length; i++) {
		neighborhoodsLabelsSelectedText += neighborhoodsLabels[i] + ", ";
		if (i == 1) {
			break;
		}
	}

	if (neighborhoodsLabels.length > 2) {
		neighborhoodsLabelsSelectedText += (neighborhoodsLabels.length - 2) + " more...";
	}
	
	document.getElementById('search-neighborhood').value= trimChar(neighborhoodsLabelsSelectedText, ",");

	var totalChecked = document.querySelectorAll('.chkbox-neighborhoods:checked').length;

	if (totalChecked > 0) {
		document.getElementById('btn-modal-select').innerHTML = "Select (" + totalChecked + ")"
	} else {
		document.getElementById('btn-modal-select').innerHTML = "Select";
	}
}, false);

function trimChar(string, charToRemove) 
{
	string = string.trim();
	while(string.charAt(0)==charToRemove) {
		string = string.substring(1);
	}

	while(string.charAt(string.length-1)==charToRemove) {
		string = string.substring(0,string.length-1);
	}

	return string;
}

function addNeighborhoods()
{
	var neighborhoods = document.querySelectorAll('.chkbox-neighborhoods:checked');
	for (var i = 0; i < neighborhoods.length; ++i)
	{
		var myin = document.createElement("input");
		myin.type='hidden';
		myin.name='neighborhood_id[]';
		myin.value=neighborhoods[i].value;
		document.getElementById('frm-search').appendChild(myin);
	}
}

function hoverNeighborhood(id)
{
	if (typeof pathMapNames[id] != 'undefined') {
		document.getElementById('neighborhood-caption').innerHTML = pathMapNames[id]
	}
}

function selectTextArea(id) 
{
	var neighborhoodId = reversedPathMap[id];
	var neighborhood = document.getElementById('chkbox-neighbor-'+neighborhoodId);
	var evt = new Event('change', { bubbles: true });
	if (neighborhood.checked) {
		neighborhood.checked = false;
		neighborhood.dispatchEvent(evt);
	} else {
		neighborhood.checked = true;
		neighborhood.dispatchEvent(evt);
	}
}
function selectArea(id)
{
	var neighborhoodId = reversedPathMap[id];
	var neighborhood = document.getElementById('chkbox-neighbor-'+neighborhoodId);
	var evt = new Event('change', { bubbles: true });
	if (neighborhood.checked) {
		neighborhood.checked = false;
		neighborhood.dispatchEvent(evt);
	} else {
		neighborhood.checked = true;
		neighborhood.dispatchEvent(evt);
	}
}