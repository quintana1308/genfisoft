<x-guest-layout>
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid" id="kt_login">
            <!--begin::Aside-->
            <div class="d-flex flex-column flex-lg-row-auto bg-primary w-lg-600px pt-15 pt-lg-0">
                <!--begin::Aside Top-->
                <div class="d-flex flex-row-fluid flex-center flex-column-auto flex-column text-center pt-5 mt-5">
                    <!--begin::Aside Logo-->
                    <img id="logoPryvit" alt="Logo" src="{{ asset('images/uploads/pryvit.png') }}"
                        style="border-radius: 15px;" class="mb-6 h-50px h-lg-75px">
                    <!--end::Aside Logo-->

                    <!--begin::Aside Subtitle-->
                    <h3 id="logoPryvit1" class="fw-bold fs-1x text-white lh-lg pt-5 mt-5">
                        Explora <b>Pryvit</b>,<br>
                        la Plataforma de Mensajería que Ofrece Herramientas Avanzadas y Efectivas para Optimizar tu
                        Comunicación
                    </h3>
                    <!--end::Aside Subtitle-->
                </div>
                <!--end::Aside Top-->

                <!--begin::Illustration-->
                <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                    style="background-image: url('{{ asset('images/media/svg/login.svg') }}');">
                </div>

                <!--end::Illustration-->
            </div>
            <!--begin::Aside-->

            <!--begin::Content-->
            <div
                class="login-content flex-lg-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden py-10 py-lg-20 px-10 p-lg-7 mx-auto mw-450px w-100">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column-fluid flex-center py-10">

                    <!--begin::Signin Form dejar-->
                    <form method="POST" action="{{ route('login') }}" class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework">
                        @csrf
                        <div class="pb-5 pb-lg-15">
                            <h3 class="fw-bold text-gray-900 display-6">Bienvenido a <b
                                    class="bg-primary px-3 text-white" style="border-radius: 10px;">Pryvit</b></h3>
                        </div>

                        <!--begin::Form group-->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="form-label fs-2 fw-bold text-gray-900" for="username">Usuario</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" id="username"
                                name="username" autocomplete="off">
                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="form-label fs-2 fw-bold text-gray-900 pt-5" for="password">Clave</label>
                            </div>
                            <input class="form-control form-control-lg form-control-solid" type="password" id="password"
                                name="password" autocomplete="off">
                        </div>
                        <!--end::Form group-->

                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button id="boton1" type="submit"
                                class="btn btn-primary fw-bold fs-5 px-8 py-4 my-3 me-3">Ingresar</button>
                        </div>
                        <!--end::Action-->
                        <input type="hidden">
                    </form>
                    <!--end::Signin Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
    <!--begin::Engage drawers-->
</x-guest-layout>