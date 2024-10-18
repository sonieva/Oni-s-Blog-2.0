// Santi Onieva

window.onload = function() {
  var toaster = document.getElementById("toaster");
  if (toaster && toaster.innerHTML.trim() !== '') {
      toaster.classList.add("show");
      setTimeout(function(){ toaster.classList.remove("show"); }, 3000);
  }
};