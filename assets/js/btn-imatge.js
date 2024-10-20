// Santi Onieva

// Obtenció dels elements HTML necessaris
const imatgeInput = document.getElementById('imatge-input'); // Input de tipus file per seleccionar una imatge
const btnImatge = document.getElementById('btn-imatge'); // Botó personalitzat per seleccionar la imatge
const nomImatge = document.getElementById('nom-imatge'); // Element per mostrar el nom de la imatge seleccionada

// Si el botó per seleccionar la imatge existeix, afegeix un event listener per obrir el selector de fitxers quan es fa clic al botó
if (btnImatge) {
  btnImatge.addEventListener('click', () => {
    imatgeInput.click(); // Fa clic programàticament al input de tipus file quan es fa clic al botó personalitzat
  });
}

// Si l'input de tipus file i l'element per mostrar el nom de la imatge existeixen, afegeix un event listener per mostrar el nom de la imatge seleccionada
if (imatgeInput && nomImatge) {
  imatgeInput.addEventListener('change', () => {
    // Si hi ha algun fitxer seleccionat, actualitza el text de 'nomImatge' amb el nom del fitxer
    if (imatgeInput.files.length > 0) {
      nomImatge.textContent = imatgeInput.files[0].name;
    }
  });
}
