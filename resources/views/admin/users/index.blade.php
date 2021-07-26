@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/users/create') }}" class="btn btn-primary">Create</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Gmail</th>
                                <th>Phone Number</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($users)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>@if ($user->gender == 0) {{ "Male" }} @else {{ "Female" }} @endif</td>
                                        <td>@if ($user->status == 0) {{ "Inactive" }} @else {{ "Active" }} @endif</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/users/' . $user->id . '/edit') }}" class="btn btn-primary">Edit</a>
                                              <button type="button" data-id="{{ $user->id }}" class="btn btn-danger btn-user-delete">Delete</button>
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

<form id="user_delete_form" data-current_url="{{ url('admin/users') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')

    <script type="text/javascript" src="{{ asset('js/admin/users/index.js') }}"></script>
    
@endpush
