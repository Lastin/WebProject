function checkUser(input) {
  var username = input.value;
  var info = document.getElementById("username_info");
  if(username == '') {
    info.innerHTML = '';
    info.style.background = "white";
    return;
  }
  else if(!validateString(username)){
    info.innerHTML = 'Username can only contain letters';
    return;
  }
  $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "/mm306/socialNetwork/actions/checkUserExists.php",
    data: {username : username}
  }).done(function(responseText){
    if(responseText == 0){
      info.innerHTML = "Username is available";
      info.style.background = "#87FFAB";
    } else {
      info.innerHTML = "Username is not available";
      info.style.background = "#FF6E6E";
    }
  });
}

function registerUser(){
  if(!validateForm())
    return false;
  $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "/mm306/socialNetwork/actions/register.php",
    data: $("form#registerForm").serialize()
  }).done(function(responseText){
    console.log(responseText);
    if(responseText == 1){
      location.reload();
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
      pass1.style.background = "#FF6E6E";
      pass2.style.background = "#FF6E6E";
      document.getElementById("error_box").innerHTML = "Password must be at least 6 characters long";
      document.getElementById("error_box").style.background = "#FF6E6E";
    }
  }
}

function validateString(string){
  var letters = /^[a-zA-Z]+$/;
  if(string.match(letters))
    return true;
  return false;
}

function validateForm(){
  username = document.getElementById("username").value;
  fname = document.getElementById("fname").value;
  lname = document.getElementById("lname").value;
  if(username.value == ''){
    document.getElementById("error_box").innerHTML = "Username is required";
    document.getElementById("error_box").style.background = "#FF6E6E";
    return false;
  }
  if(fname.value == '' || lname.value == ''){
    document.getElementById("error_box").innerHTML = "First and last name are required";
    document.getElementById("error_box").style.background = "#FF6E6E";
    return false;
  }
  if(!validateString(fname) || !validateString(lname)){
    document.getElementById("error_box").innerHTML = "Use only letters for names";
    document.getElementById("error_box").style.background = "#FF6E6E";
    return false;
  }
  if(!comparePasswords()){
    document.getElementById("error_box").innerHTML = "Password must be at least 6 characters and both fields must be identical";
    document.getElementById("error_box").style.background = "#FF6E6E";
    return false;
  }
  return true;
}
