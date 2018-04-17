<!doctype html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Laravel</title>
  <link href="/css/app.css" rel="stylesheet">
  <link href="/css/all.css" rel="stylesheet">

  <!-- Scripts -->
  <script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
    ]); ?>
  </script>

  {{--<link href="assets/css/bootstrap.min.css" rel="stylesheet"/>--}}
  {{--<link href="assets/css/paper-dashboard.css" rel="stylesheet"/>--}}
  {{--<link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">--}}
</head>

<body>
<div class="wrapper">
  @yield('baseContent')
</div>

@section('baseFooter')
  <script src="/js/app.js"></script>
  <script src="/js/all.js"></script>
  <script>
    $.fn.select2.defaults.set( "theme", "bootstrap" );
  </script>
  {{--<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>--}}
  {{--<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>--}}

  @yield('script')
@show
</body>

</html>
