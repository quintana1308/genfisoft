<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="/" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('paper') }}/img/logotipo-genfinsoft.png">
            </div>
        </a>
        <a href="/" class="simple-text logo-normal">
            {{ __('GenFinSoft') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ ($elementActive ?? '') == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard', 'dashboard') }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <p>{{ __('Panel de Control') }}</p>
                </a>
            </li>
            <li
                class="{{ ($elementActive ?? '') == 'cattle' || ($elementActive ?? '') == 'cattleCreate' || ($elementActive ?? '') == 'death' ? 'active' : '' }}">
                <a data-toggle="collapse"
                    aria-expanded="{{ ($elementActive ?? '') == 'cattle' || ($elementActive ?? '') == 'cattleCreate' || ($elementActive ?? '') == 'death' ? 'true' : 'false' }}"
                    href="#cattle">
                    <i class="fa-solid fa-cow"></i>
                    <p>
                        {{ __('Animales') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($elementActive ?? '') == 'cattle' || ($elementActive ?? '') == 'cattleCreate' || ($elementActive ?? '') == 'death' ? 'show' : '' }}"
                    id="cattle">
                    <ul class="nav">
                        <li class="{{ ($elementActive ?? '') == 'cattle' ? 'active' : '' }}">
                            <a href="{{ route('cattle.index', 'cattle') }}">
                                <i class="fa-solid fa-clipboard-list"></i>
                                <p>{{ __('Listado') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'cattleCreate' ? 'active' : '' }}">
                            <a href="{{ route('cattle.create', 'cattleCreate') }}">
                                <i class="fa-solid fa-circle-plus"></i>
                                <p>{{ __('Registrar') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'death' ? 'active' : '' }}">
                            <a href="{{ route('death.index', 'death') }}">
                                <i class="fa-solid fa-cross"></i>
                                <p>{{ __('Muertes') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li
                class="{{ ($elementActive ?? '') == 'veterinarian' || ($elementActive ?? '') == 'veterinarianCreate' || ($elementActive ?? '') == 'product' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="{{ ($elementActive ?? '') == 'veterinarian' || ($elementActive ?? '') == 'veterinarianCreate' || ($elementActive ?? '') == 'product' ? 'true' : 'false' }}" href="#veterinarian">
                    <i class="fa-solid fa-house-medical"></i>
                    <p>
                        {{ __('Servicio Veterinario') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($elementActive ?? '') == 'veterinarian' || ($elementActive ?? '') == 'veterinarianCreate' || ($elementActive ?? '') == 'product' ? 'show' : '' }}" id="veterinarian">
                    <ul class="nav">
                        <li class="{{ ($elementActive ?? '') == 'veterinarian' ? 'active' : '' }}">
                            <a href="{{ route('veterinarian.index', 'veterinarian') }}">
                                <i class="fa-solid fa-clipboard-list"></i>
                                <p>{{ __('Listado') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'veterinarianCreate' ? 'active' : '' }}">
                            <a href="{{ route('veterinarian.create', 'veterinarianCreate') }}">
                                <i class="fa-solid fa-circle-plus"></i>
                                <p>{{ __('Registrar') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'product' ? 'active' : '' }}">
                            <a href="{{ route('product.index', 'product') }}">
                                <i class="fa-solid fa-syringe"></i>
                                <p>{{ __('Productos') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ ($elementActive ?? '') == 'estate' || ($elementActive ?? '') == 'workman' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="{{ ($elementActive ?? '') == 'estate' || ($elementActive ?? '') == 'workman' ? 'true' : 'false' }}" href="#estate">
                    <i class="fa-solid fa-tractor"></i>
                    <p>
                        {{ __('Gestion de Bienes') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($elementActive ?? '') == 'estate' || ($elementActive ?? '') == 'workman' ? 'show' : '' }}" id="estate">
                    <ul class="nav">
                        <li class="{{ ($elementActive ?? '') == 'estate' ? 'active' : '' }}">
                            <a href="{{ route('estate.index', 'estate') }}">
                                <i class="fa-solid fa-trowel"></i>
                                <p>{{ __('Bienes') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'workman' ? 'active' : '' }}">
                            <a href="{{ route('workman.index', 'workman') }}">
                                <i class="fa-solid fa-person-digging"></i>
                                <p>{{ __('Hechuras') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ ($elementActive ?? '') == 'input' ? 'active' : '' }}">
                <a href="{{ route('input.index', 'input') }}">
                    <i class="fa-solid fa-wheat-awn"></i>
                    <p>{{ __('Insumos') }}</p>
                </a>
            </li>
            <li class="{{ ($elementActive ?? '') == 'category' || ($elementActive ?? '') == 'causeEntry' || ($elementActive ?? '') == 'statusProductive' || ($elementActive ?? '') == 'statusReproductive' || ($elementActive ?? '') == 'color' || ($elementActive ?? '') == 'classification' || ($elementActive ?? '') == 'herd' || ($elementActive ?? '') == 'owner' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="{{ ($elementActive ?? '') == 'category' || ($elementActive ?? '') == 'causeEntry' || ($elementActive ?? '') == 'statusProductive' || ($elementActive ?? '') == 'statusReproductive' || ($elementActive ?? '') == 'color' || ($elementActive ?? '') == 'classification' || ($elementActive ?? '') == 'herd' || ($elementActive ?? '') == 'owner' ? 'true' : 'false' }}" href="#compo">
                    <i class="fa-solid fa-gear"></i>
                    <p>
                        {{ __('Configuración') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($elementActive ?? '') == 'category' || ($elementActive ?? '') == 'causeEntry' || ($elementActive ?? '') == 'statusProductive' || ($elementActive ?? '') == 'statusReproductive' || ($elementActive ?? '') == 'color' || ($elementActive ?? '') == 'classification' || ($elementActive ?? '') == 'herd' || ($elementActive ?? '') == 'owner' ? 'show' : '' }}" id="compo">
                    <ul class="nav">
                        <li class="{{ ($elementActive ?? '') == 'category' ? 'active' : '' }}">
                            <a href="{{ route('category.index', 'category') }}">
                                <i class="fa-solid fa-layer-group"></i>
                                <p>{{ __('Categorías') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'causeEntry' ? 'active' : '' }}">
                            <a href="{{ route('causeEntry.index', 'causeEntry') }}">
                                <i class="fa-solid fa-scroll"></i>
                                <p>{{ __('Causa de entrada') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'statusProductive' ? 'active' : '' }}">
                            <a href="{{ route('statusProductive.index', 'statusProductive') }}">
                                <i class="fa-solid fa-whiskey-glass"></i>
                                <p>{{ __('Estado productivo') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'statusReproductive' ? 'active' : '' }}">
                            <a href="{{ route('statusReproductive.index', 'statusReproductive') }}">
                                <i class="fa-solid fa-chart-column"></i>
                                <p>{{ __('Estado reproductivo') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'color' ? 'active' : '' }}">
                            <a href="{{ route('color.index', 'color') }}">
                                <i class="fa-solid fa-droplet"></i>
                                <p>{{ __('Color') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'classification' ? 'active' : '' }}">
                            <a href="{{ route('classification.index', 'classification') }}">
                                <i class="fa-solid fa-grip"></i>
                                <p>{{ __('Clasificación') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'owner' ? 'active' : '' }}">
                            <a href="{{ route('owner.index', 'owner') }}">
                                <i class="fa-solid fa-user-tie"></i>
                                <p>{{ __('Propietario') }}</p>
                            </a>
                        </li>
                        <li class="{{ ($elementActive ?? '') == 'herd' ? 'active' : '' }}">
                            <a href="{{ route('herd.index', 'herd') }}">
                                <i class="fa-solid fa-house-chimney-crack"></i>
                                <p>{{ __('Rebaño') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            @if(Auth::user()->isAdmin())
            <li class="{{ ($elementActive ?? '') == 'admin' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="{{ ($elementActive ?? '') == 'admin' ? 'true' : 'false' }}" href="#admin">
                    <i class="fa-solid fa-user-shield"></i>
                    <p>
                        {{ __('Administración') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($elementActive ?? '') == 'admin' ? 'show' : '' }}" id="admin">
                    <ul class="nav">
                        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-chart-line"></i>
                                <p>{{ __('Dashboard Admin') }}</p>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.companies*') ? 'active' : '' }}">
                            <a href="{{ route('admin.companies') }}">
                                <i class="nc-icon nc-bank"></i>
                                <p>{{ __('Gestión de Empresas') }}</p>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users') }}">
                                <i class="fa-solid fa-users"></i>
                                <p>{{ __('Gestión de Usuarios') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>