document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('authPasswordToggle');
    const input = document.getElementById('authPassword');
    if (!toggle || !input) return;

    toggle.addEventListener('click', function () {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        toggle.classList.toggle('ri-eye-line', !isPassword);
        toggle.classList.toggle('ri-eye-off-line', isPassword);
    });
});

window.addEventListener('load', function () {
    const page = document.getElementById('loginView');
    if (page) page.classList.add('auth-loaded');
});