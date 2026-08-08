<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Harita Music Academy')</title>
  <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-assets/css/dashboard-layout.css') }}">
  @stack('styles')
</head>
<body>
  <!-- PRELOADER -->
  <div id="preloader" class="preloader-overlay">
    <div class="preloader-content">
      <img src="{{ asset('admin-assets/assets/logo.png') }}" class="preloader-logo" alt="Harita Logo">
      <div class="preloader-spinner"></div>
    </div>
  </div>

  <div class="app-container">
    @include('layouts.main.sidebar')
    @include('layouts.main.header')

    <main class="main-content">
      @yield('content')
    </main>
  </div>

  @stack('modals')

  <script src="{{ asset('admin-assets/js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>