@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('Schedules') }}</div>

                <div class="card-body">
                    <div class="clearfix">
                        <div class="row float-right ">
                            <div class="form-group col-md-12">
                                <a href="{{ url('admin/schedules/create') }}" class="btn btn-primary">Create</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable ">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Line1</th>
                                <th>Line2</th>
                                <th>Line3</th>
                                <th>Image</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @isset($schedules)
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $schedule->date }}</td>
                                        <td>{{ $schedule->time }}</td>
                                        <td>{{ $schedule->name }}</td>
                                        <td>{{ $schedule->type }}</td>
                                        <td>{{ $schedule->line1 }}</td>
                                        <td>{{ $schedule->line2 }}</td>
                                        <td>{{ $schedule->line3 }}</td>
                                        <td>
                                            @if ($schedule->image)
                                                <img src="{{ asset('storage') . '/' . $schedule->image->url }}" class="rounded table-image-size" alt="{{ $schedule->image->url }}">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                              <a href="{{ url('admin/schedules/' . $schedule->id . '/edit') }}" class="btn btn-primary">Edit</a>
                                              <button type="button" data-id="{{ $schedule->id }}" class="btn btn-danger btn-schedule-delete">Delete</button>
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

<form id="schedule_delete_form" data-current_url="{{ url('admin/schedules') }}" method="POST" action="">
    @csrf
    @method('delete')
</form>
@endsection

@push('scripts')

    <script type="text/javascript" src="{{ asset('js/admin/schedules/index.js') }}"></script>
    
@endpush
