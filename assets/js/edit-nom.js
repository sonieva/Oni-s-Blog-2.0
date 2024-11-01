// Santi Onieva

function canviarNom() {
  // Obté el valor de l'input i si està buit, assigna "No configurat"
  let nouNom = nomInput.value.trim() || 'No configurat';

  // Actualitza el text amb el nou nom i torna a mostrar el text, amagant l'input
  nomText.textContent = nouNom;
  nomText.style.display = 'inline-block';
  nomInput.style.display = 'none';

  nouNom = (nouNom == 'No configurat') ? null : nouNom; // Si el nou nom és "No configurat", assigna null
  if (nouNom) headerNom.innerHTML = nouNom; // Si el nou nom no és null, actualitza el nom al header

  // Fa una petició `fetch` a l'API per actualitzar el nom complet a la base de dades
  fetch('api/update-profile.php', {
    method: 'POST', // Fa una petició de tipus POST
    headers: {
      'Content-Type': 'application/json', // Indica que l'enviament de dades és en format JSON
    },
    body: JSON.stringify({ nom_complet: nouNom, editant: 'nom_complet' }) // Converteix el nom complet en JSON i l'envia
  })
  .catch(error => console.error('Error en la petició:', error)); // Gestiona els errors de la petició
}

// Selecciona els elements HTML necessaris per editar el nom complet
const nomText = document.getElementById('nom-text'); // Element que mostra el nom complet
const nomInput = document.getElementById('nom-input'); // Input per editar el nom complet
const btnEditNom = document.getElementById('btn-edit-nom-perfil'); // Botó per editar el nom
const headerNom = document.getElementById('header-nom'); // Element que mostra el nom complet al header

// Afegim un event listener per quan es fa clic al botó d'editar
if (btnEditNom) {
  btnEditNom.addEventListener('click', () => {
    // Oculta el text actual i mostra l'input per editar
    nomText.style.display = 'none';
    nomInput.style.display = 'inline-block';
    nomInput.value = nomText.textContent; // Assigna el text actual a l'input
    nomInput.focus(); // Fa que l'input tingui el focus automàticament
  });
}

// Afegim un event listener per quan l'input perd el focus (blur)
if (nomInput) {
  nomInput.addEventListener('blur', canviarNom);
  nomInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') canviarNom();
  });
}