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

        // Function to update cart counter
        function updateCartCounter() {
            fetch('{{ route("user.cart.count") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const cartBadge = document.querySelector('.badge.bg-danger');
                if (cartBadge) {
                    cartBadge.textContent = data.count;
                    if (data.count > 0) {
                        cartBadge.style.display = 'block';
                    } else {
                        cartBadge.style.display = 'none';
                    }
                }
            })
            .catch(error => {
                console.log('Error updating cart counter:', error);
                // Fallback: try to get count from DOM if available
                const cartBadge = document.querySelector('.badge.bg-danger');
                if (cartBadge && cartBadge.textContent === '0') {
                    cartBadge.style.display = 'none';
                }
            });
        }

        // Update cart counter when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCounter();
        });

        // Listen for custom cart update events
        document.addEventListener('cartUpdated', function() {
            updateCartCounter();
        });
    </script>
</body>

</html>
