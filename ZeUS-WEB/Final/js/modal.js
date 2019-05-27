var modal = document.getElementById('myModal');
var modal2 = document.getElementById('myModal2');
var btn = document.getElementById("myBtn");
var consultabtn = document.getElementById("consultaBtn");
var span = document.getElementsByClassName("close")[0];
var bol = "<?php echo $_SESSION['errormodal']; ?>";


btn.onclick = function() {
  modal.style.display = "block";  
}

consultaBtn.onclick = function() {
  modal2.style.display = "block";  
}

span.onclick = function() {
  modal.style.display = "none";
  modal2.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
}
window.onload = function(event){
  if(bol=="TRUE") {
    modal.style.display = "block";
    modal2.style.display ="block";
  }
}