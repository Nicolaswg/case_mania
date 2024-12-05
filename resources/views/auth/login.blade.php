@extends('layouts.app')
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <span><i class="bi bi-check"></i></span> {{session('success')}}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="sidebar-heading text-center"><img src="{{asset('images/logosis.jpg')}}"  class="img-thumbnail rounded" alt="CaseMania" height="100px" width="49%"></div>
            <div class="col-md-6 pt-2">
                <div class="card">
                    <div class="card-header bg-info text-black bg-opacity-100">Inicio de Sesión</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('* Correo Electrónico:') }}</label>

                                <div class="col-md-7">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>


                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('* Contraseña:') }}</label>

                                <div class="col-md-7">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label>* Campos obligatorios</label>
                            </div>
                            <div class="row mb-3 form-group">
                                <div class="col-md-7 offset-md-3 row mb-3">
                                    <button type="submit" class="btn btn-primary text-center">
                                        {{ __('Iniciar Sesión') }}
                                    </button>
                                </div>
                                <div class="form-group col-md-6 offset-md-4">
                                    <!-- <div class="form-check">
                                    <input class="ml-3 underline" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> -->

                                    <a href="{{route('reset_pasword',[@csrf_token()])}}" class="btn btn-link">
                                        <h5>{{ __('¿Olvidó su contraseña?') }}</h5>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

