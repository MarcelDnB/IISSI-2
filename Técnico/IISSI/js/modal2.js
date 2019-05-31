
var modal2 = document.getElementById('myModal2');
var aux = document.querySelectorAll('.mybtn2');
var span = document.getElementsByClassName("close")[0];
var bol = "<?php echo $_SESSION['errormodal']; ?>";
var i= aux.length-1;



aux[i].onclick = function(){
  modal2.style.display = "block";  
};

span.onclick = function() {
  modal2.style.display = "none";
}

window.onclick = function(event) {

  if (event.target == modal2) {
    modal2.style.display = "none";
  }
}
window.onload = function(event){
  if(bol=="TRUE") {

    modal2.style.display ="block";
  }
}