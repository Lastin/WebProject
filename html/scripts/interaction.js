$(window).resize(function(){
  if(window.innerWidth < 1600){
    $("#right-panel").addClass("right-panel-top");
    $("#right-panel").removeClass("right-panel");
  }
  else {
    $("#right-panel").removeClass("right-panel-top");
    $("#right-panel").addClass("right-panel");
  }
});


$(".tab-tile").click(function(){
  $(".tab-tile").removeClass("active");
  $(this).addClass("active");
});

$("#mates-tab-btn").click(function(){
  $("#mates").show();
  $("#search").hide();
  $("#messages").hide();
});

$("#search-tab-btn").click(function(){
  $("#mates").hide();
  $("#search").show();
  $("#messages").hide();
});

$("#msg-tab-btn").click(function(){
  $("#mates").hide();
  $("#search").hide();
  $("#messages").show();
});

$(document).ready(function(){
  $("#mates").show();
  $("#search").hide();
  $("#messages").hide();
});



function popChatWith(friend_id, friend_name){
  var identifier = friend_id+"chatBox";
  if($("#"+identifier).length){
    $("#"+identifier).show();
  } else {
    //alert($("#chatBoxesContainer").width());
    alert($(document).width());
    if($(document).width() > ($("#chatBoxesContainer").width() + 400)){
      $("#chatBoxesContainer").append(makeChatBox(identifier, friend_name));
      $("#"+identifier+"chatInput").keyup(function(event){
        if(event.keyCode == 13){
          alert("enter on input"+identifier+"chatInput was pressed");
        }
      });
    }
  }
}


function makeChatBox(identifier, friend_name){
  return "<div class=chatBox id="+identifier+"><div class=chatTitle><div class=chatCloseBtn><a href='#' onclick='$(\"#"+identifier+"\").hide()'>x</a></div><div class=chatRecipient>"+friend_name+"</div></div><div class=chatContent><div class=chatMessages><table id="+identifier+"messagesTable></table></div><div id=chatInput><form action='#'><input id="+identifier+"chatInput type='text' name='typedMessage' placeholder='type message here'></form></div></div></div>";
}

function hideChatBox(){
  $("#chatBox").hide();
}


function makeMessage(time, content){
  return "<tr><td class=chatMessageTime>"+time+"</td><td>"+content+"</td></tr>"
}
