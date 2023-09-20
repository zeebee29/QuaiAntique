document.addEventListener('DOMContentLoaded', function () {
  const alertSuccess = document.getElementById('message-success');
  const alertWarning = document.getElementById('message-warning');

  if (alertSuccess) {
    alertSuccess.addEventListener('click', function () {
      alertSuccess.style.opacity = 0; 
    });
  }
  if (alertWarning) {
    alertWarning.addEventListener('click', function () {
      alertWarning.style.opacity = 0; 
    });
  }
});
