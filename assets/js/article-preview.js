// Santi Onieva

// Funció per enviar el formulari de manera asíncrona i actualitzar la vista prèvia de l'article
function enviarFormulario() {
  // Crea un objecte FormData amb les dades del formulari amb l'ID 'form-afegir'
  const formData = new FormData(document.getElementById('form-afegir'));

  // Fa una petició HTTP POST a 'api/preview-article.php' amb les dades del formulari
  fetch('api/preview-article.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.text()) // Converteix la resposta a text
    .then(data => {
      // Converteix la resposta JSON a un objecte JavaScript
      const article = JSON.parse(data);

      // Actualitza el títol de la vista prèvia amb el títol de l'article o un text per defecte
      previewTitol.innerText = article.titol ?? 'Títol de l\'article';

      // Si el cos de l'article és més llarg de 100 caràcters, el talla i afegeix punts suspensius
      if (article.cos && article.cos.length > 100) {
        previewCos.innerText = article.cos.slice(0, 100) + '...';

        // Si no existeix un element amb la classe 'read-more-preview', crea un enllaç per continuar llegint
        if (document.getElementsByClassName('read-more-preview').length === 0) {
          const readMore = document.createElement('a');
          readMore.classList.add('read-more-preview');
          readMore.id = 'continua-llegint-preview';
          readMore.innerHTML = 'Continua llegint <i class="fa-solid fa-arrow-right"></i>';
          
          // Afegeix l'enllaç a la vista prèvia de l'article
          articleBody.appendChild(readMore);
        }
      } else {
        // Si el cos és més curt o igual a 100 caràcters, es mostra completament sense l'enllaç de "Continua llegint"
        previewCos.innerText = article.cos ?? 'Cos de l\'article';

        // Si l'enllaç de "Continua llegint" existeix, l'elimina de la vista prèvia
        if (document.getElementById('continua-llegint-preview')) {
          articleBody.removeChild(document.getElementById('continua-llegint-preview'));
        }
      }

      // Si hi ha una imatge a l'article, actualitza la font de la imatge de la vista prèvia
      if (article.imatge) {
        previewImatge.src = article.imatge.slice(3);
      }
    })
    .catch(error => console.error('Error:', error)); // Mostra un error si la petició falla
}

// Obté els elements del formulari i la vista prèvia
const titolArticle = document.getElementById('titolArticle');
const cosArticle = document.getElementById('cosArticle');
const imatgeArticle = document.getElementById('imatge-input');

const previewTitol = document.getElementById('titol-preview');
const previewCos = document.getElementById('cos-preview');
const previewImatge = document.getElementById('imatge-preview');
const articleBody = document.getElementById('article-body');

// Si els elements del formulari existeixen, afegeix els event listeners per enviar el formulari quan es canvia el contingut
if (titolArticle && cosArticle && imatgeArticle) {
  titolArticle.addEventListener('input', enviarFormulario); // Envia el formulari quan es modifica el títol
  cosArticle.addEventListener('input', enviarFormulario);   // Envia el formulari quan es modifica el cos
  imatgeArticle.addEventListener('change', enviarFormulario); // Envia el formulari quan es selecciona una imatge nova
}
