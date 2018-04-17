@if (Route::has('login'))
  <div class="top simple-text left-20 nav-logo">
    <a href="#" class="text-left left">{{env('APP_NAME')}}</a>
  </div>
  {{--<div class="top-right links">--}}
  {{--<a href="{{ url('/login') }}">Login</a>--}}
  {{--</div>--}}
@endif
