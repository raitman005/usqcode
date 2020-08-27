@extends('admin.layouts.app')
@section('title', 'Listings')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/fileinput.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/switch.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
  crossorigin=""/>
<style>
    #map {
        height: 500px;
    }
    label {
        font-size: 14px;
    }
    .dataTables_length{display:none !important;}
    .dataTables_filter{display:none !important;}
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
/* Style the buttons */
.btn {
  border: none;
  outline: none;
  padding: 12px 16px;
  background-color: #f1f1f1;
  cursor: pointer;
}

.btn:hover {
  background-color: #ddd;
}

.btn.active {
  background-color: #666;
  color: white;
}
</style>
<div class="container-fluid text-white" style="margin-bottom:100px;">
    <div class="row">
        <div class="col-md-12">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has($msg))
                    <div class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                @endif
            @endforeach
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="row  mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-2 text-white">My listings</h1>        
        </div>
        <div class="col-md-6 text-right">
            <a href="#" class="btn btn-primary">Create Listing</a>
        </div>
    </div>

    <div class="card shadow mb-4 text-gray-800">
        <div class="card-body">
            <div class="table-responsive">
            	<form method="POST" id="sortView" action="{{ route('agent.listing.updatestatus') }}" enctype="multipart/form-data">
				@csrf
                <table id="example" class="table table-striped table-bordered" style="width:100%; min-height:250px;">
                    <thead>
			        	<tr>
			            	<th><input type="checkbox" id="checkAll"></th>
			                <th>Select All</th>
			                <th></th>
			                <th></th>
			                <th></th>
			                <th><span class="btn" onclick="editView()">Edit</span></th>
			                <th><input class="btn btn-outline-secondary" type="submit" name="action" value="Saved" /></th>
			                <th></th>
			                <th></th>
			            </tr>
                        <tr>
			            	<th></th>
			                <th>Address</th>
			                <th>Apt#</th>
			                <th>Price</th>
			                <th>Bedroom</th>
			                <th>Bathroom</th>
			                <th>Date Listed</th>
			                <th>Area</th>
			                <th></th>
			            </tr>
                    </thead>
                    <tbody>
                        @foreach($apartmentList as $apartment)
						<tr id="trme">
							<input type="hidden" name="data[{{$apartment->id}}][id]" value="{{$apartment->id}}" id="checkApt" />
							<td><span class="aid" id="aid"><input type="checkbox" name="apt[]" value="{{$apartment->id}}"  class="aids" id="checkApt"></td></span>
							<td>
								<input type="hidden" class="capt" value="{{$apartment->id}}" id="checkApt" />
								<span class="aptst" id="aptst">{{ $apartment->street }}</span>
							</td>
							<td>
								<input type="hidden" class="capt" value="{{$apartment->id}}" id="checkApt" />
								<span class="aptnum" id="aptnum">{{ $apartment->apartment_number }}</span>
							</td>
							<td>
								<input type="hidden" class="capt" value="{{$apartment->id}}" id="checkApt" />
								<span id="aptprice" class="aptprice">{{ number_format($apartment->price, 2) }}</span>
							</td>
							<td>
								<input type="hidden" class="capt" value="{{$apartment->id}}" id="checkApt" />
								<span id="aptbed" class="aptbed">{{$apartment->bedrooms}}</span>
							</td>
							<td>
								<input type="hidden" class="capt" value="{{$apartment->id}}" id="checkApt" />
								<span id="aptbath" class="aptbath">{{$apartment->bathrooms}}</span>
							</td>
							<td>
								<input type="hidden" class="capt" value="{{$apartment->id}}" id="checkApt" />
								<span id="aptdate" class="aptdate">{{ date('M d, Y', strtotime($apartment->created_at))}}</span>
							</td>
							<td>
								<input type="hidden" class="capt" value="{{$apartment->id}}" id="checkApt" />
								<input type="hidden" class="nid" name="data[{{$apartment->id}}][area1]" value="{{$apartment->neighborhood->id ?? ''}}" />
								<span id="aptneigh" class="aptneigh">{{ $apartment->neighborhood->neighborhood ?? '' }}</span>
							</td>
							<td><a class="btn btn-outline-success" href="{{ route('agent.listings.edit', $apartment->id) }}">Edit</a></td>
						</tr>
						@endforeach
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>

@foreach (['info'] as $msg)
    @if(Session::has($msg))
		<script>
		$(function() {
		    var elementList = document.getElementById("lg");
			var elementGrid = document.getElementById("gl");
			var elementGridmenu = document.getElementById("glmenu");
			var elementGridPage = document.getElementById("glpage");
				elementList.style.display ="block";
				elementGrid.style.display ="none";
				elementGridmenu.style.display ="none";
				elementGridPage.style.display = "none";
		});
		</script>
	@endif
@endforeach

<script>
$(document).ready(function() {
	$('#example').dataTable({
	  	"pageLength": 50
	});
});
// Get the elements with class="column"
var elementList = document.getElementById("lg");
var elementGrid = document.getElementById("gl");
var ev = document.getElementById("editView");
var sv = document.getElementById("sortView");
var elementGridmenu = document.getElementById("glmenu");
var elementGridPage = document.getElementById("glpage");

// Declare a loop variable
var i;

// List View
function listView() {
	elementList.style.display ="block";
	elementGrid.style.display ="none";
	elementGridmenu.style.display ="none";
	elementGridPage.style.display = "none";
}

function editView(){
	// console.log($('#aptst').html());
 //    var num = 0;
	$('tr td').each(function () {
        var aid = $(this).find('.capt').val();
        var street = $(this).find('.aptst').html();
        var number = $(this).find('.aptnum').html();
        var price = $(this).find('.aptprice').html();
        var bed = $(this).find('.aptbed').html();
        var bath = $(this).find('.aptbath').html();
        var date = $(this).find('.aptdate').html();
        var neigh = $(this).find('.aptneigh').html();
        var nid = $(this).find('.nid').html();
        var streettext = $('<input type="text" value="'+street+'" name="data['+aid+'][street]" />');
        var numbertext = $('<input type="text" value="'+number+'" name="data['+aid+'][aptnumber]" size="7" maxlength="10" />');
        var pricetext = $('<input type="text" value="'+price+'" name="data['+aid+'][price]" size="6"  />');
        var bedtext = $('<input type="text" value="'+bed+'" name="data['+aid+'][bedrooms]" size="4" maxlength="6" />');
        var bathtext = $('<input type="text" value="'+bath+'" name="data['+aid+'][bathrooms]" size="4" />');
        var datetext = $('<input type="text" value="'+date+'" name="data['+aid+'][date]"  />');
        var neightext = $('<input type="text" value="'+neigh+'" name="data['+aid+'][area]"  />');
        var phpselect = '<select name="data['+aid+'][area]"><option value="'+nid+'">'+neigh+'</option><?php foreach($neighbourhood as $listneighbourhood){
        					echo "<option value=".$listneighbourhood->id.">".$listneighbourhood->neighborhood."</option>";
        				}; ?></select></td>';
        // input.val(street);
        // console.log(input);
        // console.log($('.checkApt').html());
        // console.log($('.aptst').html());
        // console.log(attr);
        // input.val(html);
        // input.attr('name', num);
        $(this).find('.aptst').html(streettext);
        $(this).find('.aptnum').html(numbertext);
        $(this).find('.aptprice').html(pricetext);
        $(this).find('.aptbed').html(bedtext);
        $(this).find('.aptbath').html(bathtext);
        $(this).find('.aptdate').html(datetext);
        $(this).find('.aptneigh').html(phpselect);
        //num++;
    });
    $("span").removeClass('aptst');
    $("span").removeClass('aptnum');
    $("span").removeClass('aptprice');
    $("span").removeClass('aptbed');
    $("span").removeClass('aptbath');
    $("span").removeClass('aptdate');
    $("span").removeClass('aptneigh');
	// ev.style.display = "block";
	// sv.style.display = "none";
}

function sortView(){
	ev.style.display = "none";
	sv.style.display = "block";
}

// Grid View
function gridView() {
	elementList.style.display ="none";
	elementGrid.style.display ="flex";
	elementGridmenu.style.display ="flex";
	elementGridPage.style.display = "flex";
}

/* Optional: Add active class to the current button (highlight it) */
var container = document.getElementById("btnContainer");
var btns = container.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
$('#checkAll').click(function () {    
     $('input:checkbox').prop('checked', this.checked);    
 });



</script>
@endsection
