    <!-- Javascript  -->
    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>


    <script src="{{asset('assets/plugins/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/pages/ecommerce-index.init.js')}}"></script>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <!-- App js -->
    @yield('scripts')

</body>
<!--end body-->
</html>
