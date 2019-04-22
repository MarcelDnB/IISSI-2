function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("acc-show") == -1) {
    x.className += " acc-show";
    } else { 
    x.className = x.className.replace(" acc-show", "");
    }
}  
function myFunction2(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("acc-show") == -1) {
    x.className += " acc-show";
    } else { 
    x.className = x.className.replace(" acc-show", "");
    }
}  