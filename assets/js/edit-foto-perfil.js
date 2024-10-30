function canviarFotoPerfil(imatge) {
  const formData = new FormData();
  formData.append('imatge', imatge);

  fetch('api/update-profile.php', {
    method: 'POST',
    body: formData
  })
    .catch(error => console.error('Error:', error));
}

const btnEditIcon = document.getElementById('edit-icon');
const inputFotoPerfil = document.getElementById('input-foto-perfil');
const fotoPerfil = document.getElementById('foto-perfil');
const fotoPerfilHeader = document.getElementById('foto-perfil-header');

if (btnEditIcon) {
  btnEditIcon.addEventListener('click', () => {
    inputFotoPerfil.click();
  });
}

if (inputFotoPerfil) {
  inputFotoPerfil.addEventListener('change', () => {
    const file = inputFotoPerfil.files[0];
    if (file) {
      const reader = new FileReader();

      reader.onload = function (e) {
        fotoPerfilHeader.src = e.target.result;
        fotoPerfil.src = e.target.result;
        console.log(e.target.result);
      };

      reader.readAsDataURL(file);

      canviarFotoPerfil(file);
    }
  });
}