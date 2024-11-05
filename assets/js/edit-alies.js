// Elementos HTML
const aliesTitol = document.getElementById('alies-titol');
const aliesText = document.getElementById('alies-text');
const aliesInput = document.getElementById('alies-input');
const btnEditAlies = document.getElementById('btn-edit-alies-perfil');
const headerNom2 = document.getElementById('header-nom');
const aliesStatus = document.getElementById('alies-status'); // Icono de estado
const aliasStatusMsg = document.getElementById('alias-status-msg'); // Mensaje de estado

// Event listener para editar el alias
if (btnEditAlies) {
  btnEditAlies.addEventListener('click', () => {
    aliesText.style.display = 'none';
    aliesInput.style.display = 'inline-block';
    aliesInput.value = aliesText.textContent.trim();
    aliesInput.focus();
  });
}

// Event listener para verificar disponibilidad del alias en tiempo real
if (aliesInput) {
  aliesInput.addEventListener('input', debounce(async function() {
    const nouAlies = aliesInput.value.trim();

    // Mostrar icono de carga mientras se verifica la disponibilidad
    aliesStatus.className = 'alies-status-icon loading-icon fas fa-spinner';
    aliesStatus.style.display = 'inline-block';

    const disponible = await verificarDisponibilitatAlies(nouAlies);

    if (nouAlies === '') {
      // Si no hay alias ingresado, ocultar todo
      aliesStatus.style.display = 'none';
      aliasStatusMsg.textContent = '';
      return;
    }

    if (disponible || nouAlies === aliesText.textContent) {
      // Alias disponible: mostrar tick verde
      aliesStatus.className = 'alies-status-icon fas fa-check-circle';
      aliesStatus.style.color = 'green';
      aliasStatusMsg.textContent = 'Alias disponible';
      aliasStatusMsg.className = 'texto-disponible';
    } else {
      // Alias no disponible: mostrar cruz roja
      aliesStatus.className = 'alies-status-icon fas fa-times-circle';
      aliesStatus.style.color = 'red';
      aliasStatusMsg.textContent = 'Alias no disponible';
      aliasStatusMsg.className = 'texto-no-disponible';
    }
  }, 300));

  // Event listener para guardar el alias al perder el foco o presionar Enter
  aliesInput.addEventListener('blur', () => {
    canviarAlies();
    ocultarEstadoAlias();
  });

  aliesInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      canviarAlies();
      ocultarEstadoAlias();
    }
  });
}

// Función para cambiar el alias
function canviarAlies() {
  const oldAlies = aliesText.textContent; // Guarda el alias actual antes de cambiarlo
  let nouAlies = aliesInput.value.trim();
  nouAlies = (nouAlies === '') ? oldAlies : nouAlies;

  verificarDisponibilitatAlies(nouAlies)
    .then(disponible => {
      if (!disponible && nouAlies !== oldAlies) {
        alert('Aquest alies ja està en ús. Si us plau, tria un altre.');
        aliesInput.focus();
        return;
      }

      // Actualiza el texto con el nuevo alias y oculta el input
      aliesText.textContent = nouAlies;
      aliesTitol.innerHTML = nouAlies;
      aliesText.style.display = 'inline-block';
      aliesInput.style.display = 'none';

      if (headerNom2.innerHTML == oldAlies) headerNom2.innerHTML = nouAlies;

      // Realiza una petición `fetch` a la API para actualizar el alias en la base de datos
      fetch('api/update-profile.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ alies: nouAlies })
      })
      .catch(error => console.error('Error en la petició:', error));
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
  aliesStatus.style.display = 'none';
  aliasStatusMsg.textContent = '';
}

// Función debounce para evitar hacer demasiadas solicitudes
function debounce(func, delay) {
  let timer;
  return function(...args) {
    clearTimeout(timer);
    timer = setTimeout(() => func.apply(this, args), delay);
  };
}
