@extends('layouts.app')

@section('content')
    

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      @if (array_key_exists('google_images', $data))
        @foreach ($data['google_images'] as $key=>$google_images)
          @foreach ($google_images as $google_image)
            <div style="padding-top: 20px; @if (!(array_key_exists('title', $data) && $data['title'] == 'off')) height: 90vh; @else height: 100vh; @endif" class="item @if ($loop->index == 0) active @endif">
                <!-- <div> -->
                  <img src="{{ $google_image->url }}" style="max-height: 100%; border: 2px solid #544949; margin-top: -5px;" >
              <!-- </div> -->
            </div>
          @endforeach
        @endforeach
      @endif

      @if (array_key_exists('site', $data))
        @foreach ($data['sites'] as $key=>$site)
          <div style="padding-top: 20px; @if (!(array_key_exists('title', $data) && $data['title'] == 'off')) height: 90vh; @else height: 100vh; @endif" class="item @if ($loop->index == 0)  @endif">
              <!-- <div> -->
                <iframe style="width: 100%; height: 100%;" src="{{ $site->url }}"></iframe>
            <!-- </div> -->
          </div>
        @endforeach
      @endif
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev" style="background-image: none;">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next" style="background-image: none;">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>

@endsection