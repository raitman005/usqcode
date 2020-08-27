@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Today's Leads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Helper::getTotalLeadsToday() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-filter fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Accepted Leads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Helper::getTotalAssignedLeadsToday() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-funnel-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Checked-in Agent</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $checkInUsersCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5 mb-5">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daily Lead Distribution</h6>
                </div>
                <div class="card-body">
                    <table class="table table-daily-lead">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Agent</th>
                                <th>Lead</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeQueue as $agent)
                                @if (isset($agent->followup_email->id))
                                    <tr>
                                        <td>{{ $agent->id }}</td>
                                        <td>{{ $agent->user->firstname . " " . $agent->user->lastname }}</td>
                                        <td>{{ $agent->followup_email->subject ?? '---'}}</td>
                                        <td>{{ $agent->state->state }}</td>
                                        <td>{{ $agent->updated_at->format('h:m a') }}</td>
                                        <td><a href="{{ route('admin.lead.show', $agent->followup_email->id) }}">View</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">On Queue</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($upcomingQueue as $key => $agent)
                            @if($agent->user->daily_throttle != 1)
                            <li class="list-group-item {{ $key == 0 ? 'border-left-primary' : '' }}">
                                @if ($key == 0) 
                                    <strong>{{ $agent->user->firstname . " " . $agent->user->lastname }}</strong>
                                @else
                                    {{ $agent->user->firstname . " " . $agent->user->lastname }}
                                @endif
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daily Agent Stats</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Agent</th>
                                <th>Email</th>
                                <th>Check in</th>
                                <th>Check out</th>
                                <th>Lead assigned</th>
                                <th>Lead declined</th>
                                <th>Lead expired</th>
                                <th>Throttled</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if (Helper::getCheckinTime($user)['created_at'] || Helper::getCheckoutTime($user)['created_at'])
                                    <tr>
                                        <td><a href="{{ route('admin.agent.show', $user->id) }}">{{ $user->firstname . " " . $user->lastname }}</a></td>
                                        <td>{{ $user->email ?? '---'}}</td>
                                        <td>{{ Helper::getCheckinTime($user)['updated_at'] ? \Carbon\Carbon::parse(Helper::getCheckinTime($user)['updated_at'])->format('Y-m-d h:i A') : '' }}</td>
                                        <td>{{ Helper::getCheckoutTime($user)['updated_at'] ? \Carbon\Carbon::parse(Helper::getCheckoutTime($user)['updated_at'])->format('Y-m-d h:i A') : '' }}</td>
                                        <td>{{ Helper::getTotalAssignedLeadsToday($user) }}</td>
                                        <td>{{ Helper::getTotalDeclinedLeadsToday($user) }}</td>
                                        <td>{{ Helper::getTotalExpiredLeadsToday($user) }}</td>
                                        <td>{!! $user->daily_throttle == 1 ? '<span class="fa fa-check"></span>' : '<span class="fa fa-times"></span>' !!}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
<script>
    $(document).ready(function() {
        $.fn.dataTable.moment( 'h:mm a' );
        $('.table-daily-lead').DataTable({
            "aaSorting": [],
        });
    });
</script>
@endsection