@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Registrar Nuevo Usuario') }}</div>

                    <div class="card-body">
                        <!-- Formulario de Registro -->
                        <form method="POST" action="{{ route('register') }}">
                         @csrf
                         <button type="submit" class="btn btn-primary">{{ __('Registrar') }}</button>

                         <!-- campos del formulario -->
                        


                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="name" class="col-form-label">Nombre</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="form-group">
                                <label for="email" class="col-form-label">Correo Electrónico</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div class="form-group">
                                <label for="password" class="col-form-label">Contraseña</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="form-group">
                                <label for="password_confirmation" class="col-form-label">Confirmar Contraseña</label>
                                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

              
                     <!-- Solo mostrar el campo de rol si el usuario autenticado es administrador -->
                      @if(Auth::check() && Auth::user()->rol === 'administrador')
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol del Usuario</label>
                            <select class="form-select" id="rol" name="rol">
                                <option value="profesor" selected>Profesor</option>
                                <option value="administrador">Administrador</option>
                            </select>
                        </div>
                          @endif



                         </form>



                               @if(session('error'))
                                  <div class="alert alert-danger">
                                    {{ session('error') }}
                                  </div>
                               @endif

                         
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
