@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('admin.layouts.messages')
            <div class="card">
                <div class="card-header">{{ __('Schedules/Edit') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('admin/schedules/' . $schedule->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
<!-- date -->
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="text" class="form-control @error('date') is-invalid @enderror datepicker" name="date" value="{{ $schedule->date }}" required autocomplete="date" placeholder="Date">
                            </div>
                        </div>
<!-- date -->
                        <div class="form-group row">
                            <label for="time" class="col-md-4 col-form-label text-md-right">{{ __('Time') }}</label>

                            <div class="col-md-6">
                                <input id="time" type="text" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ $schedule->time }}" required autocomplete="time" placeholder="Time">
                            </div>
                        </div>
<!-- name -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $schedule->name }}" required autocomplete="name" placeholder="Name">
                            </div>
                        </div>
<!-- type -->
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                            <div class="col-md-6">
                                <select name="type" class="form-control">
                                    <option>Select Type</option>
                                    <option @if ($schedule->type == "kids") selected @endif value="kids">Kids</option>
                                    <option @if ($schedule->type == "adults") selected @endif value="adults">Adults</option>
                                    <option @if ($schedule->type == "general") selected @endif value="general">General</option>
                                </select>
                            </div>
                        </div>
<!-- line1 -->
                        <div class="form-group row">
                            <label for="line1" class="col-md-4 col-form-label text-md-right">{{ __('Line1') }}</label>

                            <div class="col-md-6">
                                <input id="line1" line1="text" class="form-control @error('line1') is-invalid @enderror" name="line1" value="{{ $schedule->line1 }}" required autocomplete="line1" placeholder="Line1">
                            </div>
                        </div>

<!-- line2 -->
                        <div class="form-group row">
                            <label for="line2" class="col-md-4 col-form-label text-md-right">{{ __('Line2') }}</label>

                            <div class="col-md-6">
                                <input id="line2" line2="text" class="form-control" name="line2" value="{{ $schedule->line2 }}" autocomplete="line2" placeholder="Line2">
                            </div>
                        </div>
<!-- line3 -->
                        <div class="form-group row">
                            <label for="line3" class="col-md-4 col-form-label text-md-right">{{ __('Line3') }}</label>

                            <div class="col-md-6">
                                <input id="line3" line3="text" class="form-control" name="line3" value="{{ $schedule->line3 }}" autocomplete="line3" placeholder="Line3">
                            </div>
                        </div>
<!-- image -->
                        <div class="form-group row">
                            <label for="image_id" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <select name="image_id" id="image_id" class="form-control">
                                    <option>Select Image</option>
                                    @foreach ($images as $image)
                                        <option @if ($image->id == $schedule->image->id) selected @endif value="{{ $image->id }}">{{ $image->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('admin.schedules') }}" class="btn btn-default">Back</a>
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

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/admin/schedules/edit.js') }}"></script>
@endpush
