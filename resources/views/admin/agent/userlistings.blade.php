@extends('admin.layouts.app')
@section('title', 'User Listings')
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
            <h1 class="h3 mb-2 text-white">User listings</h1>        
        </div>
    </div>

    <div class="card shadow mb-4 text-gray-800">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%; min-height:250px;">
                    <thead>
                        <tr>
                            <th>User</th>
			                <th>Address</th>
			                <th>Apt#</th>
			                <th>Price</th>
			                <th>Bedroom</th>
			                <th>Bathroom</th>
			                <th>Date Listed</th>
			                <th>Area</th>
			            </tr>
                    </thead>
                    <tbody>
                        @foreach($apartmentList as $apartment)
						<tr id="trme">
                            <td>{{ $apartment->lastname }}, {{ $apartment->firstname }}</td>
                            <td>
								<span class="aptst" id="aptst">{{ $apartment->street }}</span>
							</td>
							<td>
								<span class="aptnum" id="aptnum">{{ $apartment->apartment_number }}</span>
							</td>
							<td>
								<span id="aptprice" class="aptprice">{{ number_format($apartment->price, 2) }}</span>
							</td>
							<td>
								<span id="aptbed" class="aptbed">{{$apartment->bedrooms}}</span>
							</td>
							<td>
								<span id="aptbath" class="aptbath">{{$apartment->bathrooms}}</span>
							</td>
							<td>
								<span id="aptdate" class="aptdate">{{ date('M d, Y', strtotime($apartment->created_at))}}</span>
							</td>
							<td>
								<span id="aptneigh" class="aptneigh">{{ $apartment->neighborhood->neighborhood ?? '' }}</span>
							</td>
						</tr>
						@endforeach
                    </tbody>
                </table>
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



</script>
@endsection
