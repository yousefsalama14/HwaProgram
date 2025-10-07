    <!-- Javascript  -->
    <!-- Sweet-Alert  -->
    <script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/pages/sweet-alert.init.js')}}"></script>
    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>
    @yield('scripts')
    <script>
        function showCol() {
            var element = document.getElementById("orderDetailsCol");
            if (!element) {
                return true;
            }
            element.classList.remove("d-none");
            return true;
        }
    </script>
</body>

</html>
