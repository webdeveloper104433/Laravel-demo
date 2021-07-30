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
      border-spacing: 20px;
      border-color: grey;
      border: 1px solid grey;
      border-radius: 10px;
    }

    .schedule-border {
      border: 1px solid grey;
      padding: 10px;
    }

    td {
      font-size: 20px;
    }
  </style>

  <div class="container">
    <!-- Wrapper for slides -->
    @if (!(isset($title) && $title != "off"))
	  @if (isset($schedule_title))
      <h3>{{ $schedule_title }}</h3>
	  @endif
    @endif
    <div class="table-responsive text-center" style="margin-top: 20px;">

     
      <table style="width: 100%; ">
        <tbody>
          @foreach ($schedules as $schedule)
            @if (($loop->index + 2) % 2 == 0)
              <tr>
            @endif
                <td class="schedule-border">
                  <div>
                    <img src="{{ asset('storage') . '/' . $schedule->image->url }}" class="img-thumbnail">
                  </div>
                  <div style="font-size: 25px; margin-top: 10px;">
                    <strong>
                      {{ date('l', strtotime($schedule->date)) }} {{ $schedule->date }}
                      <br>
                      {{ $schedule->time }} {{ date('A', strtotime($schedule->date)) }}
                    </strong>
                  </div>
                  <div style="margin-top: 10px;">
                    <strong>
                      {{ $schedule->line1 }}
                      <br>
                      {{ $schedule->line2 }}
                      <br>
                      {{ $schedule->line3 }}
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
@endsection