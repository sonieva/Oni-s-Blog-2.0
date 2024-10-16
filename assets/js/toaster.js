window.onload = function() {
  // Mostrar el toaster si hay un mensaje
  var toaster = document.getElementById("toaster");
  if (toaster && toaster.innerHTML.trim() !== '') {
      toaster.classList.add("show");
      // Ocultar el toaster después de 3 segundos
      setTimeout(function(){ toaster.classList.remove("show"); }, 3000);
  }
};