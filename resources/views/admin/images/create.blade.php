@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Images/Create') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.images') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- <div class="clearfix">
                            <div class="row float-right ">
                                <div class="form-group col-md-12">
                                    <a href="{{ route('admin.images') }}" class="btn btn-default">Back</a>
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required autocomplete="name" autofocus placeholder="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input type="file" name="file">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description"  placeholder="description"></textarea>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('admin.images') }}" class="btn btn-default">Back</a>
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
