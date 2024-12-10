<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="NexusEdu">
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    
    <link href="/assets/css/custom.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    
   <!-- FullCalendar CSS -->
   <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
   <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@5.11.3/main.min.css' rel='stylesheet' />
   
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

   
    <!-- In head section -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- In the head section -->
    
    <!-- Google Integration CSS -->
    <link href="{{ asset('css/google-integration.css') }}" rel="stylesheet">
    
    <title> @yield('page_title') | {{ config('app.name') }} </title>
    
    @include('partials.inc_top')
</head>
<body class="{{ in_array(Route::currentRouteName(), ['payments.invoice', 'marks.tabulation', 'marks.show', 'ttr.manage', 'ttr.show']) ? 'sidebar-xs' : '' }}">
    @include('partials.top_menu')
    
    <div class="page-content">
        @include('partials.menu')
        
        <div class="content-wrapper">
            @include('partials.header')
            
            <div class="content">
                @if($errors->any())
                    <div class="alert alert-danger border-0 alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        @foreach($errors->all() as $er)
                            <span><i class="icon-arrow-right5"></i> {{ $er }}</span> <br>
                        @endforeach
                    </div>
                @endif
                
                <div id="ajax-alert" style="display: none"></div>
                
                @yield('content')
            </div>
        </div>
    </div>
    <!-- In your layout file (master.blade.php) -->
<!-- First jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Then jQuery Validate -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

<!-- Then jQuery Steps -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
 
    
    <!-- Bootstrap JS (single include) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- In your master layout -->

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/jquery.steps.min.js"></script>
<script src="/assets/js/jquery.validate.min.js"></script>
<script src="/assets/js/sweetalert2.all.min.js"></script>

    @include('partials.inc_bottom')
    @yield('scripts')
    @stack('scripts')
</body>
</html>