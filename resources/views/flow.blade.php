@extends('layouts.app')


@push('styles')
  <link rel="stylesheet" href="{{ asset('css/pages/flow.css')}}">
  @if (array_key_exists("design", $data))
    <link rel="stylesheet" href="{{ asset('css') . '/' . $data['design'] . '.css' }}">
  @endif
@endpush
@section('content')
    
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="1000">
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      @if (array_key_exists('google_images', $data))
        @foreach ($data['google_images'] as $key=>$google_images)
          @foreach ($google_images as $google_image)
            <div style="padding: 20px; height: 100vh;" class="item" data-time="10">
              <h3 class="google-image-title">{{ $data['title']['google_images'][$key] }}</h3>
              <img src="{{ $google_image->url }}" class="google-image" >
            </div>
          @endforeach
        @endforeach
      @endif

      @if (array_key_exists('sites', $data))
        @foreach ($data['sites'] as $key=>$site)
          <div style="padding: 20px; @if (!(array_key_exists('title', $data) && $data['title'] == 'off')) height: 90vh; @else height: 100vh; @endif" class="item" data-time="{{ $data['time']['sites'][$key] }}">
              <!-- <div> -->
                <iframe class="site-iframe" src="{{ $site->url }}"></iframe>
            <!-- </div> -->
          </div>
        @endforeach
      @endif

      @if (array_key_exists('schedules', $data))
        @foreach ($data['schedules'] as $key=>$schedules)
          @for ($i = 1; $i <= ceil($schedules->count() / 4); $i ++)
            <div style="padding: 20px;" class="item" data-time="{{ $data['time']['schedules'][$key] }}">
                <!-- <div> -->
                  <div class="" style="padding: 10px;">
                    <!-- Wrapper for slides -->
                    <h1 class="schedule-title">Termine</h1>
                
                    <div class="table-responsive text-center" style="margin-top: 10px; width: 100%; border: 0px;">
                
                      <table class="schedule-content" cellspacing="10px">
                        <tbody>
                          @foreach ($schedules as $schedule)
                            @if ( $loop->index < (($i * 4) - 4) || $loop->index + 1 > ($i * 4)  )
                              @continue    
                            @endif

                            @if (($loop->index + 2) % 2 == 0)
                              <tr class="slide-tr slide-number-{{ ceil(($loop->index + 1) / 4) }}">
                            @endif
                                <td class="schedule-border @if (($loop->index + 2) % 2 == 0) left-background-color @else right-background-color @endif">
                                  <div>
                                    <img class="img-thumbnail @if (($schedules->count() == $loop->index + 1) && (($loop->index + 1) % 2 == 1) && (($loop->index + 1) % 4 == 1)) image-one-item @elseif ((($schedules->count() == $loop->index + 2) && (($loop->index + 2) % 4 == 2)) || (($schedules->count() == $loop->index + 1) && (($loop->index + 1) % 4 == 2))) image-one-row @else schedule-image @endif" src="{{ asset('storage') . '/' . $schedule->image->url }}">
                                  </div>
                                  <div style="">
                                    <strong>
                                      <h3 style="font-weight: bold; padding-top: 5px; padding-bottom: 5px; margin: 0px;">
                            {{ __('schedule.' . date('l', strtotime($schedule->date))) }}, {{ date('d.m', strtotime($schedule->date)) }}
                            <br>
                            {{ __('schedule.time') }}: {{ $schedule->time }}
                            </h3>
                            
                                    </strong>
                                  </div>
                                  <div>
                                    <strong>
                                      <div>
                              {{ $schedule->line1 }}
                            </div>
                            <div>
                                        {{ $schedule->line2 }}
                            </div>
                            <div>
                                        {{ $schedule->line3 }}
                            </div>
                                    </strong>
                                  </div>
                                </td>
                            @if (($loop->index + 2) % 2 != 0)
                              </tr>
                            @endif
                          @endforeach
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
              <!-- </div> -->
            </div>
          
          @endfor
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
  </div>

  <script>

    var items = $("#myCarousel").find(".item");

    items.each(function(index){
      if (index == 0) {
        $(items[index]).addClass("active");
      }
    });

    // 
    //   var items = $(this).find(".item.active").data('time');
    //   console.log(index.toElement);
        
    // });
    var totalItems = $('.item').length;
    var index = $('div.active').index() + 1;


    var time = 3000;

    if ($($(".item")[0]).data('time')) {
      time = $($(".item")[0]).data('time') * 1000;
    }

    $('#myCarousel').carousel({
      pause: false,
      interval: time 
    });
    

    $('#myCarousel').on('slide.bs.carousel', function() {
      
      var c = $('#myCarousel');

      index = $('div.active').index() + 1;

      if (index == totalItems) {
        index = 0;
      }
      
      if ($($(".item")[index]).data('time')) {
        time = $($(".item")[index]).data('time') * 1000;
      }

      opt = c.data()['bs.carousel'].options;
      opt.interval= time;
      c.data({options: opt});
      time = $($(".item")[0]).data('time') * 1000;
    });
  </script>
@endsection