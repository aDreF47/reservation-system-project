<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!-- Sidebar a la izquierda -->
    <td width="25%" valign="top" style="padding:10px; border-right:1px solid #ccc;">
      @include('components.admin.sidebar')
    </td>

    <!-- Contenido principal a la derecha -->
    <td width="75%" valign="top" style="padding:10px;">
      @yield('content')
    </td>
  </tr>
</table>

</body>
</html>
