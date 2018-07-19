@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-dark ">
                <div class="card-header">{{ __('Acceso') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('autenticar') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="txtEmail" class="col-sm-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="txtEmail" type="text" class="form-control{{ $errors->has('txtEmail') ? ' is-invalid' : '' }}" name="txtEmail" value="{{ old('txtEmail') }}" maxlength="100" required autofocus>

                                @if ($errors->has('txtEmail'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('txtEmail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="txtPassword" class="col-md-4 col-form-label text-md-right">{{ __('Clave') }}</label>

                            <div class="col-md-6">
                                <input id="txtPassword" type="password" class="form-control{{ $errors->has('txtPassword') ? ' is-invalid' : '' }}" name="txtPassword" maxlength="100" required>

                                @if ($errors->has('txtPassword'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('txtPassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                      {{--   <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
 --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Iniciar sesión') }}
                                </button>
                                {{-- <a href="{{route('registro.create')}}" class="btn btn-default">Crear una cuenta</a> --}}

                             {{--    <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
