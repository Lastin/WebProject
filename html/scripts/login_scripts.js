function tryLogin(){
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: $("#loginForm").serialize(),
    url: "http://localhost/actions/login.php"
  }).done(function(responseText){
    if(responseText == 1){
      location.reload();
    }
    else if(responseText == 0){

    }
  });
}

function logout(){
  $.ajax({
    url: 'http://localhost/actions/logout.php'
  }).done(function(){
    location.reload();
  });
}
