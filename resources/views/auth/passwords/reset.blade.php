@extends('layouts.app')

@section('title', 'Categorias')
@section('content')

<!-- contenedor de confirmación, verificación de preguntas de seguridad y nueva contraseña -->

    <div class="container" id="app"> 
        <div class="row justify-content-center">
            <!-- Imagen del sistema -->
            <div class="sidebar-heading text-center"><img src="{{asset('images/logosis.jpg')}}"  class="img-thumbnail rounded" alt="CaseMania" height="100px" width="49%"></div>
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
                    
                        <!-- Verificación del correo electrónico-->

                        <div class="card-header bg-info bg-gradient text-black">Reestablecer Contraseña</div>
                        <form  method="POST" action="{{ url('verificar/email') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-3 pt-2" style="justify-content: center">
                                    <div class="offset-md-5">
                                        <span class="note info text-white" v-if="showinfo" >Ingrese el correo eléctronico que desea cambiar la contraseña</span>
                                        <label for="email">* Correo Electrónico: <button @click.prevent="verificarinfo()" id="email" class="btn btn-link m-0 text-dark"><i class="bi bi-info-circle"></i></button></label>
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
                                <label class="pt-2">* Campos Obligatorios</label>
                            </div>
                        </form>

                        @if(session('status') == 'true' &&  session('status_preguntas') == 'false')
                            <hr>

                            <!-- Verificación de las preguntas de seguridad -->

                            <h6 class="card-header bg-info bg-gradient text-black">Preguntas de Seguridad</h6>
                            <form method="POST" action="{{ url('verificar/preguntas') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5 text-center">
                                        <label for="pregunta1">{{ucfirst(session('pregunta1'))}}</label>
                                        <input type="text" class="form-control text-center" value="{{session('respuesta1')}}" @if(session('status_preguntas') == 'true') disabled @endif  name="respuesta1" autocomplete="off" maxlength="20" minlength="4">
                                    </div>
                                    <div class="col-md-5 text-center">
                                        <label for="pregunta2">{{ucfirst(session('pregunta2'))}}</label>
                                        <input type="text" class="form-control text-center" value="{{session('respuesta2')}}" @if(session('status_preguntas') == 'true') disabled @endif name="respuesta2" autocomplete="off" maxlength="20" minlength="4">
                                    </div>
                                    <div class="col-md-2 mt-3 text-center" style="justify-content: center">
                                        <button type="submit" class="btn-sm btn btn-success "><i class="bi bi-arrow-bar-right"></i>Verificar</button>
                                    </div>
                                    <input type="hidden" value="{{session('user_id')}}" name="user_id">
                                </div>
                                <label class="pt-2">Estimado usuario, ingrese las respuestas exactamente como fueron registradas, es decir, se toman en cuenta las mayúsculas y minúsculas</label>
                            </form>
                        @endif
                    @endif

                    <!-- Cambio de la contraseña cuando las preguntas de seguridad sean verificadas de manera correcta -->

                    @if(session('status_preguntas') == 'true')
                        <h6 class="card-header bg-info bg-gradient text-black">Nueva Contraseña</h6>
                        <form method="POST" action="{{ url('contraseña/update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-5 text-center">
                                    <label for="pregunta1">Nueva Contraseña</label>
                                    <input type="password" class="form-control text-center" name="contraseña" maxlength="12" minlength="6">
                                </div>
                                <div class="col-md-5 text-center">
                                    <label for="pregunta2">Confirmar Contraseña</label>
                                    <input type="password" v-model="contra2" class="form-control text-center" name="contraseña2" maxlength="12" minlength="6">
                                </div>
                                <div class="col-md-2 mt-3 text-center" style="justify-content: center">
                                    <button type="submit" class="btn-sm btn btn-success "><i class="bi bi-floppy"></i>Guardar</button>
                                </div>
                                <input type="hidden" value="{{session('user_id')}}" name="user_id">
                            </div>
                            <label class="pt-2">Estimado usuario, la contraseña debe contener entre 6 y 12 caracteres y deben ser alfanuméricos</label>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="pt-4 text-center">
    <a href="{{ route('login') }}" class="btn btn-primary bi bi-arrow-90deg-left"> Regresar al Inicio de Sesión</a>
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
                        console.log('Debes Ingresar un Correo Electrónico Válido') //Mensaje cuando se ingrese un correo electrónico incorrecto
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
