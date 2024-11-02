const inputs = document.getElementsByClassName('autocompleted')

for (let i = 0; i < inputs.length; i++) {
  inputs[i].addEventListener('focus', () => {
    if (inputs[i].classList.contains('autocompleted')) {
      inputs[i].classList.remove('autocompleted')
    }
  })
}