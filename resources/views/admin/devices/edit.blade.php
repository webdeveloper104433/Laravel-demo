@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('Devices/Edit') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('admin/devices/' . $device->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group row">
                            <label for="device_code" class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>

                            <div class="col-md-6">
                                <input id="device_code" type="text" class="form-control @error('device_code') is-invalid @enderror" name="device_code" value="{{ $device->device_code }}" required autocomplete="device_code" autofocus placeholder="Code">
                            </div>
                        </div>
							<div class="form-group row">
								<label for="client_id" class="col-md-4 col-form-label text-md-right">{{ __('Client') }}</label>

								<div class="col-md-6">
									
									<select class="form-control" @if(auth()->user()->type != "super_admin") @if (!empty($device->client_id) && $device->client_id != auth()->user()->client_id) disabled @endif @endif id="client_id" name="client_id">
										<option>Select Client</option>
										@foreach ($clients as $client)
										<option value="{{ $client->id }}" @if ($device->client_id == $client->id) selected @endif>{{ $client->name }}</option>
										@endforeach
									</select>
								</div>
							</div>

                        <div class="form-group row">
                            <label for="enabled" class="col-md-4 col-form-label text-md-right">{{ __('Active') }}</label>

                            <div class="col-md-6">
                                <select name="enabled" id="enabled" class="form-control">
                                    <option value="1" @if ($device->enabled == 1) selected @endif >Enabled</option>
                                    <option value="0" @if ($device->enabled == 0) selected @endif>Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="timestamp_last_accessed" class="col-md-4 col-form-label text-md-right">{{ __('Last Access') }}</label>

                            <div class="col-md-6">
                                <input id="timestamp_last_accessed" type="text" disabled class="form-control @error('timestamp_last_accessed') is-invalid @enderror" name="timestamp_last_accessed" value="{{ $device->timestamp_last_accessed }}" autocomplete="timestamp_last_accessed" autofocus>
                            </div>
                        </div>
						
						
						<div class="form-group row">
                            <label for="ip_address_of_last_access" class="col-md-4 col-form-label text-md-right">{{ __('IP Address Of Last Access') }}</label>
                            <div class="col-md-6">
                                <input id="ip_address_of_last_access" type="text" disabled class="form-control @error('device_down_time') is-invalid @enderror" value="{{ $device->ip_address_of_last_access }}" autofocus>
                            </div>
                        </div>
						@if (auth()->user()->type != "super_admin")
							<div class="form-group row">
								<label for="timestamp_registered" class="col-md-4 col-form-label text-md-right">{{ __('Timestamp Registered') }}</label>
								<div class="col-md-6">
									<input id="timestamp_registered" name="timestamp_registered" type="text" disabled class="form-control" value="{{ $device->timestamp_registered }}" autofocus>
								</div>
							</div>

							<div class="form-group row">
								<label for="device_up_time" class="col-md-4 col-form-label text-md-right">{{ __('Device Up Time') }}</label>
								<div class="col-md-6">
									<input id="device_up_time" name="device_up_time" type="text" class="form-control" value="{{ $device->device_up_time }}" autofocus>
								</div>
							</div>

							<div class="form-group row">
								<label for="device_down_time" class="col-md-4 col-form-label text-md-right">{{ __('Device Down Time') }}</label>
								<div class="col-md-6">
									<input id="device_down_time" name="device_down_time" type="text" class="form-control" value="{{ $device->device_down_time }}" autofocus>
								</div>
							</div>
						
							<div class="form-group row">
								<label for="device_heartbeat_minutes" class="col-md-4 col-form-label text-md-right">{{ __('Device Heartbeat Minutes') }}</label>
								<div class="col-md-6">
									<input id="device_heartbeat_minutes" name="device_heartbeat_minutes" type="text" class="form-control" value="{{ $device->device_heartbeat_minutes }}" autofocus>
								</div>
							</div>
						
							<div class="form-group row">
								<label for="configuration" class="col-md-4 col-form-label text-md-right">{{ __('Configuration') }}</label>
								<div class="col-md-6">
									<textarea id="configuration" name="configuration" type="text" class="form-control" autofocus>{{ $device->configuration }}</textarea>
								</div>
							</div>
						@endif
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('admin.devices') }}" class="btn btn-default">Back</a>
                                    <button class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
