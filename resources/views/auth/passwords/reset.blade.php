@extends('layouts.app')
@section('content')

    <div class="container" id="app">
        <div class="row justify-content-center">
            <div class="sidebar-heading text-center"><img src="{{asset('images/logo.jpg')}}"  class="img-thumbnail rounded" alt="CaseMania" height="100px" width="49%"></div>
            <div class="col-md-6 pt-2">
                <div class="card">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            <span><i class="bi bi-check"></i></span> {{session('success')}}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            <span><i class="bi bi-x"></i></span> {{session('error')}}
                        </div>
                    @endif
                    @if($status_preguntas == false ||   session('status_preguntas') == 'false')
                        <div class="card-header bg-info bg-gradient text-black">Reestablecer Contraseña</div>
                        <form  method="POST" action="{{ url('verificar/email') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-3 pt-2" style="justify-content: center">
                                    <div class="col-md-4 col-form-label text-md-right">
                                        <label for="email">* Correo Electrónico: </label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            @if( session('status_preguntas') == 'true')
                                                <input id="email"  type="email" class="form-control @error('email') is-invalid @enderror" @if(session('status') == 'true') disabled @endif name="email" value="{{session('email')}}" required autocomplete="off" autofocus>
                                            @else
                                                <input id="email"  type="email" class="form-control @error('email') is-invalid @enderror" @if(session('status') == 'true') disabled @endif name="email" value="{{ $email ?? old('email') }}" required autocomplete="off" autofocus>
                                                <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar" type="submit" @if(session('status') == 'true') disabled @endif class=" btn btn-success" ><i class="bi bi-arrow-bar-right"></i></button>
                                            @endif


                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>

                        @if(session('status') == 'true' &&  session('status_preguntas') == 'false')
                            <hr>
                            <h6 class="card-header bg-info bg-gradient text-black">Preguntas de Seguridad</h6>
                            <form method="POST" action="{{ url('verificar/preguntas') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5 text-center">
                                        <label for="pregunta1">{{ucfirst(session('pregunta1'))}}</label>
                                        <input type="text" class="form-control text-center" value="{{session('respuesta1')}}" @if(session('status_preguntas') == 'true') disabled @endif  name="respuesta1" autocomplete="off">
                                    </div>
                                    <div class="col-md-5 text-center">
                                        <label for="pregunta2">{{ucfirst(session('pregunta2'))}}</label>
                                        <input type="text" class="form-control text-center" value="{{session('respuesta2')}}" @if(session('status_preguntas') == 'true') disabled @endif name="respuesta2" autocomplete="off">
                                    </div>
                                    <div class="col-md-2 mt-3 text-center" style="justify-content: center">
                                        <button type="submit" class="btn-sm btn btn-success "><i class="bi bi-arrow-bar-right"></i>Verificar</button>
                                    </div>
                                    <input type="hidden" value="{{session('user_id')}}" name="user_id">
                                </div>
                            </form>
                        @endif
                    @endif
                    @if(session('status_preguntas') == 'true')
                        <h6 class="card-header bg-info bg-gradient text-black">Nueva Contraseña</h6>
                        <form method="POST" action="{{ url('contraseña/update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-5 text-center">
                                    <label for="pregunta1">Nueva Contraseña</label>
                                    <input type="password" class="form-control text-center" name="contraseña">
                                </div>
                                <div class="col-md-5 text-center">
                                    <label for="pregunta2">Confirmar Contraseña</label>
                                    <input type="password" v-model="contra2" class="form-control text-center" name="contraseña2">
                                </div>
                                <div class="col-md-2 mt-3 text-center" style="justify-content: center">
                                    <button type="submit" class="btn-sm btn btn-success "><i class="bi bi-floppy"></i>Guardar</button>
                                </div>
                                <input type="hidden" value="{{session('user_id')}}" name="user_id">
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        const app=new Vue({
            el:'#app',
            data: {
                contras:'',
                contra2:'',
            },
            mounted() {
            },
            methods:{
                consultaremail(){
                    if(this.email === ''){
                        /* Swal.fire({
                             title:'Debes escribir tu direccion de Correo Electronico',
                             icon:'error',
                             showConfirmButton: true,
                         })*/
                        console.log('Debes escribir un correo valido')
                    }else{

                    }
                },
            },
        })
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection

@section('script')

@endsection
