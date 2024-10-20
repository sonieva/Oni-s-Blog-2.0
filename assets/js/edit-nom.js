const nomText = document.getElementById('nom-text');
const nomInput = document.getElementById('nom-input');
const btnEditNom = document.getElementById('btn-edit-nom');

btnEditNom.addEventListener('click', () => {
  nomText.style.display = 'none';
  nomInput.style.display = 'inline-block';
  nomInput.focus();
});

nomInput.addEventListener('blur', () => {
  const nouNom = nomInput.value.trim() || 'No configurat';

  nomText.textContent = nouNom;
  nomText.style.display = 'inline-block';
  nomInput.style.display = 'none';

  fetch('api/update-profile.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ nom_complet: nouNom })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Nombre actualizado con éxito');
    } else {
      console.error('Error al actualizar el nombre');
    }
  })
  .catch(error => console.error('Error en la petición:', error));
});