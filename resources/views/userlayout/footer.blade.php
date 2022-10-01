    <!-- Javascript  -->
    <!-- Sweet-Alert  -->
    <script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/pages/sweet-alert.init.js')}}"></script>
    <!-- App js -->
    <script src="assets/js/app.js"></script>
    @yield('scripts')
    <script>
        function showCol() {
            var element = document.getElementById("orderDetailsCol");
            element.classList.remove("d-none");
        }
    </script>
</body>

</html>
