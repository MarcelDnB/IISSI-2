var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
var modal2 = document.getElementById('myModal2');
var btn2 = document.getElementById("myBtn2");
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close2")[0];
var bol = "<?php echo $_SESSION['errormodal']; ?>";


btn.onclick = function() {
  modal.style.display = "block";  
}
span.onclick = function() {
  modal.style.display = "none";

}
window.onclick = function(event) {
  if (event.target == modal ||event.target == modal2 ) {
    modal.style.display = "none";
    modal2.style.display = "none";
  }
}
window.onload = function(event){
  if(bol=="TRUE") {
    modal.style.display = "block";

  }
}
btn2.onclick = function() {
  modal2.style.display = "block";  
}

span2.onclick = function() {
  modal2.style.display = "none";
}

