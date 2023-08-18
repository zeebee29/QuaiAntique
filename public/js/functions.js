const togglePassword = () => {
  console.log(document)
  const passwordInput = document.querySelector('[data-role="input-pw"]');
  const eyeIcon = document.querySelector("#eye");
  const eyeSlashIcon = document.querySelector("#eye-slash");
  passwordInput.type         = passwordInput.type === "text" ? "password" : "text"
  eyeSlashIcon.style.display = eyeSlashIcon.style.display === "none" ? "block" : "none"
  eyeIcon.style.display      = eyeIcon.style.display === "none" ? "block" : "none"
}