// Elementos HTML para el formulario de registro
const aliesRegisterInput = document.getElementById('alies-register-input');
const aliesRegisterStatus = document.getElementById('alies-register-status'); // Icono de estado
const aliasRegisterStatusMsg = document.getElementById('alias-register-status-msg'); // Mensaje de estado

// Event listener para verificar disponibilidad del alias en tiempo real
if (aliesRegisterInput) {
  aliesRegisterInput.addEventListener('input', debounce(async function() {
    const nouAlies = aliesRegisterInput.value.trim();

    // Mostrar icono de carga mientras se verifica la disponibilidad
    aliesRegisterStatus.className = 'alies-register-status-icon loading-icon fas fa-spinner';
    aliesRegisterStatus.style.display = 'inline-block';

    const disponible = await verificarDisponibilitatAlies(nouAlies);

    if (nouAlies === '') {
      // Si no hay alias ingresado, ocultar todo
      aliesRegisterStatus.style.display = 'none';
      aliasRegisterStatusMsg.textContent = '';
      return;
    }

    if (disponible) {
      // Alias disponible: mostrar tick verde
      aliesRegisterStatus.className = 'alies-register-status-icon fas fa-check-circle';
      aliesRegisterStatus.style.color = 'green';
      aliasRegisterStatusMsg.textContent = 'Alias disponible';
      aliasRegisterStatusMsg.className = 'texto-disponible';
    } else {
      // Alias no disponible: mostrar cruz roja
      aliesRegisterStatus.className = 'alies-register-status-icon fas fa-times-circle';
      aliesRegisterStatus.style.color = 'red';
      aliasRegisterStatusMsg.textContent = 'Alias no disponible';
      aliasRegisterStatusMsg.className = 'texto-no-disponible';
    }
  }, 300));

  // Event listener para ocultar el estado cuando el input pierde el foco o se presiona Enter
  aliesRegisterInput.addEventListener('blur', ocultarEstadoAlias);
  aliesRegisterInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      ocultarEstadoAlias();
    }
  });
}

// Función para verificar disponibilidad del alias
async function verificarDisponibilitatAlies(alies) {
  try {
    const response = await fetch('api/check-alies.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ alies: alies })
    });
    const data = await response.json();
    return data.disponible;
  } catch (error) {
    console.error('Error en la petició de verificació:', error);
    return false;
  }
}

// Función para ocultar el estado del alias (icono y mensaje)
function ocultarEstadoAlias() {
  aliesRegisterStatus.style.display = 'none';
  aliasRegisterStatusMsg.textContent = '';
}

// Función debounce para evitar hacer demasiadas solicitudes
function debounce(func, delay) {
  let timer;
  return function(...args) {
    clearTimeout(timer);
    timer = setTimeout(() => func.apply(this, args), delay);
  };
}
