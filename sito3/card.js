var img_logo = "<?php echo $_POST['logo']; ?>";
var img_utente = "<?php echo $_POST['immagine']; ?>";
var nome = "<?php echo $_POST['nome']; ?>";
var cognome = "<?php echo $_POST['cognome']; ?>";
var occupazione = "<?php echo $_POST['occupazione']; ?>";
var telefono = "<?php echo $_POST['telefono']; ?>";
var email = "<?php echo $_POST['email']; ?>";
var img_posizione = "<?php echo $_POST['posizione']; ?>"

document.querySelector('header h2').innerHTML = nome + ' ' + cognome;
document.querySelector('header img').src = img_logo;
document.querySelector('article img').src = img_utente;
document.querySelector('article p').innerHTML = '<strong>' + occupazione + '</strong>' + '<br><strong>Tel</strong>: ' + telefono + '<br><strong>Mail</strong>: ' + email;

if (img_posizione == "sinistra") {
  document.querySelector('article img').style.float = "left";
 } else {
  document.querySelector('article img').style.float = "right";
} 
