@extends('layout')
@section('title', "Inicio")
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Inicio</li>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center mt-2">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Panel Principal') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Aqui van algunas estadisticas del sistema') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
