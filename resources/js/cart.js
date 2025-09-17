import flatpickr from "flatpickr";

document.addEventListener('DOMContentLoaded', () => {
  const dateInputs = document.querySelectorAll('.fp');
  dateInputs.forEach(input => {
    const defaultDate = input.dataset.defaultDate;
    const fp = flatpickr(input, {
      minDate: "today",
      altInput: true,
      altFormat: "M j, Y",
      defaultDate: defaultDate
    });
  });
});