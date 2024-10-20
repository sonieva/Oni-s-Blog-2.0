// Santi Onieva

function enviarFormulario() {
  const formData = new FormData(document.getElementById('form-afegir'));

  fetch('api/preview-article.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text())
  .then(data => {
    const article = JSON.parse(data);

    previewTitol.innerText = article.titol ?? 'Títol de l\'article';
    
    if (article.cos && article.cos.length > 100) {
      previewCos.innerText = article.cos.slice(0, 100) + '...';

      if (document.getElementsByClassName('read-more-preview').length === 0) {
        const readMore = document.createElement('a');
        readMore.classList.add('read-more-preview');
        readMore.id = 'continua-llegint-preview';
        readMore.innerHTML = 'Continua llegint <i class="fa-solid fa-arrow-right"></i>';
        
        articleBody.appendChild(readMore);
      }
    } else {
      previewCos.innerText = article.cos ?? 'Cos de l\'article';

      if (document.getElementById('continua-llegint-preview')) {
        articleBody.removeChild(document.getElementById('continua-llegint-preview'));
      }
    }
    
    if (article.imatge) {
      previewImatge.src = article.imatge.slice(3);
      
    }
  })
  .catch(error => console.error('Error:', error));
}

const titolArticle = document.getElementById('titolArticle');
const cosArticle = document.getElementById('cosArticle');
const imatgeArticle = document.getElementById('imatge-input');

const previewTitol = document.getElementById('titol-preview');
const previewCos = document.getElementById('cos-preview');
const previewImatge = document.getElementById('imatge-preview');
const articleBody = document.getElementById('article-body');

const linkPosat = false;

if (titolArticle && cosArticle && imatgeArticle) {
  titolArticle.addEventListener('input', enviarFormulario);
  cosArticle.addEventListener('input', enviarFormulario);
  imatgeArticle.addEventListener('change', enviarFormulario);
}