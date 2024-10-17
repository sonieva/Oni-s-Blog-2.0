// Santi Onieva

const imatgeInput = document.getElementById('imatge-input');
const btnImatge = document.getElementById('btn-imatge');
const nomImatge = document.getElementById('nom-imatge');

if (btnImatge) {
  btnImatge.addEventListener('click', () => {
      imatgeInput.click();
  });
}

if (imatgeInput && nomImatge) {
  imatgeInput.addEventListener('change', () => {
    if (imatgeInput.files.length > 0) {
      nomImatge.textContent = imatgeInput.files[0].name;
    }
  });
}