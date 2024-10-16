// Santi Onieva

const imatgeInput = document.getElementById('imatge-input');
const btnImatge = document.getElementById('btn-imatge');
const nomImatge = document.getElementById('nom-imatge');

btnImatge.addEventListener('click', () => {
    imatgeInput.click();
});

imatgeInput.addEventListener('change', () => {
  if (imatgeInput.files.length > 0) {
    nomImatge.textContent = imatgeInput.files[0].name;
  }
});