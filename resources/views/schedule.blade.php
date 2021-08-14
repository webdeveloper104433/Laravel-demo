@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/pages/schedule.css')}}">
  @if (isset($design))
    <link rel="stylesheet" href="{{ asset('css') . '/' . $design . '.css' }}">
  @endif
@endpush

@section('content')

  <div class="container-full" style="padding: 10px;">
    <!-- Wrapper for slides -->
    <h1 class="schedule-title">Termine</h1>

    <div class="table-responsive text-center" style="margin-top: 20px;">

      <table class="schedule-content" cellspacing="10px">
        <tbody>
          @foreach ($schedules as $schedule)
            @if (($loop->index + 2) % 2 == 0)
              <tr class="slide-tr slide-number-{{ ceil(($loop->index + 1) / 4) }}">
            @endif
                <td class="schedule-border @if (($loop->index + 2) % 2 == 0) left-background-color @else right-background-color @endif">
                  <div>
                    <img src="{{ asset('storage') . '/' . $schedule->image->url }}" class="img-thumbnail @if (($schedules->count() == $loop->index + 1) && (($loop->index + 1) % 2 == 1) && (($loop->index + 1) % 4 == 1)) image-one-item  @else image-item @endif">
                  </div>
                  <div style="">
                    <strong>
                      <h3 style="font-weight: bold; padding-top: 25px; padding-bottom: 25px;">
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

<script>
		var number = 1;

	showSlider();
	//$(".slide-tr").hide();
	//$(".slide-number-" + number).show();
	
	function showSlider() {
		$(".slide-tr").hide();
		$(".slide-number-" + number).show();
		number++;

		if (!$(".slide-number-" + number).length) {
			number = 1;
		}
		
		setTimeout(function(){ showSlider(); }, 5000);	
	}
</script>
@endsection