import TomSelect from 'tom-select';

import 'tom-select/dist/css/tom-select.css'

document.querySelectorAll('.js-select').forEach(el => {
  new TomSelect(el, {
    create: true
  });
})

document.querySelectorAll('.js-select-only').forEach(el => {
  new TomSelect(el, {
    create: false
  });
})