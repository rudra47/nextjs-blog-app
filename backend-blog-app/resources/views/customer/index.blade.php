@extends('customer.layouts.app')

@push('css')
<style>
    .navbar .container-fluid {
        padding-top: 1rem;
    }
</style>

@endpush

@section('content')
<div class="container">
    <h3>Available Saloons Near You</h3>
    <hr/>
    <div class="row">
        @foreach ($saloons as $saloon)
        <div class="col-sm-4">
            <div class="thumbnail">
                <a href="/w3images/lights.jpg">
                  <img src="@if($saloon->image){{ asset('images/saloons/'.$saloon->image) }} @else {{ asset('images/saloons/demo-saloon.jpg') }} @endif" alt="Lights" style="width:100%">
                  <div class="caption">
                    <h4>{{ $saloon->name }}</h4>
                    <form method="post" action="{{ route('saloon.book') }}">
                        @csrf
                            <input type="hidden" name="schedule" value="1">
                            <span><b>Select Service: </b>';
                                <select name="service" style="margin-top: 5px;">
                                     <option value="0">Hair cut</option>
                                     <option value="0">Head massage</option>
                                     <option value="0">Hair color</option>
                                </select>
                                </span><br/>
                             <button type="submit" class="btn btn-xs btn-primary" style="margin-top: 5px;" onclick="return confirm('+confirm+');">Book Now</button>
                        </form>
                  </div>

                  
                </a>
              </div>
        </div>
        @endforeach
    </div>
</div>
@endsection