// Santi Onieva

// Selecciona els elements HTML necessaris per gestionar el menú desplegable
const toggler = document.getElementById('dropdown-toggle');
const dropdown = document.getElementById('dropdown');
const caretIcon = document.getElementById('caret');

// Comprova si els elements existeixen abans d'afegir els listeners
if (toggler && dropdown && caretIcon) {
  // Afegeix un event listener al botó que activa el desplegable
  toggler.addEventListener('click', () => {
    // Alterna la classe 'show' per mostrar o amagar el contingut del desplegable
    dropdown.classList.toggle('show');

    // Canvia la icona del caret segons l'estat del desplegable
    if (dropdown.classList.contains('show')) {
      caretIcon.classList.replace('fa-caret-left', 'fa-caret-down');
    } else {
      caretIcon.classList.replace('fa-caret-down', 'fa-caret-left');
    }
  });

  const fills = toggler.children;
  
  for (let i = 0; i < fills.length; i++) {
    fills[i].addEventListener('click', (event) => {
      event.stopPropagation();
      // Alterna la classe 'show' per mostrar o amagar el contingut del desplegable
      dropdown.classList.toggle('show');

      // Canvia la icona del caret segons l'estat del desplegable
      if (dropdown.classList.contains('show')) {
        caretIcon.classList.replace('fa-caret-left', 'fa-caret-down');
      } else {
        caretIcon.classList.replace('fa-caret-down', 'fa-caret-left');
      }
    });
  }
}

// Funció per tancar el desplegable si es fa clic fora d'ell
window.onclick = function(event) {
  // Comprova si l'element clicat no és el botó del desplegable ni la icona del caret
  if (event.target.id !== 'dropdown-toggle' && event.target.id !== 'caret') {
    // Amaga el contingut del desplegable i canvia la icona del caret a l'estat inicial
    dropdown.classList.remove('show');
    caretIcon.classList.replace('fa-caret-down', 'fa-caret-left');
  }
};
