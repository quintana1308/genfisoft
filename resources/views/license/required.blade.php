@extends('layouts.license', [
    'class' => 'login-page',
    'backgroundImagePath' => 'img/bg/fabio-mangione.jpg'
])

@section('content')
<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-lock text-center">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="nc-icon nc-key-25 text-warning" style="font-size: 80px;"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Licencia Requerida</h4>
                        <p class="card-description">
                            Su empresa <strong>{{ Auth::user()->company->name ?? 'sin nombre' }}</strong> no tiene una licencia válida asignada.
                        </p>
                        <p class="text-muted">
                            Para acceder al sistema, es necesario que un administrador asigne una licencia a su empresa.
                        </p>
                        <hr>
                        <div class="mt-4">
                            <p class="mb-2"><strong>¿Qué puede hacer?</strong></p>
                            <ul class="list-unstyled text-left" style="max-width: 400px; margin: 0 auto;">
                                <li class="mb-2">
                                    <i class="nc-icon nc-email-85 text-info"></i>
                                    Contacte al administrador del sistema
                                </li>
                                <li class="mb-2">
                                    <i class="nc-icon nc-support-17 text-info"></i>
                                    Solicite la activación de una licencia
                                </li>
                                <li class="mb-2">
                                    <i class="nc-icon nc-refresh-69 text-info"></i>
                                    Intente nuevamente más tarde
                                </li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-round">
                                    <i class="nc-icon nc-button-power"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush
