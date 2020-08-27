@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
    .top-paginate ul.pagination {
        float:right;
    }
    span.hl {
        font-weight: 600 !important;
        color: #e74a3b !important;
    }
    .small {
        font-size: 70% !important;
        font-weight: 300 !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has($msg))
                    <div class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h2 mb-2 text-white">Search Result</h1>       
            @if(strlen($keyword) >= 3) 
                <h5 class="h5 mb-2 text-white">{{ $countResults }} leads found for the keyword: <strong class="text-danger">{{ $keyword }}</strong>.</h5>        
            @else
            <h5 class="h5 mb-2 text-white">The keyword is too short. Please type at least 3 characters.</h5> 
            @endif
        </div>
        <div class="col-md-6 text-right pt-4 top-paginate">
            {{ $results->links() }}
        </div>
    </div>

    @foreach ($results as $result)
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card mb-2 border-left-primary">
                <div class="card-body">
                    <h5 class="text-primary">
                        <a href="{{ route('admin.lead.show', $result['id']) }}">
                            {!! $result['title'] !!} 
                        </a> 
                        @if ($result['rank'] == 'pro')
                            <span class="small badge badge-{{ $rankColor[$result['rank']] }}">{{ $result['rank'] }}</span>
                        @endif
                    </h5>
                    <p class="text-gray-600">
                        <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($result['datetime'])->diffForHumans() }} </span>
                    </p>
                    <p class="text-gray-800">{!! $result['body'] !!}
                        @if ($result['body_truncated'])
                            <a href="{{ route('admin.lead.show', $result['id']) }}">Read more...</a>
                        @endif
                        
                    </p>
                    <p class="text-gray-800">
                        Status: <span class="small badge badge-{{ $stateColor[$result['state']] }}">{{ $result['state'] }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="row mb-2">
        <div class="col-md-6">
            {{ $results->links() }}
        </div>
        <div class="col-md-6 text-light text-right">
            <p class="small">Retrieved from: {{ \Carbon\Carbon::today()->addDays(-5)->format('Y-m-d') }} - {{ \Carbon\Carbon::today()->format('Y-m-d') }}</p>   
        </div>
    </div>
</div>
@endsection

