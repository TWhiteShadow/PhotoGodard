
const eyePassword = document.getElementById("eyePassword");
eyePassword && (() => {
    eyePassword.addEventListener('click', () => {
        var password = document.getElementById("form_password");
        if (password.type === "password") {
            password.type = "text";
            document.getElementById("eyePassword").classList = 'fa-regular relative fa-eye text-[20px] cursor-pointer';
        } else {
            password.type = "password";
            document.getElementById("eyePassword").classList = 'fa-regular relative fa-eye-slash text-[20px] cursor-pointer left-[-1px]';
        }
    });
})();