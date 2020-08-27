@extends('frontpage.layouts.app')
@section('title', 'Apartments for Rent in Manhattan')
@section('content')
<div class="s002">
	<form method="GET" action="{{ route('listing.search.ui') }}" onsubmit="return addNeighborhoods()" id="frm-search">
		<div class="py-3 title-div" style="">
			<h3 class="header-text">
				Rent in Manhattan
			</h3>
			<p class="sub-header-text">Hate fees? We do too. Welcome home to your no fee rental</p>
		</div>
		<div class="inner-form">
			<div class="input-field first-wrap neighborhood-wrap" data-toggle="modal" data-target="#neighborhoodModal">
				<div class="icon-wrap">
					<i class="fas fa-map-marker-alt"></i>
				</div>
				<input id="search-neighborhood" type="text" placeholder="Location"/>
			</div>

			<div class="input-field second-wrap">
				<div class="icon-wrap">
					<i class="fas fa-dollar-sign"></i>
				</div>
				<input id="min-price" name="min_price" type="text" placeholder="Min Price" />
			</div>
			<div class="input-field third-wrap">
				<div class="icon-wrap">
					<i class="fas fa-dollar-sign"></i>
				</div>
				<input id="max-price" name="max_price" type="text" placeholder="Max Price" />
			</div>
			<div class="input-field fouth-wrap">
				<div class="icon-wrap">
					<i class="fas fa-door-open"></i>
				</div>
				<select id="rooms" name="rooms" data-trigger="" name="choices-single-default">
					<option value="studio">Studio</option>
					<option value="studio/1">Studio/1 bed</option>
					<option value="1" >1 bed</option>
					<option value="2" >2 beds</option>
					<option value="3" >3 beds</option>
					<option value="4" >4 beds</option>
					<option value="5+" >5+ beds</option>
					<option value="all" selected >All</option>
				</select>
			</div>
			<div class="input-field fifth-wrap">
				<button class="btn-search" type="submit">SEARCH</button>
			</div>
		</div>
	</form>
</div>

<!-- Modal -->
<div class="modal" id="neighborhoodModal" tabindex="-1" role="dialog" aria-labelledby="neighborhoodModalTitle" aria-hidden="true" data-backdrop="false" data-keyboard='true'>
	<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row pt-3">
					<div class="col-lg-4">
						<div class="svg-map-wrapper">
							<svg
							xmlns:dc="http://purl.org/dc/elements/1.1/"
							xmlns:cc="http://creativecommons.org/ns#"
							xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
							xmlns:svg="http://www.w3.org/2000/svg"
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 541.5 843"
							height="100%" width="100%"
							version="1.1"
							id="svg3356">
								<metadata
									id="metadata3362">
								</metadata>
								<defs
									id="defs3360" />
								<path class="disabled" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4180"
									d="m 135.2637,6.7517323 c 0,0 10.74319,-7.64474211 36.19393,2.6248554 25.45074,10.2695973 51.34798,13.8416313 51.34798,13.8416313 l 0,69.208157 -87.54191,-0.184948 z"
									style="fill:#ffd5d5;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4182"
									d="m 135.07731,92.111679 0.20988,258.172351 84.41702,-1.34533 2.20987,-257.406811 z"
									style="fill:#ffe680;fill-rule:evenodd;stroke:#666666;stroke-width:0.9970727px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class=""
									id="path4184"
									d="m 221.54485,91.550092 56.17333,-1.348656 -3.96928,259.327104 -54.06138,-0.83469 z"
									style="fill:#5fd35f;fill-rule:evenodd;stroke:#666666;stroke-width:1.01479173px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="disabled" 
									id="path4186"
									d="m 277.72564,89.747351 2.23252,-65.636123 70.10116,-2.232522 12.05562,16.074153 c 0,0 13.39512,11.60911 9.37659,25.004237 -4.01854,13.395127 -16.07416,30.362288 -16.07416,30.362288 z"
									style="fill:#aaffee;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4188"
									d="m 261.65148,348.71981 3.57204,210.30349 -98.67744,1.33952 c 0,0 -1.78602,-20.5392 -7.14407,-23.21822 -5.35805,-2.67903 -12.94862,-4.46505 -12.94862,-4.46505 0,0 6.25106,-11.1626 -0.89301,-16.52065 -7.14407,-5.35805 -12.94862,-8.93009 -9.82309,-18.30668 3.12553,-9.37658 -1.33951,-10.7161 -0.44651,-22.77171 0.89301,-12.05562 -11.60911,-14.73464 -8.93008,-23.66473 2.67902,-8.93008 9.37659,-29.46928 9.37659,-36.16684 0,-6.69756 0,-66.97564 0,-66.97564 z"
									style="fill:#ae8881;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4210"
									d="m 262.09799,348.71981 102.69597,2.67902 c 0,0 -5.80455,123.23517 -5.80456,134.39778 0,8.79511 6.25107,32.59481 22.77173,48.22245 16.52065,15.62765 15.62764,28.12977 15.62764,28.12977 L 265.22352,558.5768 Z"
									style="fill:#00e2e2;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4212"
									d="m 166.54608,559.91631 c 0,0 -6.25106,10.2696 0.44651,19.19969 6.69756,8.93008 24.47647,32.46403 25.36948,45.85916 0.89301,13.39512 1.86727,15.31192 1.86727,15.31192 l 98.23094,-1.33952 c 0,0 -4.01854,-16.96716 -5.80456,-23.21822 -1.78602,-6.25106 -4.91155,-56.25953 -4.91155,-56.25953 z"
									style="fill:#afdde9;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4216"
									d="M 75.459216,-0.89300981 73.226695,490.26165"
									style="fill:none;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4218"
									d="m 72.333687,489.36864 c 0,0 -2.679026,-9.82309 -8.037077,-2.23252 -5.358051,7.59057 -12.948623,16.96716 -7.590572,20.9857 5.358051,4.01854 16.967161,-1.33951 19.199682,-3.12553 2.232522,-1.78602 2.232522,-4.01854 2.232522,-4.01854 l 98.677438,311.65996 c 0,0 -61.61759,11.60911 -58.49206,15.62765 3.12553,4.01854 30.8088,3.12553 43.31091,0.4465 12.50212,-2.67902 20.09269,-1.78601 20.9857,8.03708 0.89301,9.82309 0.44651,7.59057 0.44651,7.59057"
									style="fill:none;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4222"
									d="m 292.90678,638.50106 125.9142,-1.78602 c 0,0 -4.01854,-21.87871 -6.69757,-33.93432 -2.67902,-12.05561 -14.73464,-40.63189 -14.73464,-40.63189 l -116.5376,-3.12553 3.12553,36.61335 4.46504,31.2553 c 2.46966,8.77629 3.05095,8.1107 4.46504,11.60911 z"
									style="fill:#ffe680;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4224"
									d="m 193.47833,640.53741 c 0,0 -3.93728,8.4565 0.97427,18.27959 4.91154,9.82309 5.13479,16.29741 11.38585,18.52993 6.25106,2.23252 8.26033,1.56276 8.93009,9.82309 0.66975,8.26033 3.57203,10.49285 5.35805,16.96716 1.78602,6.47431 1.78602,17.63692 1.78602,17.63692 0,0 79.701,0 79.2545,-0.89301 -0.44651,-0.89301 -1.11626,-56.48279 -1.11626,-56.48279 0,0 -5.60839,-23.07622 -6.72465,-25.30874 -1.11626,-2.23252 -99.84787,1.44785 -99.84787,1.44785 z"
									style="fill:#aa87de;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4228"
									d="m 221.91261,721.55085 c 0,0 87.06832,-2.67903 91.53337,-0.44651 4.46504,2.23252 30.36228,12.50212 30.36228,12.50212 l -30.80879,81.63366 c 0,0 -57.59905,-3.94192 -62.51059,-14.65802 -4.91155,-10.7161 -10.7161,-45.09693 -15.62765,-53.58051 -4.91155,-8.48358 -13.02524,-25.36949 -13.02524,-25.36949 z"
									style="fill:#ffb380;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4230"
									d="m 301.04491,720.02465 12.15546,1.10505 30.62543,12.47118 c 0,0 6.31453,-9.78751 13.89196,-14.68127 7.57742,-4.89375 38.51859,-27.31031 41.99158,-30.7833 3.47299,-3.47299 17.20707,-14.83913 18.7857,-22.73228 1.57864,-7.89316 0.31573,-28.57322 0.31573,-28.57322 l -125.81688,1.89435 c 0,0 4.89376,28.57323 4.89376,29.52041 0,0.94718 3.15726,51.77908 3.15726,51.77908 z"
									style="fill:#ff9955;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="svgneighborhood" onmouseover="hoverNeighborhood(this.id)" onclick="selectArea(this.id)"
									id="path4232"
									d="m 364.34801,351.41435 c 0,0 15.47058,-134.18363 11.99759,-141.76106 -3.47299,-7.57742 -20.83793,-44.83311 -20.83793,-50.83191 0,-5.9988 9.78751,-17.04921 7.89316,-31.25689 -1.89436,-14.20768 -7.57743,-29.993988 -8.20888,-32.835524 -0.63146,-2.841535 -77.03719,-5.683071 -77.03719,-5.683071 l -4.42017,259.842645 z"
									style="fill:#ffaaaa;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="disabled"
									id="path4234"
									d="M 135.44653,6.9570896 135.28867,-0.14674926 344.45726,0.32684 c 0,0 1.57863,14.83913 3.78871,17.680666 2.21008,2.841535 2.21008,4.735892 2.21008,4.735892 l -70.72266,1.894357 -1.89436,65.355319 -55.88353,1.57863 1.26291,-67.565401 c 0,0 -29.04681,-5.683071 -41.04441,-10.418964 -11.99759,-4.7358923 -25.8682,-8.9748648 -33.15125,-8.2088803 -9.00586,0.9471786 -13.57622,1.5786309 -13.57622,1.5786309 z"
									style="fill:#ff9955;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="water"
									id="path4236"
									d="m 412.96984,843.31573 c 0,0 -31.88835,-32.20407 -29.36254,-55.56781 2.52581,-23.36374 -2.21008,-43.25449 10.73469,-59.0408 12.94478,-15.7863 47.99038,-41.0444 56.19926,-39.78149 8.20888,1.2629 21.15365,17.68066 24.94237,15.15485 3.78871,-2.52581 12.94477,-7.57743 10.73469,-14.83913 -2.21008,-7.2617 -10.73469,-27.15245 -7.57743,-27.15245 3.15726,0 21.15365,16.10204 23.36374,12.62905 2.21008,-3.47299 3.15726,-6.31452 3.15726,-6.31452 0,0 -35.67706,-24.31092 -42.62303,-47.0432 -6.94598,-22.73229 -14.20768,-92.8235 -19.2593,-100.40093 -5.05162,-7.57743 -15.78631,-29.99398 -13.89195,-36.30851 1.89435,-6.31452 11.36614,-29.04681 22.73228,-35.99278 11.36614,-6.94598 50.51619,-4.10444 60.93515,-0.63145 10.41897,3.47298 29.99399,13.89195 29.99399,13.89195 l -1.57863,-16.73349 c 0,0 -77.66864,-18.94357 -85.87752,-15.15486 -8.20888,3.78872 -15.47058,24.31092 -24.31092,23.67947 -8.84033,-0.63146 -11.99759,-8.84034 -15.47058,-11.68187 -3.47299,-2.84154 -6.94597,-26.521 -7.2617,-32.20407 -0.31573,-5.68307 5.36734,-12.31332 6.94598,-13.57623 1.57863,-1.2629 -7.57743,-5.36734 -5.36735,-11.68187 2.21008,-6.31452 1.57863,-33.7827 1.57863,-33.7827 0,0 3.78872,-99.13802 6.31453,-104.82109 2.5258,-5.68307 9.47178,-21.7851 9.47178,-21.7851 0,0 -11.05042,-7.89316 -14.83913,-18.94357 -3.78871,-11.05042 -2.21008,-29.99399 2.21008,-32.5198 4.42017,-2.52581 14.83913,-0.94718 18.62785,-5.68307 3.78871,-4.73589 19.57502,-26.83672 19.57502,-41.36013 0,-14.5234 3.78871,-87.771875 6.94598,-90.929137 3.15726,-3.157262 30.62544,-13.891952 41.67585,-11.366142 11.05042,2.525809 24.62664,10.103237 24.94237,23.679463 0.31573,13.576225 -1.89436,31.888343 2.21008,33.782701 4.10444,1.894357 7.57743,2.525809 6.31453,-4.104441 -1.26291,-6.630249 -4.42017,-17.996392 -1.89436,-27.152451 2.52581,-9.156059 8.20888,-20.522201 8.20888,-20.522201 L 541.5,0 344.14153,0.01111382 l 0,-0.31572617 c 0,0 1.89436,14.83913035 5.05162,20.83792735 3.15726,5.998797 12.94477,16.733487 17.04921,23.048011 4.10445,6.314523 5.68307,8.840333 5.68307,15.470582 0,6.63025 -16.89135,35.045605 -16.89135,35.045605 0,0 7.89315,27.152447 7.89315,33.151247 0,5.9988 -8.68246,24.78451 -7.10383,33.94057 1.57863,9.15605 13.89195,36.46637 13.89195,36.46637 l 6.63025,12.62905 -1.10505,30.30971 -10.89254,111.13561 -4.7359,95.98076 c 0,0 -2.67768,38.93434 1.26291,50.35833 6.09563,17.67157 12.58995,28.02843 16.41776,32.67765 4.13712,5.02489 15.47058,13.2605 17.36494,23.04801 1.89435,9.78751 16.73349,47.35893 16.73349,47.35893 0,0 6.94597,33.7827 7.2617,41.36013 0.31572,7.57743 -2.21009,24.94237 -6.31453,29.99399 -4.10444,5.05162 -22.10083,23.67945 -29.04681,28.09962 -6.94597,4.42017 -29.04681,15.31272 -37.88714,30.15185 -8.84033,14.83913 -21.31151,54.77849 -21.31151,54.77849 l -11.83973,29.36254 -21.94298,-2.68367 c 0,0 -31.29298,-2.38814 -37.88713,-12.15546 -8.1535,-12.07705 -7.24085,-22.24642 -12.47119,-38.51859 l -3.78871,-12.94477 -13.89195,-27.46818 c 0,0 0.31572,-8.52461 -0.94718,-13.57623 -1.26291,-5.05162 -5.36735,-14.83913 -5.36735,-14.83913 0,0 0,-12.31332 -2.84153,-12.94477 -2.84154,-0.63145 -11.9976,-6.78812 -11.9976,-6.78812 0,0 -7.89316,-17.52279 -8.20888,-21.62723 -0.31573,-4.10444 1.57863,-18.78572 1.57863,-18.78572 l -5.99879,-21.7851 c 0,0 -17.36494,-27.31032 -19.89075,-29.83612 -2.52581,-2.52581 -5.20948,-8.20889 -4.26231,-13.57623 0.94718,-5.36735 2.36795,-8.36675 2.68368,-11.83974 0.31573,-3.47298 -1.26291,-16.89134 -6.31453,-18.7857 -5.05162,-1.89436 -14.20767,-5.05162 -14.20767,-5.05162 0,0 6.31452,-8.20888 2.84153,-12.31332 -3.47299,-4.10444 -13.2605,-11.36614 -13.2605,-11.36614 0,0 -2.21008,-6.94598 0,-11.36614 2.21009,-4.42017 -0.94718,-14.20768 -0.94718,-14.20768 l -0.31572,-13.10264 -5.05162,-8.36674 -3.47299,-8.84034 7.89315,-26.52099 c 0.89456,-6.73549 0.69556,-2.53537 2.68368,-20.20648 L 136.39371,350.46716 135.44653,-0.30461235 74.511377,-0.62033853 72.932746,490.33386 c 0,0 -3.174213,-8.98125 -7.577428,-4.57803 -4.57803,4.57804 -12.374291,16.82245 -10.73469,21.94297 1.023831,3.19745 10.418964,3.94658 12.944774,2.9994 2.525809,-0.94718 11.050416,-7.89315 11.050416,-7.89315 l 64.092412,200.32825 32.83553,109.0834 c 0,0 -51.50307,11.64731 -54.30491,13.10263 -7.40298,3.84523 0.94718,4.73589 2.52581,5.36735 1.57863,0.63146 41.99158,-1.89436 47.0432,-2.52581 5.05162,-0.63145 10.73469,1.89435 11.68187,7.57742 0.94718,5.68307 0.53898,8.77495 0.53898,8.77495 l 231.20403,-0.88179 z"
									style="fill:#5599ff;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="disabled"
									id="path4238"
									d="m 433.17631,15.165971 c 0,0 -5.68307,-6.3145238 -17.68066,2.525809 -11.9976,8.840333 -19.57503,10.73469 -24.62665,8.208881 -5.05161,-2.52581 -16.41776,-12.629047 -17.68066,0.631452 -1.26291,13.260499 4.42016,11.366142 6.94597,30.941165 2.52581,19.575023 13.2605,-13.260499 20.20648,-3.157262 6.94598,10.103238 -3.78871,17.049214 -10.73469,29.678261 -6.94598,12.629047 -12.62905,20.837923 -8.20888,32.835523 4.42017,11.99759 10.73469,24.62664 13.2605,25.25809 2.52581,0.63146 25.88954,-18.94357 29.67826,-25.88954 3.78871,-6.94598 6.94597,-22.100836 12.62905,-40.412954 5.68307,-18.312118 -3.78872,-60.619425 -3.78872,-60.619425 z"
									style="fill:#b7b7c8;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="disabled"
									id="path4240"
									d="m 72.780191,489.36864 c 0,0 -2.232521,-4.91154 -5.358051,-3.12553 -3.12553,1.78602 -12.725371,14.51139 -13.395127,17.63692 -0.669756,3.12553 1.562765,5.5813 1.562765,5.5813 0,0 8.930084,2.90228 11.60911,1.56277 2.679025,-1.33951 11.60911,-8.03708 11.60911,-8.03708 l 96.444912,309.20419 c 0,0 -59.35552,15.14413 -57.37579,14.73464 0.76513,-0.15826 -3.81819,0.31487 3.34878,2.90227 7.34954,2.65332 43.08766,-1.56276 48.44571,-1.33951 5.35805,0.22325 9.59984,10e-6 11.60911,4.2418 2.00927,4.24179 2.45577,11.38585 2.45577,11.38585 L -1.1162606,843.22325 0.22325212,-0.2232539 74.342956,-1.7791913e-6 Z"
									style="fill:#6f6f91;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="disabled"
									id="path4242"
									d="m 505.21955,668.41684 c 0,0 -2.71672,5.96344 -3.79529,6.25106 -3.34878,0.89301 -14.06488,-7.36732 -14.06488,-7.36732 0,0 -9.37659,-6.25106 -9.37659,-5.35805 0,0.89301 7.81382,26.567 7.81382,26.567 0,0 1.56277,2.00927 0.66976,4.91155 -0.89301,2.90228 -9.8231,10.93935 -11.60911,10.93935 -1.78602,0 -16.52066,-10.93935 -19.42294,-12.94862 -2.90227,-2.00927 -7.59057,-3.57203 -10.49285,-1.78602 -2.90227,1.78602 -26.12049,15.62765 -30.80879,20.31595 -4.68829,4.68829 -22.54846,20.53919 -24.33448,24.33448 -1.78602,3.79528 -6.02781,25.45074 -5.35805,29.91578 0.66976,4.46504 -1.56277,26.567 -1.11626,29.24603 0.4465,2.67902 4.46504,14.28814 4.46504,14.28814 l 12.72537,21.20895 13.17188,14.73464 128.36997,0 0.4465,-382.65413 -30.58554,-13.39513 -22.32522,-3.12553 c 0,0 -22.10196,0.4465 -25.89724,0.4465 -3.79529,0 -13.17187,4.01854 -13.17187,4.01854 l -10.71611,12.72537 -10.26959,22.10196 c 0,0 -0.89301,3.79529 0.4465,7.14407 1.33951,3.34878 2.90228,10.49285 2.90228,10.49285 l 10.7161,20.31594 3.57203,15.8509 14.95789,83.94279 7.14407,13.17188 19.42294,20.9857 z"
									style="fill:#beb7c8;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								<path class="disabled"
									id="path4244"
									d="m 541.60964,29.022773 c 0,0 -6.80919,17.413666 -7.14407,18.083422 -0.33487,0.669756 -2.34414,4.688294 -2.34414,8.260328 0,3.572034 1.89764,14.623014 1.89764,14.623014 0,0 2.12089,8.595207 1.33951,10.269598 -0.78138,1.674391 -1.67439,2.009269 -2.67902,1.897643 -1.00464,-0.111626 -4.79992,-1.674391 -4.79992,-1.674391 l -1.56277,-4.241791 0.33488,-20.985699 -0.11163,-11.05098 -4.24179,-9.711467 -11.1626,-7.92545 -13.17188,-3.795286 c 0,0 -11.05098,1.562765 -16.07415,3.12553 -5.02317,1.562764 -19.86944,7.255693 -19.86944,7.255693 l -2.5674,2.679026 -3.34878,30.697166 -2.79065,47.775951 c 0,0 -0.44651,17.30204 -0.78138,17.9718 -0.33488,0.66975 -7.2557,16.96716 -7.2557,16.96716 L 434.337,165.65307 c 0,0 -2.67903,3.12553 -4.57667,3.68366 -1.89764,0.55813 -10.93935,2.45577 -12.72537,2.90228 -1.78602,0.4465 -3.57204,2.45577 -3.79529,2.79065 -0.22325,0.33488 -2.90227,11.60911 -2.90227,11.60911 l 1.45113,16.52066 6.69757,12.50211 8.93008,8.37196 -9.48821,22.32521 -1.89765,17.07879 -4.24179,84.72418 c 0,0 -0.22325,28.46464 -0.66975,30.47391 -0.44651,2.00927 -1.56277,7.14407 -1.33952,7.59057 0.22326,0.44651 1.00464,4.46505 1.78602,5.35805 0.78138,0.89301 4.01854,4.13017 4.01854,4.13017 l -5.69293,7.92545 c 0,0 -1.67439,7.92545 -1.45114,8.59521 0.22325,0.66975 4.24179,22.21358 4.24179,22.21358 l 3.34878,7.92545 5.58131,6.80919 c 0,0 8.26033,4.6883 8.93008,4.6883 0.66976,0 6.02781,-1.67439 6.02781,-1.67439 l 10.49285,-13.84164 c 0,0 8.70683,-8.48358 9.48821,-8.93008 0.78139,-0.44651 11.49749,0.4465 11.49749,0.4465 l 18.75318,3.12553 28.91115,5.91618 26.12049,6.25106 z"
									style="fill:#beb7c8;fill-rule:evenodd;stroke:#666666;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />
								
								
									<text class="svgtext" onclick="selectTextArea('path4182')" id="text1" transform="matrix(2 0 0 2 140 240)" class="st6">UWS</text>
									<text class="svgtext" onclick="selectTextArea('path4232')" id="text2" transform="matrix(2 0 0 2 285 240)" class="st6">UES</text>
									<text class="svgtext" onclick="selectTextArea('path4188')" id="text3" transform="matrix(2 0 0 2 170 440)" class="st6">Mid</text>
									<text class="svgtext" onclick="selectTextArea('path4210')" id="text4" transform="matrix(2 0 0 2 275 440)" class="st6">Mid</text>
									<text class="svgtext" onclick="selectTextArea('path4188')" id="text5" transform="matrix(2 0 0 2 170 475)" class="st6">West</text>
									<text class="svgtext" onclick="selectTextArea('path4210')" id="text6" transform="matrix(2 0 0 2 275 475)" class="st6">East</text>
									<text class="svgtext" onclick="selectTextArea('path4212')" id="text7" transform="matrix(2 0 0 2 215 610)" class="st6">GV</text>
									<text class="svgtext" onclick="selectTextArea('path4222')" id="text8" transform="matrix(2 0 0 2 320 610)" class="st6">EV</text>
									<text class="svgtext" onclick="selectTextArea('path4224')" id="text9" transform="matrix(2 0 0 2 205 690)" class="st6">SOHO</text>
									<text class="svgtext" onclick="selectTextArea('path4230')" id="text10" transform="matrix(2 0 0 2 320 690)" class="st6">LES</text>
									<text class="svgtext" onclick="selectTextArea('path4228')" id="text11" transform="matrix(2 0 0 2 260 770)" class="st6">FiDi</text>
									<text class="svgtext"  id="text12" transform="matrix(2 0 0 2 430 360)" class="st6">QNS</text>
									<text class="svgtext"  id="text13" transform="matrix(2 0 0 2 430 780)" class="st6">BK</text>
									<text class="svgtext"  id="text14" transform="matrix(2 0 0 2 70 770)" class="st6">NJ</text>
							</svg>
						</div>
						<div class="row">
							<div class="col-md-12 text-center mt-2">
								<h5 id="neighborhood-caption">&nbsp;</h5>
							</div>

						</div>
					</div>
					<div class="col-lg-8">
						<div class="disabled">
							<div class="row mt-1">
								<div class="col-md-12">
									<div class="custom-control form-control-lg checkbox-wrapper checkbox-wrapper-title custom-checkbox mb-3">
										<input type="checkbox" class="custom-control-input chkbox-neighborhood-section" dropdown-data-group="3" name="neighbor" value="y" id="chkbox-neighborsection-3">
										<label class="label-checkbox-neighborhood custom-control-label custom-control-label-big" for="chkbox-neighborsection-3"> &nbsp;&nbsp;Uppertown Manhattan</label>
									</div>
								</div>
							</div>

							<div class="row mb-4">
								@foreach($upperManhattan as $upperNeighborhood)
									<div class="neighboor-checkbox-group col-sm-6">
										<div class="custom-control form-control-lg checkbox-wrapper custom-checkbox">
											<input type="checkbox" class="custom-control-input chkbox-neighborhoods" dropdown-group="3" name="neighbor" value="{{ $upperNeighborhood->id }}" id="chkbox-neighbor-{{ $upperNeighborhood->id }}" data-label="{{ $upperNeighborhood->neighborhood }}">
											<label class="label-checkbox-neighborhood custom-control-label" for="chkbox-neighbor-{{ $upperNeighborhood->id }}">{{ $upperNeighborhood->neighborhood }}</label>
										</div>
									</div>
								@endforeach
							</div>

							<hr>

							<div class="row mt-1">
								<div class="col-md-12">
									<div class="custom-control form-control-lg checkbox-wrapper checkbox-wrapper-title custom-checkbox mb-3">
										<input type="checkbox" class="custom-control-input chkbox-neighborhood-section" dropdown-data-group="2" name="neighbor" value="y" id="chkbox-neighborsection-2">
										<label class="label-checkbox-neighborhood custom-control-label custom-control-label-big" for="chkbox-neighborsection-2"> &nbsp;&nbsp;Midtown Manhattan</label>
									</div>
								</div>
							</div>

							<div class="row mb-4">
								@foreach($midtownManhattan as $midtownNeighborhood)
									<div class="neighboor-checkbox-group col-sm-6">
										<div class="custom-control form-control-lg checkbox-wrapper custom-checkbox">
											<input type="checkbox" class="custom-control-input chkbox-neighborhoods" dropdown-group="2" name="neighbor" value="{{ $midtownNeighborhood->id }}" id="chkbox-neighbor-{{ $midtownNeighborhood->id }}" data-label="{{ $midtownNeighborhood->neighborhood }}">
											<label class="label-checkbox-neighborhood custom-control-label" for="chkbox-neighbor-{{ $midtownNeighborhood->id }}"><span>{{ $midtownNeighborhood->neighborhood }}</span></label>
										</div>
									</div>
								@endforeach
							</div>

							<hr>
							
							<div class="row mt-1">
								<div class="col-md-12">
									<div class="custom-control form-control-lg checkbox-wrapper checkbox-wrapper-title custom-checkbox mb-3">
										<input type="checkbox" class="custom-control-input chkbox-neighborhood-section" dropdown-data-group="1" name="neighbor" value="y" id="chkbox-neighborsection-1">
										<label class="label-checkbox-neighborhood custom-control-label custom-control-label-big" for="chkbox-neighborsection-1"> &nbsp;&nbsp;Downtown Manhattan</label>
									</div>
								</div>
							</div>
							
							<div class="row mb-4">
								@foreach($downtownManhattan as $downtownNeighborhood)
									<div class="neighboor-checkbox-group col-sm-6">
										<div class="custom-control form-control-lg checkbox-wrapper custom-checkbox">
											<input type="checkbox" class="custom-control-input chkbox-neighborhoods" dropdown-group="1"  name="neighbor" value="{{ $downtownNeighborhood->id }}" id="chkbox-neighbor-{{ $downtownNeighborhood->id }}" data-label="{{ $downtownNeighborhood->neighborhood }}">
											<label class="label-checkbox-neighborhood custom-control-label" for="chkbox-neighbor-{{ $downtownNeighborhood->id }}">{{ $downtownNeighborhood->neighborhood }}</label>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer text-center">
				<div class="row">
					<div class="col-md-12">
						<button class="btn btn-sm btn-primary big" id="btn-modal-select" data-dismiss="modal">Select</button> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('extra_scripts')
<script>
	var pathMap = @json($neighborhoodPathId);
	var reversedPathMap = @json($neighborhoodIdPath);
	var pathMapNames = @json($neighborhoodPathName);
</script>
<script src="{{ asset('js/landingpage.js') }}"></script> 
@endsection
