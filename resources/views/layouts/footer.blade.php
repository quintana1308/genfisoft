<footer class="footer footer-black  footer-white ">
    <div class="container-fluid">
        <div class="row">
            <!--<nav class="footer-nav">
                <ul>
                    <li>
                        <a href="#" target="_blank">{{ __('Item Footer') }}</a>
                    </li>
                </ul>
            </nav>-->
            <div class="credits ml-auto">
                <span class="copyright @if(Auth::guest()) text-white @endif">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>{{ __(', Desarrollado por ') }}<a class="text-white" href="#" target="_blank">{{ __('Quingoz Digital Marketing Agency') }}</a>
                </span>
            </div>
        </div>  
    </div>
</footer>