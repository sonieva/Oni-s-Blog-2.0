// Santi Onieva

// Funció que gestiona el canvi de tipus de l'input de contrasenya
function handlePasswordToggle(event) {
  // Obté l'icona que ha disparat l'esdeveniment de clic
  const icon = event.target;

  // Selecciona l'element input que està just abans de l'icona
  const passwordInput = icon.previousElementSibling;

  // Comprova si l'input és de tipus 'password'
  if (passwordInput && passwordInput.type === 'password') {
    // Canvia el tipus de l'input a 'text' per mostrar la contrasenya
    passwordInput.type = 'text';
    // Canvia la icona de 'fa-lock' a 'fa-unlock'
    icon.classList.replace('fa-lock', 'fa-unlock');
  } else if (passwordInput) {
    // Si no, torna a canviar el tipus de l'input a 'password' per amagar la contrasenya
    passwordInput.type = 'password';
    // Canvia la icona de 'fa-unlock' a 'fa-lock'
    icon.classList.replace('fa-unlock', 'fa-lock');
  }
}

// Obté els elements de les icones per canviar el tipus de les contrasenyes
const togglePassword = document.getElementById('toggle-password');
const togglePassword2 = document.getElementById('toggle-password2');

// Si l'icona per mostrar/amagar la contrasenya existeix, afegeix un listener al clic
if (togglePassword) togglePassword.addEventListener('click', handlePasswordToggle);
if (togglePassword2) togglePassword2.addEventListener('click', handlePasswordToggle);
