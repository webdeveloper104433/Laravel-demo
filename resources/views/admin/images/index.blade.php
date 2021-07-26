@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('Images') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/images/create') }}" class="btn btn-primary">Create</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($images)
                                @foreach ($images as $image)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $image->name }}</td>
                                        <td>
                                            <img src="{{ asset('storage') . '/' . $image->url }}" class="rounded table-image-size" alt="{{ $image->url }}">
                                        </td>
                                        <td>{{ $image->description }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/images/' . $image->id . '/edit') }}" class="btn btn-primary">Edit</a>
                                              <button type="button" data-id="{{ $image->id }}" class="btn btn-danger btn-image-delete">Delete</button>
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

<form id="image_delete_form" data-current_url="{{ url('admin/images') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')

    <script type="text/javascript" src="{{ asset('js/admin/images/index.js') }}"></script>
    
@endpush
