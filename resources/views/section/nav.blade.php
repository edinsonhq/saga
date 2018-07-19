<nav class="navbar navbar-expand-md navbar-dark  navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <img width="15" src="{{asset('images/saga_logo.png')}}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                    @else

                        @if (Auth::user()->rol_id ==1 or Auth::user()->rol_id ==3)

                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle"  href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Actividades
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                          <a class="dropdown-item" href="{{route("actividad.index")}}">Listado</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="{{URL::to('actividad/formImport') }}">Importar</a>
                                          <a class="dropdown-item" href="{{ route('actividad.export',['type'=>'xls']) }}">Exportar</a>
                                          {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
                                        </div>
                                </li>
                            </ul>

                        @endif

                    @endguest
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Crear una cuenta') }}</a>
                            </li>
                        @else


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ 
                                            date('d-m-Y H:i:s')    

                                        

                                    }}

                                    {{ " | ".ucfirst(Auth::user()->rol->nombre)." | "."Bienvenido: ".Auth::user()->empleado->nombres." ".Auth::user()->empleado->apepaterno." ".Auth::user()->empleado->apematerno }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>