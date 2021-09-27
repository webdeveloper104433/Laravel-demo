@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Devices') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>Code</th>
                                <th>Active</th>
                                <th>Last Access</th>
                                <th>Configuration</th>
                                <th>Description</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($devices)
                                @foreach ($devices as $device)
                                    <tr>
                                        <td>{{ $device->device_code }}</td>
                                        <td>@if ($device->enabled) Enabled @else Disabled @endif</td>
                                        <td>{{ $device->timestamp_last_accessed }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($device->configuration, 20, $end='...') }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($device->description, 20, $end='...') }}</td>
                                        <td>
											<div class="btn-group btn-group-sm">
												<a href="{{ url('admin/devices/' . $device->id . '/edit') }}" class="btn btn-primary">Edit</a>
												<button type="button" data-id="{{ $device->id }}" class="btn btn-danger btn-device-delete">Delete</button>
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

<form id="device_delete_form" data-current_url="{{ url('admin/devices') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/admin/devices/index.js') }}"></script>
@endpush
