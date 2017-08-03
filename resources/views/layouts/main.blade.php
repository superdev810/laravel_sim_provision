@include('layouts.header')
<div class="page-content-wrapper">
    <div class="page-content">
        @yield('pagebar')
        @yield('content')
    </div>
</div>
@include('layouts.footer')