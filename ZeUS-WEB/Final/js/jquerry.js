$(document).ready(function(){
  $("#creditos").click(function(){
    $(this).hide();
    $("#texto").show();
  });
});

$("#email").on({
  mouseenter: function(){ 
    $("#email").css("background-color", "rgba(148, 76, 184, 0.349)");
   },
   mouseleave: function(){ 
    $("#email").css("background-color", "transparent");
   }
  });

  $("#pass").on({
    mouseenter: function(){ 
      $("#pass").css("background-color", "rgba(148, 76, 184, 0.349)");
     },
     mouseleave: function(){ 
      $("#pass").css("background-color", "transparent");
     }
    });
    /*$("#enviar").click(
    function (){
      var http = new XMLHttpRequest();
      var url = '../pagina.php';
      var params = 'email=ipsum&pass=binny';
      http.open('POST', url, true);
      http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            alert(http.responseText);
        }
    }
    http.send(params);
        });*/