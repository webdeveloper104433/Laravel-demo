@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link @if(!$is_users_of_client_active) active @endif" href="#client">Client</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link @if($is_users_of_client_active) active @endif" id="users_of_client_tab" href="#users_of_client">Users of client</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="client" class="container tab-pane @if(!$is_users_of_client_active) active @else fade @endif"><br>
                    <div class="card">
                        <div class="card-header">{{ __('Clients/Edit') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ url('admin/clients/' . $client->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
<!-- name -->
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $client->name }}" required autocomplete="name" autofocus placeholder="Name">
                                    </div>
                                </div>
        <!-- description -->
                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus placeholder="Description">{{ $client->description }}</textarea>
                                    </div>
                                </div>

        <!-- address -->
                                <div class="form-group row">
                                    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $client->address }}" required autocomplete="address" autofocus placeholder="Address">
                                    </div>
                                </div>
        <!-- status -->
                                <div class="form-group row">
                                    <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                                    <div class="col-md-6">

                                        <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" autocomplete="status" autofocus>
                                            <option value="0" @if (!$client->status) selected @endif>Inactive</option>
                                            <option value="1" @if ($client->status) selected @endif>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                            <a href="{{ route('admin.clients') }}" class="btn btn-default">Back</a>
                                            <button class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="users_of_client" class="container tab-pane @if($is_users_of_client_active) active @else fade @endif"><br>
					<div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a id="btn_show_user_modal" href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Create</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>eMail</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
								<th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->users as $user)
                                    <tr>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>@if($user->status) Active @else Inactive @endif</td>
										<td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="#" data-id="{{ $user->id }}" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-user-edit">Edit</a>
                                              <button type="button" data-id="{{ $user->id }}" class="btn btn-danger btn-user-delete">Delete</button>
                                            </div>
                                        </td>
                                        
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

<!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">User</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <form method="POST" id="user_form" data-current-url="{{ url('admin/clients/' . $client->id) }}" action="{{ url('admin/clients/' . $client->id) }}">
            @csrf
            <!-- Modal body -->
            <div class="modal-body">
                <!-- first name -->
                <div class="form-group row">
                    <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                    <div class="col-md-6">
                        <input id="first_name" type="text" class="is-disabled form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="First Name">
                    </div>
                </div>
                <!-- last name -->
                <div class="form-group row">
                    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
					<div class="col-md-6">
                        <input id="last_name" type="text" class="is-disabled form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="Last Name">
                    </div>
                </div>

                <!-- username -->
                <div class="form-group row">
                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                    <div class="col-md-6">
                        <input id="username" type="text" class="is-disabled form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="is-disabled form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-Mail Adress">
                    </div>
                </div>
                <!-- phone number -->
                <div class="form-group row">
                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                    <div class="col-md-6">
                        <input id="phone" type="text" class="is-disabled form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus placeholder="Phone Number">
                    </div>
                </div>
                <!-- gender -->
                <div class="form-group row">
                    <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                    <div class="col-md-6">

                        <select id="gender" class="is-disabled form-control @error('gender') is-invalid @enderror" name="gender" autocomplete="gender" autofocus>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                        </select>
                    </div>
                </div>
                <!-- status -->
                <div class="form-group row">
                    <label for="user_status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                    <div class="col-md-6">

                        <select id="user_status" class="form-control @error('user_status') is-invalid @enderror" name="status" autocomplete="user_status" autofocus>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
                <hr class="is-hide">
                <div class="form-group row is-hide">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="is-hide form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password">
                    </div>
                </div>

                <div class="form-group row is-hide">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button id="btn_user_save" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
	</div>
</div>

<form id="user_delete_form" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/admin/clients/edit.js') }}"></script>
@endpush
