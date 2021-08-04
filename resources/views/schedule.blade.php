@extends('layouts.app')


@section('content')

  <style type="text/css">
    .item-border {
      border: 1px solid black;

      height: 200px;
    }
    img {
      width: 250px;
      height: 166px;
    }

    table {
      width: 100%;
      display: table;
      border-collapse: separate;
      box-sizing: border-box;
      text-indent: initial;
      border-spacing: 10px;
      border-color: grey;
      border: 1px solid grey;
      border-radius: 20px;
    }

    .schedule-border {
      border: 1px solid black;
      padding: 10px;
    }

    td {
      font-size: 20px;
    }
  </style>

  <div class="container-full" style="padding: 10px;">
    <!-- Wrapper for slides -->
    <h1 style="font-weight: bold;">Termine</h1>

    <div class="table-responsive text-center" style="margin-top: 20px;">

      <table style="width: 100%; " cellspacing="10px">
        <tbody>
          @foreach ($schedules as $schedule)
            @if (($loop->index + 2) % 2 == 0)
              <tr class="slide-tr slide-number-{{ ceil(($loop->index + 1) / 4) }}">
            @endif
                <td class="schedule-border" style="padding: 10px; @if (($loop->index + 2) % 2 == 0) background-color: #0389f7; @else background-color: #e2e2e2; @endif">
                  <div>
                    <img src="{{ asset('storage') . '/' . $schedule->image->url }}" style="@if (($schedules->count() == $loop->index + 1) && (($loop->index + 1) % 2 == 1) && (($loop->index + 1) % 4 == 1)) width: auto; height: 70vh;  @else width: 250px; height: 166px; @endif">
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