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
  if($(document).width() < ($("#chatBoxesContainer").width() + 400)){
    removeChatBox(addedChatBoxes[0]);
    addedChatBoxes.shift();
  }
  if($("#"+identifier).length){
    removeChatBox(identifier);
  } else {
    $("#chatBoxesContainer").append(makeChatBox(identifier, friend_name));
    addedChatBoxes.push(identifier);
    getMessages(friend_id, 0);
    $("#"+identifier+"chatInput").keyup(function(event){
      if(event.keyCode == 13){
        sendChatMessage("#"+identifier+"chatInput");
      }
    });
    var message_table = "#"+identifier+"messagesTable";
    $(message_table).scroll(function(){
      console.log($(message_table).scrollTop());
    });
    $("#"+identifier).slideDown();
  }
}


function makeChatBox(identifier, friend_name){
  return "<div class=chatBox id="+identifier+"><div class=chatTitle><div class=chatCloseBtn><a href='#' onclick='removeChatBox(\""+identifier+"\")'>x</a></div><div class=chatRecipient>"+friend_name+"</div></div><div class=chatContent><div class=chatMessages><table id="+identifier+"messagesTable></table></div><div class=chatInput><textarea id="+identifier+"chatInput type='text' name='typedMessage' placeholder='type message here'></textarea></div></div></div></div>";
}

function sendChatMessage(caller){
  alert($(caller).val());
}

function removeChatBox(identifier){
  $("#"+identifier).slideUp(function(){
    $("#"+identifier).remove();
  });
}


function makeMessage(time, content, message_id){
  return "<tr id="+message_id+"><td class=chatMessageTime>"+time+"</td><td>"+content+"</td></tr>"
}


function getMessages(friend_id, message_id){
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: {
      friend_id : friend_id,
      message_id : message_id
    },
    url: 'http://localhost/actions/getMessages.php',
    success: function(data){
      console.log(data);
    }
  });
}
