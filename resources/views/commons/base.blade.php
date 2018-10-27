<!DOCTYPE html>
<html>
  <head>
    @include('commons.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body class="hold-transition skin-yellow sidebar-mini sidebar-collapse">
    <div class="wrapper">
      @include('commons.main-header')
      @include('commons.main-sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        @include('commons.content-header')

        <!-- Main content -->
        <section class="content">
          @yield('content')
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      @include('commons.footer')
      @include('commons.right-sidebar')

    </div><!-- ./wrapper -->
    @yield('modals-cont')
    @yield('bottom-script')
  </body>
</html>
