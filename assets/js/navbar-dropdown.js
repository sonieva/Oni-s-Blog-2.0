// Santi Onieva

const toggler = document.getElementById('dropdown-toggle');
const dropdown = document.getElementById('dropdown');
const caretIcon = document.getElementById('caret');

if (toggler && dropdown && caretIcon) {
  toggler.addEventListener('click', () => {
    dropdown.classList.toggle('show');

    if (dropdown.classList.contains('show')) {
      caretIcon.classList.replace('fa-caret-left', 'fa-caret-down');
    } else {
      caretIcon.classList.replace('fa-caret-down', 'fa-caret-left');
    }
  });
}

window.onclick = function(event) {
  if (event.target.id !== 'dropdown-toggle' && event.target.id !== 'caret') {
    dropdown.classList.remove('show');
    caretIcon.classList.replace('fa-caret-down', 'fa-caret-left');
  }
};