        const form = document.getElementById('registerForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const passwordError = document.getElementById('passwordError');

        form.addEventListener('submit', function (event) {
            if (password.value !== confirmPassword.value) {
                event.preventDefault();
                passwordError.classList.remove('d-none');
                confirmPassword.classList.add('is-invalid');
            }
        });

        confirmPassword.addEventListener('input', function () {
            if (password.value === confirmPassword.value) {
                passwordError.classList.add('d-none');
                confirmPassword.classList.remove('is-invalid');
            }
        });