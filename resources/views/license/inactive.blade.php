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
                            <i class="nc-icon nc-simple-remove text-danger" style="font-size: 80px;"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Licencia Inactiva</h4>
                        <p class="card-description">
                            La licencia de su empresa <strong>{{ $company->name ?? 'sin nombre' }}</strong> está inactiva.
                        </p>
                        
                        @if($license)
                        <div class="alert alert-warning mt-3">
                            <strong>Estado:</strong> <span class="badge badge-warning">{{ ucfirst($license->status) }}</span>
                            <br>
                            <strong>Plan:</strong> {{ ucfirst($license->plan_type) }}
                            <br>
                            <strong>Clave de licencia:</strong> {{ $license->license_key }}
                            @if($license->end_date)
                            <br>
                            <strong>Válida hasta:</strong> {{ $license->end_date->format('d/m/Y') }}
                            @endif
                        </div>
                        @endif

                        <p class="text-muted mt-3">
                            Su licencia ha sido desactivada. Esto puede deberse a problemas de pago, violación de términos de servicio, o una suspensión temporal.
                        </p>
                        
                        <hr>
                        
                        <div class="mt-4">
                            <p class="mb-2"><strong>¿Qué hacer?</strong></p>
                            <ul class="list-unstyled text-left" style="max-width: 400px; margin: 0 auto;">
                                <li class="mb-2">
                                    <i class="nc-icon nc-email-85 text-info"></i>
                                    Contacte inmediatamente al administrador
                                </li>
                                <li class="mb-2">
                                    <i class="nc-icon nc-alert-circle-i text-info"></i>
                                    Verifique el estado de sus pagos
                                </li>
                                <li class="mb-2">
                                    <i class="nc-icon nc-support-17 text-info"></i>
                                    Solicite información sobre la desactivación
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-round">
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
