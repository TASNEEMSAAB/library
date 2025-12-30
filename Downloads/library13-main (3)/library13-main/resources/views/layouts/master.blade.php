<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main">
            @include('layouts.nav')
			<main class="content">
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </div>
	<script src="{{asset('dashboard-assets/js/app.js')}}"></script>

</body>

</html>
