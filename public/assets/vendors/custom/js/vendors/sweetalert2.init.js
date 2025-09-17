"use strict";
// Set defaults
swal.mixin({
	width: 400,
	heightAuto: false,
	padding: '2.5rem',
	buttonsStyling: false,
	confirmButtonClass: 'btn btn-success',
	confirmButtonColor: null,
	cancelButtonClass: 'btn btn-secondary',
	cancelButtonColor: null
});

const Toast = Swal.mixin({
  toast: true,
  customClass: {
    container: 'theme-container-class',
    popup: 'popup-class',
    header: 'header-class',
    title: 'title-class',
    closeButton: 'close-button-class',
    icon: 'icon-class',
    image: 'image-class',
    content: 'content-class',
    input: 'input-class',
    actions: 'actions-class',
    confirmButton: 'confirm-button-class',
    cancelButton: 'cancel-button-class',
    footer: 'footer-class'
  },
  // position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})