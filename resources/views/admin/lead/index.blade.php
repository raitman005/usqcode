@extends('admin.layouts.app')
@section('title', 'Followup Leads')
@section('content')
<style>
    .input-group-append button {
        color: #FFF;
        border: 1px solid #FFF !important;
    }
    .input-group-append button:hover {
        color: #EEE !important;
        border: 1px solid #FFF !important;
    }
</style>
<div class="container-fluid text-white">
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
        <div class="col-sm-3">
            <h1 class="h3 mb-2 text-white">Followup leads</h1>        
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-sm-12 text-white text-right">
            <form action="{{ route('admin.followup.leads') }}" method="GET" id="frm-change-date" class="form-inline text-right ml-auto float-sm-right">
                <div class="form-group mx-sm-2 mb-2 btn-group btn-group btn-group-toggle" data-toggle="buttons">
                    <label class=" btn btn-outline-light {{ $dateType == 'date' ? 'active' : '' }}">
                        <input type="radio" name="date_type" class="radio-date-type" id="option1" autocomplete="off" value="date"  {{ $dateType == 'date' ? 'checked' : '' }}> Date
                    </label>
                    <label class=" btn btn-outline-light {{ $dateType == 'range' ? 'active' : '' }}">
                        <input type="radio" name="date_type" class="radio-date-type" id="option2" autocomplete="off" value="range" {{ $dateType == 'range' ? 'checked' : '' }}> Range
                    </label>
                </div>
                <div class="form-group mx-sm-2 mb-2 single-date {{ $dateType == 'range' ? 'd-none' : '' }}">
                    <input type="text" class="form-control form-control-sm form-sm txtbox-date" placeholder="Select a date" id="txtbox-date" name="date" value="{{ $date->format('Y-m-d') }}">
                </div>
                <div class="form-group mx-sm-2 mb-2 date-range {{ $dateType == 'range' ? '' : 'd-none' }}">
                    <input type="text" class="form-control form-control-sm form-sm txtbox-date" placeholder="From" id="txtbox-date-from" name="date_from" value="{{ $dateFrom->format('Y-m-d') }}">
                </div>
                <div class="form-group mx-sm-2 mb-2 date-range {{ $dateType == 'range' ? '' : 'd-none' }}">
                    <input type="text" class="form-control form-control-sm form-sm txtbox-date" placeholder="To" id="txtbox-date-to" name="date_to" value="{{ $dateTo->format('Y-m-d') }}">
                </div>
                <button type="submit" class="btn btn-light mb-2 mr-2">Go</button>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addLeadModal">New Lead</button>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 text-gray-800">
        <a href="#divAssignment" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Agent Lead Assignment</h6>
        </a>
        <div class="collapse show" id="divAssignment">
            <div class="card-body">
                <h4 class="mb-4"></h4>
                <div class="table-responsive">
                    <table class="table tbl-lead-assignment" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Agent</th>
                                <th>Lead</th>
                                <th>Rank</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($followupQueues as $followupQueue)
                                @if ($followupQueue->followup_email_id)
                                    <tr>
                                        <td>{{ $followupQueue->id }}</td>
                                        <td>{{ $followupQueue->user->firstname ?? '' }} {{ $followupQueue->user->lastname ?? '' }}</td>
                                        <td>{{ $followupQueue->followup_email->subject }}</td>
                                        <td>{{ $followupQueue->followup_email->rank->rank }}</td>
                                        <td>{{ $followupQueue->state->state }}</td>
                                        <td>{{ \Carbon\Carbon::parse($followupQueue->updated_at)->format('h:i:s A') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 text-gray-800">
        <a href="#divLeads" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Leads</h6>
        </a>
        <div class="collapse show" id="divLeads">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-12 text-white text-right">
                        <ul class="nav nav-pills mb-3 float-right" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-lead-tab" data-toggle="pill" href="#all-lead" role="tab" aria-controls="all-lead" aria-selected="true">All Leads &nbsp;<span class="badge badge-danger">{{ $followupEmails->count() }}</span> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="no-resend-lead-tab" data-toggle="pill" href="#no-resend-lead" role="tab" aria-controls="no-resend-lead" aria-selected="false">Resend Excluded &nbsp;<span class="badge badge-danger">{{ $followupEmailsNoResend->count() }}</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="all-lead" role="tabpanel" aria-labelledby="all-lead-tab">
                        <div class="table-responsive">
                            <table class="table tbl-followup-lead" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subject</th>
                                        <th>Content</th>
                                        <th>Rank</th>
                                        <th>Status</th>
                                        <th>Resend</th>
                                        <th>Resend Tomorrow?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($followupEmails as $followupEmail)
                                        <tr>
                                            <td>{{ $followupEmail->id }}</td>
                                            <td>{{ $followupEmail->subject }}</td>
                                            <td><a href="{{ url('admin/leads/'.$followupEmail->id) }}">View</a></td>
                                            <td>{{ $followupEmail->rank->rank }}</td>
                                            <td>{{ $followupEmail->state->state }}</td>
                                            <td>{!! $followupEmail->resend_count > 0 ? '<span class="badge badge-primary">Yes</span>' : '<span class="badge badge-info">No</span>' !!}</td>
                                            <td>{!! $followupEmail->resend_count != $followupEmail->max_resend && $followupEmail->resend_count < $followupEmail->max_resend ? '<span class="badge badge-primary">Yes</span>' : '<span class="badge badge-info">No</span>' !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="no-resend-lead" role="tabpanel" aria-labelledby="no-resend-lead-tab">
                        <div class="table-responsive">
                            <table class="table tbl-followup-lead-no-resend" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subject</th>
                                        <th>Content</th>
                                        <th>Rank</th>
                                        <th>Status</th>
                                        <th>Resend</th>
                                        <th>Resend Tomorrow?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($followupEmailsNoResend as $followupEmail)
                                        <tr>
                                            <td>{{ $followupEmail->id }}</td>
                                            <td>{{ $followupEmail->subject }}</td>
                                            <td><a href="{{ url('admin/leads/'.$followupEmail->id) }}">View</a></td>
                                            <td>{{ $followupEmail->rank->rank }}</td>
                                            <td>{{ $followupEmail->state->state }}</td>
                                            <td>{!! $followupEmail->resend_count > 0 ? '<span class="badge badge-primary">Yes</span>' : '<span class="badge badge-info">No</span>' !!}</td>
                                            <td>{!! $followupEmail->resend_count != $followupEmail->max_resend && $followupEmail->resend_count < $followupEmail->max_resend ? '<span class="badge badge-primary">Yes</span>' : '<span class="badge badge-info">No</span>' !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 text-gray-800">
        <a href="#divLeads" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Lead Phone Number</h6>
        </a>
        <div class="collapse show" id="divLeadsPhoneNumber">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tbl-followup-lead-phone-number" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Phone Numbers</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($followupEmails as $followupEmail)
                                <tr>
                                    <td>{{ $followupEmail->id }}</td>
                                    <td>{{ $followupEmail->subject }}</td>
                                    <td><span style="white-space: pre-line">{{ $followupEmail->phone_numbers }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="addLeadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <form id="frm-new-lead" method="POST" action="{{ route('admin.lead.store') }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">New Lead</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="txtbox-subject">Lead Subject</label>
                        <input type="text" required class="form-control form-control-sm" id="txtbox-subject" name="subject">
                    </div>
                    <div class="form-group">
                        <label for="txtbox-content">Content</label>
                        <textarea name="content" id="txtarea-content" class="form-control form-control-sm" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Rank</label>
                        <select name="rank_id" id="dropdown-rank" required class="form-control form-control-sm">
                            @foreach ($ranks as $rank)
                                <option value="{{ $rank->id }}">{{ $rank->rank }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Resend Count</label>
                        <input type="text" class="form-control form-control-sm" id="exampleInputPassword1" name="max_resend" value="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save-new-lead">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('extra_scripts')


<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
<script>
    $(document).ready(function() {
        $.fn.dataTable.moment( 'h:mm:ss a' );
        
        $('.tbl-lead-assignment').DataTable({
            "aaSorting": []
        });
        $('.tbl-followup-lead-no-resend').DataTable({

        });
        $('.tbl-followup-lead').DataTable({
            "aaSorting": [],
        });
        $('.tbl-followup-lead-phone-number').DataTable({
            "aaSorting": [],
        });
    });

    $('#txtbox-date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
    });

    $('#txtbox-date-from').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
    });

    $('#txtbox-date-to').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
    });

    $(document).on('change', '.radio-date-type', function() {
        if ($(this).val() == "date") {
            $('.single-date').removeClass("d-none")
            $('.date-range').addClass("d-none")
        } else if ($(this).val() == "range") {
            $('.single-date').addClass("d-none")
            $('.date-range').removeClass("d-none")
        }

    });

    $(document).on('submit', '#frm-new-lead', function() {

        $('#btn-save-new-lead').prop('disabled',true);

        $.ajax({
            type: "POST",
            data: $('#frm-new-lead').serialize(),
            url: "{{ route('admin.lead.store') }}",
            beforeSend: function() {
                submitting = true;
            },
            success: function(data) {
                VanillaToasts.create({
                    title: 'Create Lead',
                    dataType: 'json',
                    text: 'Lead successfully created! <a href="/admin/followup/leads">Refresh</a>.',
                    type: 'success', 
                    timeout: 8000 
                });
                $('#btn-save-new-lead').prop('disabled',false);

            },
            error: function(xhr, status, error) {
                var error = "";
                for (var prop in xhr.responseJSON.errors) {
                    error = (xhr.responseJSON.errors[prop])
                }
                if(typeof error[0]  === 'undefined') {
                    error = "An error occured. Please check the fields and try again."
                }
                else {
                    error = error[0]
                }
                VanillaToasts.create({
                    title: 'Create Lead',
                    text: error,
                    type: 'error', 
                    timeout: 8000 
                });
                $('#btn-save-new-lead').prop('disabled',false);

            }
        })
        

        return false;
        
    })

    ClassicEditor
        .create( document.querySelector( '#txtarea-content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection