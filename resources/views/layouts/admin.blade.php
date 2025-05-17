<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Admin - @yield('title')</title>
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
