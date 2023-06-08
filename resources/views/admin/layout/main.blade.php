<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
   @include('admin.layout.part.head')
 </head>
 
<body id="page-top">
	@include('admin.layout.part.nav')
	@yield('content')
 
 
	@include('admin.layout.part.footer')
	@include('admin.layout.part.footer-scripts')
</body>
</html>