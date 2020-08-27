@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="container-fluid text-white">
    <div class="row">
        <div class="col-md-12">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has($msg))
                    <div class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="row  mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-2 text-white">Users</h1>        
        </div>
    </div>

    <div class="card shadow mb-4 text-gray-800">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Active Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table agent-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th class="text-center">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agents as $agent)
                        <tr>
                            <td>{{ $agent->id }}</td>
                            <td>
                                <strong style="font-size: 18px;"><a href="#">{{ $agent->firstname . " " . $agent->lastname }}</a></strong>
                            </td>
                            <td>{{ $agent->company ?? '---' }}</td>
                        </tr>
                        @endforeach  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')

<script>
    $(document).ready(function() {
        $('.agent-table').DataTable({
            "pageLength": 100,
            "aaSorting": [],
        });
    });
</script>
@endsection