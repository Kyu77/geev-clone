import './bootstrap';

// Password visibility toggle
document.addEventListener('DOMContentLoaded', function () {
    // Toggle for edit-profile
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

    // Toggle for login
    const togglePasswordLogin = document.getElementById('togglePasswordLogin');
    const passwordLogin = document.querySelector('input[name="password"]'); // Assuming the input has name="password"

    if (togglePasswordLogin && passwordLogin) {
        togglePasswordLogin.addEventListener('click', function () {
            const type = passwordLogin.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordLogin.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }

    // Toggle for register
    const togglePasswordRegister = document.getElementById('togglePasswordRegister');
    const passwordRegister = document.querySelector('input[name="password"]'); // Assuming the input has name="password"

    if (togglePasswordRegister && passwordRegister) {
        togglePasswordRegister.addEventListener('click', function () {
            const type = passwordRegister.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordRegister.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }
});
