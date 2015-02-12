function checkUser(input) {
  var user = input.value;
  var info = document.getElementById("username_info");
  if(user == '') {
    info.innerHTML = '';
    info.style.background = "white";
    return;
  }
  $.ajax({
    type: "POST",
    url: "http://localhost/actions/checkUser.php",
    data: {username : user}
  }).done(function(msg){
    if(msg == "taken"){
      info.innerHTML = "Username is not available";
      info.style.background = "#FF6E6E";
    } else {
      info.innerHTML = "Username is available";
      info.style.background = "#87FFAB";
    }
  });
}

function comparePasswords(){
  var pass1 = document.getElementById("pass1");
  var pass2 = document.getElementById("pass2");
  if(pass1.value == ""){

  }
  if(pass1.value != pass2.value){
    pass1.style.background = "#FF6E6E";
    pass2.style.background = "#FF6E6E";
  } else {
    pass1.style.background = "white";
    pass2.style.background = "white";
  }
}
