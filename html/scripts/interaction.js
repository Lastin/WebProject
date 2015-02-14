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

var addedChatBoxes = [];

function popChatWith(friend_id, friend_name){
  var identifier = friend_id+"chatBox";
  if($(document).width() > ($("#chatBoxesContainer").width() + 400)){
    //hide first element
  }
  if($("#"+identifier).length){
    removeChatBox(identifier);
  } else {
    $("#chatBoxesContainer").append(makeChatBox(identifier, friend_name));
    addedChatBoxes.push(identifier);
    $("#"+identifier+"chatInput").keyup(function(event){
      if(event.keyCode == 13){
        sendChatMessage("#"+identifier+"chatInput");
      }
    });
    $("#"+identifier).slideDown();
  }
}


function makeChatBox(identifier, friend_name){
  return "<div class=chatBox id="+identifier+"><div class=chatTitle><div class=chatCloseBtn><a href='#' onclick='removeChatBox(\""+identifier+"\")'>x</a></div><div class=chatRecipient>"+friend_name+"</div></div><div class=chatContent><div class=chatMessages><table id="+identifier+"messagesTable></table></div><div class=chatInput><input id="+identifier+"chatInput type='text' name='typedMessage' placeholder='type message here'></div></div></div></div>";
}

function sendChatMessage(caller){
  alert($(caller).val());
}

function removeChatBox(identifier){
  $("#"+identifier).slideUp(function(){
    $("#"+identifier).remove();
  });
}

function changeChatboxVisibility(identifier){

}


function makeMessage(time, content){
  return "<tr><td class=chatMessageTime>"+time+"</td><td>"+content+"</td></tr>"
}
