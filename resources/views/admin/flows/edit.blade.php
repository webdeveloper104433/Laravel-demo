@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link @if($is_flow_active) active @endif" id="flow_tab" href="#flow">Flow</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(!$is_flow_active) active @endif" href="#flow_entries">Flow Entries</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="flow" class="container tab-pane @if($is_flow_active) active @else fade @endif"><br>
                    <div class="card">
                        <div class="card-header">{{ __('Flows/Edit') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ url('admin/flows/' . $flow->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $flow->name }}" required autocomplete="name" autofocus placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description"  placeholder="Description">{{ $flow->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="layout" class="col-md-4 col-form-label text-md-right">{{ __('Layout') }}</label>

                                    <div class="col-md-6">
                                        <input id="layout" type="text" class="form-control @error('layout') is-invalid @enderror" name="layout" value="{{ $flow->layout }}" autocomplete="layout" autofocus placeholder="Layout ex: width: 100px;height: 100px;">
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                            <a href="{{ route('admin.flows') }}" class="btn btn-default">Back</a>
                                            <button class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="flow_entries" class="container tab-pane @if($is_flow_active) fade @else active @endif"><br>
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a id="btn_show_flow_entry_modal" href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Create</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>Sequence</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Time(Sec)</th>
                                <th>Run From</th>
                                <th>Run To</th>
                                <th>Dates</th>
                                <th>Client Name</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($flow->flow_entries)
                                @foreach ($flow->flow_entries as $flow_entry)
                                    <tr>
                                        <td>{{ $flow_entry->sequence }}</td>
                                        <td>{{ $flow_entry->flow_entriable_type }}</td>
                                        @if ($flow_entry->flow_entriable_type == "App\Schedule")
                                            <td>{{ $flow_entry->flow_entriable_id }}</td>
										@elseif ($flow_entry->flow_entriable_type == "App\Device")
											<td>{{ $flow_entry->flow_entriable->device_code }}</td>
                                        @else
                                            <td>{{ $flow_entry->flow_entriable->name }}</td>
                                        @endif
                                        <td>{{ $flow_entry->time }}</td>
                                        <td>{{ $flow_entry->run_from }}</td>
                                        <td>{{ $flow_entry->run_to }}</td>
                                        <td>{{ $flow_entry->dates }}</td>
                                        <td>{{ $flow_entry->user->first_name . ' ' . $flow_entry->user->last_name}}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="#" data-id="{{ $flow_entry->id }}" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-flow-entry-edit">Edit</a>
                                              <button type="button" data-id="{{ $flow_entry->id }}" class="btn btn-danger btn-flow-entry-delete">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                              @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Flow Entry</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <form id="flow_entry_form" method="POST" action="{{ url('admin/flows/' . $flow->id) }}" enctype="multipart/form-data">
        @csrf
            <!-- Modal body -->
            <div class="modal-body">

                <div class="form-group row">
                    <label for="sequence" class="col-md-4 col-form-label text-md-right">{{ __('Sequence') }}</label>

                    <div class="col-md-6">
                        <input id="sequence" type="text" class="form-control @error('sequence') is-invalid @enderror" name="sequence" value="" required autocomplete="sequence" autofocus placeholder="Sequence">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="flow_entriable_type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                    <div class="col-md-6">
                        <select name="flow_entriable_type" id="flow_entriable_type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="App\Image">Images</option>
                            <option value="App\Gallery">Galleries</option>
                            <option value="App\Site">Sites</option>
                            <option value="App\Schedule">Schedules</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="flow_entriable_id" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <select name="flow_entriable_id" id="flow_entriable_id" class="form-control">
                            <option value="">Select Name</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="time" class="col-md-4 col-form-label text-md-right">{{ __('Time(Sec)') }}</label>

                    <div class="col-md-6">
                        <input id="time" type="text" class="form-control @error('time') is-invalid @enderror" name="time" value="" required autocomplete="time" autofocus placeholder="Time(Sec)">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="run_from" class="col-md-4 col-form-label text-md-right">{{ __('Run From') }}</label>

                    <div class="col-md-6">
                        <input id="run_from" type="text" class="form-control @error('type') is-invalid @enderror datepicker" name="run_from" value="" required autocomplete="run_from" autofocus placeholder="Run From">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="run_to" class="col-md-4 col-form-label text-md-right">{{ __('Run To') }}</label>

                    <div class="col-md-6">
                        <input id="run_to" type="text" class="form-control @error('type') is-invalid @enderror datepicker" name="run_to" value="" required autocomplete="run_to" autofocus placeholder="Run To">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dates" class="col-md-4 col-form-label text-md-right">{{ __('Dates') }}</label>

                    <div class="col-md-6">
                        <input id="dates" type="text" class="form-control @error('type') is-invalid @enderror multidatepicker" name="dates" value="" required autocomplete="dates" autofocus placeholder="Dates">
                    </div>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" id="btn_flow_entry_save" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>

<form id="flow_entry_delete_form" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/admin/flows/edit.js') }}"></script>
@endpush