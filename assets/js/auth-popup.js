// Santi Onieva

function authPopup(provider) {
  var authWindow = window.open(`https://oni.cat/auth/${provider}.php`, 'authWindow', 'width=400,height=600,scrollbars=yes');
  
  window.closeAuthWindow = function () {
    authWindow.close();
  }

  return false;
}