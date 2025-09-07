<!DOCTYPE html>
<html lang="id">
    {{-- head --}}
      @include('backend.layouts-news.partials.head')

  <body>

    {{-- sidebar   --}}
      @include('backend.layouts-news.partials.sidebar')
    <main>
      @include('backend.layouts-news.partials.message')
      @yield('content')
    </main>
    
    {{-- foot  --}}
    @include('backend.layouts-news.partials.foot')
  </body>
</html>
