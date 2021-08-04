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

  <div class="container">
    <!-- Wrapper for slides -->
    <h1>Termine</h1>

    <div class="table-responsive text-center" style="margin-top: 20px;">

      <table style="width: 100%; " cellspacing="10px">
        <tbody>
          @foreach ($schedules as $schedule)
            @if (($loop->index + 2) % 2 == 0)
              <tr>
            @endif
                <td class="schedule-border" style="@if (($loop->index + 2) % 2 == 0) background-color: #0389f7; @else background-color: #e2e2e2; @endif">
                  <div>
                    <img src="{{ asset('storage') . '/' . $schedule->image->url }}" class="img-thumbnail">
                  </div>
                  <div style="font-size: 25px;">
                    <strong>
                      {{ date('l', strtotime($schedule->date)) }}, {{ $schedule->date }}
                      <br>
                      Time: {{ $schedule->time }} Clock
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