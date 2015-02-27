function tryLogin(){
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: $("#loginForm").serialize(),
    url: "/mm306/socialNetwork/actions/login.php"
  }).done(function(responseText){
    if(responseText == 1){
      location.reload();
    }
    else if(responseText == 0){
      $("#login_error_box").html("Incorrect login or password!");
      $("#login_error_box").css("background-color","#FF6E6E");
    }
  });
}

function cleanMessage(){
  $("#login_error_box").html("");
  $("#login_error_box").css("background-color","white");
}

function logout(){
  $.ajax({
    url: '/mm306/socialNetwork/actions/logout.php'
  }).done(function(){
    location.reload();
  });
}

$("#password").keyup(function(event){
    if(event.keyCode == 13){
      tryLogin();
    }
  }
);
