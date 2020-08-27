@extends('admin.layouts.app')
@section('title', 'Lead Details')
@section('content')
<div class="container-fluid">
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

    <div class="row mb-3">
        <div class="col-sm-6 text-light">
            <h1 class="h3 mb-2 text-white">{{ $followupEmail->subject }}</h1> 
        </div>
        <div class="col-md-6 text-light text-right">
            @if ($followupEmail->resend_count != $followupEmail->max_resend && $followupEmail->resend_count < $followupEmail->max_resend)
                <a class="btn btn-secondary" onclick="return confirm('Are you sure?')" href="{{ route('admin.lead.resend.disable', $followupEmail->id) }}">Disable resending</a>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div  class="d-block card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Lead Details</h6>
                </div>
                <div >
                    <div class="card-body ">
                        <ul class="list-group">
                            <li class="list-group-item">Status <span class="float-right">{{ $followupEmail->state->state }}</span></li>
                            <li class="list-group-item">Rank <span class="float-right">{{ $followupEmail->rank->rank }}</span></li>
                            <li class="list-group-item">Created at <span class="float-right">{{ \Carbon\Carbon::parse($followupEmail->created_at)->format('Y-m-d') }}</span></li>
                            <li class="list-group-item">Updated at <span class="float-right">{{ \Carbon\Carbon::parse($followupEmail->updated_at)->format('Y-m-d') }}</span></li>
                            <li class="list-group-item">Resendable <span class="float-right">{{ $followupEmail->resend_count > 0 ? 'Yes' : 'No' }}</span></li>
                            <li class="list-group-item">Resend tomorrow <span class="float-right">{{ $followupEmail->resend_count != $followupEmail->max_resend && $followupEmail->resend_count < $followupEmail->max_resend ? 'Yes' : 'No' }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            @if ($assignedAgents->count() > 0)
            <div class="card shadow mb-4">
                <div  class="d-block card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Lead Assignment</h6>
                </div>
                <div >
                    <div class="card-body ">
                        <ul class="list-group">
                            @foreach ($assignedAgents as $key => $assignedAgent)
                            <li class="list-group-item">{{ $assignedAgent->user->email }} 
                            @if ($key == 0)
                                <span class="badge badge-primary">First</span>
                            @else
                                <span class="badge badge-warning">Resend</span>
                            @endif
                            <span class="float-right">{{ \Carbon\Carbon::parse($assignedAgent->updated_at)->format('Y-m-d h:i A') }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            <div class="card shadow mb-4">
                <div  class="d-block card-header py-3" >
                    <h6 class="m-0 font-weight-bold text-primary">Lead Content</h6>
                </div>
                <div >
                    <div class="card-body  text-center">
                    {!! $followupEmail->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
