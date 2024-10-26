// Santi Onieva

// Selecciona els elements HTML necessaris per editar el nom complet
const nomText = document.getElementById('nom-text'); // Element que mostra el nom complet
const nomInput = document.getElementById('nom-input'); // Input per editar el nom complet
const btnEditNom = document.getElementById('btn-edit-perfil'); // Botó per editar el nom

// Afegim un event listener per quan es fa clic al botó d'editar
if (btnEditNom) {
  btnEditNom.addEventListener('click', () => {
    // Oculta el text actual i mostra l'input per editar
    nomText.style.display = 'none';
    nomInput.style.display = 'inline-block';
    nomInput.focus(); // Fa que l'input tingui el focus automàticament
  });
}

// Afegim un event listener per quan l'input perd el focus (blur)
if (nomInput) {
  nomInput.addEventListener('blur', () => {
    // Obté el valor de l'input i si està buit, assigna "No configurat"
    const nouNom = nomInput.value.trim() || 'No configurat';

    // Actualitza el text amb el nou nom i torna a mostrar el text, amagant l'input
    nomText.textContent = nouNom;
    nomText.style.display = 'inline-block';
    nomInput.style.display = 'none';

    // Fa una petició `fetch` a l'API per actualitzar el nom complet a la base de dades
    fetch('api/update-profile.php', {
      method: 'POST', // Fa una petició de tipus POST
      headers: {
        'Content-Type': 'application/json', // Indica que l'enviament de dades és en format JSON
      },
      body: JSON.stringify({ nom_complet: nouNom }) // Converteix el nom complet en JSON i l'envia
    })
    .catch(error => console.error('Error en la petició:', error)); // Gestiona els errors de la petició
  });
}