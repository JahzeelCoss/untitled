<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{!! url('/') !!}">ADHL</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-left">
                @if(Auth::check())
                    <li><a href="{!! url('auth/logout') !!}">Cerrar Sesión</a></li>
                @else
                <li><a href="{!! url('auth/login') !!}">Iniciar Sesión</a></li>
                <li><a href="{!! url('auth/register') !!}">Registrarse</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>