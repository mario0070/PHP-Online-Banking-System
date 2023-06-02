
function toggle_sidebar(){
    var sidebar = document.getElementById("sidebar")
    var btn_toggle = document.getElementById("btn-toggle")
    sidebar.classList.toggle("active")
}


// Toggle balance
function Togglebal() {
    var bal = document.getElementById("bal");
    var balc = document.getElementById("balc");
    var eye = document.getElementById("eye");
    if (bal.innerHTML === balc.innerHTML) {
      bal.innerHTML = "****";
    } else {
      bal.innerHTML = balc.innerHTML;
    }
    
    eye.classList.toggle('fa-eye-slash');
}


// set random greetings
var date = new Date();
// var getMins = date.getMinutes();
var time = date.getHours();

if(time >= 19 && time <= 24){
  document.getElementById("randGreetings").innerHTML = "Good Evening";
}
else if(time >= 1 && time < 12){
  document.getElementById("randGreetings").innerHTML = "Good Morning";
}
else if(time >= 12 && time < 19){
  document.getElementById("randGreetings").innerHTML = "Good Afternoon";
}

