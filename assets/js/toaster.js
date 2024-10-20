// Santi Onieva

// Quan la finestra del navegador es carrega, executa aquesta funció
window.onload = function() {
  // Selecciona l'element HTML amb l'ID "toaster"
  var toaster = document.getElementById("toaster");

  // Comprova si l'element "toaster" existeix i si el seu contingut no està buit
  if (toaster && toaster.innerHTML.trim() !== '') {
      // Afegeix la classe "show" a l'element "toaster" per mostrar-lo
      toaster.classList.add("show");

      // Programa una funció per eliminar la classe "show" després de 3 segons (3000 mil·lisegons)
      setTimeout(function() {
          toaster.classList.remove("show");
      }, 3000);
  }
};
