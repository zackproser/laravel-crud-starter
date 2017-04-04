<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

  <head>
   <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
    </script>

    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

    <title>{{ config('app.name') }} - @yield('title')</title>

  </head>

  <body class="{{ $bodyClass or '' }}">

    <div id="app" class="container">

      @yield('content')

    </div>

  <script src="{{ asset('/js/app.js') }}"></script>

  </body>

</html>