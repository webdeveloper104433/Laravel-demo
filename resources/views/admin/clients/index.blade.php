@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('Clients') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/clients/create') }}" class="btn btn-primary">Create</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>#Users</th>
                                <th>#Devices</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($clients)
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->description }}</td>
                                        <td>{{ $client->users()->count() }}</td>
                                        <td>{{ $client->devices()->count() }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/clients/' . $client->id . '/edit/is_users_of_client_tab_active') }}" class="btn btn-primary">Edit</a>
                                              <button type="button" data-id="{{ $client->id }}" class="btn btn-danger btn-client-delete">Delete</button>
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

<form id="client_delete_form" data-current_url="{{ url('admin/clients') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/admin/clients/index.js') }}"></script>
@endpush
