<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Laravel Gallery1</title>
     
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/style.css">
    
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Homepage</a>
      </li>
    </ul>
      
       <ul class="navbar-nav mr-auto">
            @if (Auth::check())
                <li class="nav-item">        
                   <a class="nav-link" href="">
                       {{ Auth::user()->name}} вы находитель в группе {{$userRole}}
                   </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/create">Добавить картинку</a>
                </li>
                 <li class="nav-item">
                     <a href="/logout" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();
                        "class="nav-link">
                        Выйти
                     </a>
                     <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                        {{csrf_field()}}
                   </form>
                </li>
                
                @else
                Привет {{$userRole}}
                <li class="nav-item">
                    <a class="nav-link" href="/login">Войти</a>
                </li>
            @endif
      </ul>
   
  </div>
</nav>
        @yield('content')
    </body>
</html>