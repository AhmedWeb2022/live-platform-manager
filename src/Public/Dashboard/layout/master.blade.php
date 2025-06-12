<!DOCTYPE html>
<html lang="en">

@include('head')

<body>
    <div class="d-flex sidemobile p-0">
        @include('messages')
        @include('sidebar')
        <section class="index_cards">
            @include('navbar')
            @yield('content')
        </section>
    </div>
    @include('footer')
</body>

</html>
