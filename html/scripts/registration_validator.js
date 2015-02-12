function checkUser(input) {
  var username = input.value;
  var info = document.getElementById("username_info");
  if(username == '') {
    info.innerHTML = '';
    info.style.background = "white";
    return;
  }
  $.ajax({
    type: "POST",
    url: "http://localhost/actions/checkUserExists.php",
    data: {username : username}
  }).done(function(msg){
    if(msg == "true"){
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
  if(pass1.value == "" || pass2.value == ""){
    pass1.style.background = "white";
    pass2.style.background = "white";
    return;
  }
  if(pass1.value != "" && pass2.value != "" && pass1.value != pass2.value){
    pass1.style.background = "#FF6E6E";
    pass2.style.background = "#FF6E6E";
  } else {
    if(pass1.value.length>5){
      pass1.style.background = "#87FFAB";
      pass2.style.background = "#87FFAB";
      return true;
    } else {
      document.getElementById("error_box").innerHTML = "Password must be at least 6 characters long";
      document.getElementById("error_box").style.background = "#FF6E6E";
    }
  }
}

function validateName(name){
  var letters = /^[a-zA-Z]+$/;
  if(name.value.match(letters))
    return true;
  return false;
}

function validateForm(){
  username = document.getElementById("username");
  fname = document.getElementById("fname");
  lname = document.getElementById("lname");
  if(fname.value == '' || lname.value == ''){
    document.getElementById("error_box").innerHTML = "First and last name are required";
    document.getElementById("error_box").style.background = "#FF6E6E";
    return false;
  }
  if(!validateName(fname) || !validateName(lname)){
    document.getElementById("error_box").innerHTML = "Use only letters for names";
    document.getElementById("error_box").style.background = "#FF6E6E";
    return false;
  }
  if(!comparePasswords()){
    document.getElementById("error_box").innerHTML = "Password required";
    document.getElementById("error_box").style.background = "#FF6E6E";
    return false;
  }
  return true;
}
