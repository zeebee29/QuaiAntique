document.addEventListener('DOMContentLoaded', function () {
  const alert = document.getElementById('message-box');

  alert.addEventListener('click', function () {
      alert.style.opacity = 0; 
  });
});
