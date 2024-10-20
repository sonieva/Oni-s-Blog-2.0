function handlePasswordToggle(event) {
  const icon = event.target;
  const passwordInput = icon.previousElementSibling;
  
  if (passwordInput && passwordInput.type === 'password') {
    passwordInput.type = 'text';
    icon.classList.replace('fa-lock', 'fa-unlock');
  } else if (passwordInput) {
    passwordInput.type = 'password';
    icon.classList.replace('fa-unlock', 'fa-lock');
  }
}

const togglePassword = document.getElementById('toggle-password');
const togglePassword2 = document.getElementById('toggle-password2');

if (togglePassword) togglePassword.addEventListener('click', handlePasswordToggle);
if (togglePassword2) togglePassword2.addEventListener('click', handlePasswordToggle);