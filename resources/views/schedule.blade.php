@extends('layouts.app')


@section('content')

  <style type="text/css">
    .item-border {
      border: 1px solid black;

      height: 200px;
    }  
  </style>

  <div class="container">
    <!-- Wrapper for slides -->
    <div class="table-responsive">          
      <table class="table">
        <tbody>
          
          @for ($i = 0; $i < 4; $i++)          
            @if (($i + 2) % 2 == 0)
              <tr>
            @endif
                <td>
                  12
                </td>
            @if (($i + 2) % 2 == 0)
              </tr>
            @endif
          @endfor
        </tbody>
      </table>
    </div>
  </div>
@endsection