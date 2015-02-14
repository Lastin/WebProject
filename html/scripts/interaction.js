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
    var table_id = "#"+identifier+"messagesTable";
    var table_container_id = "#"+identifier+"tableContainer";
    getMessages(friend_id, -1, table_id, table_container_id);
    $("#"+identifier+"chatInput").keyup(function(event){
      if(event.keyCode == 13){
        sendChatMessage("#"+identifier+"chatInput");
      }
    });

    $(table_container_id).scroll(function(){
    });
    $("#"+identifier).slideDown();
  }
}


function makeChatBox(identifier, friend_name){
  return "<div class=chatBox id="+identifier+"><div class=chatTitle><div class=chatCloseBtn><a href='#' onclick='removeChatBox(\""+identifier+"\")'>x</a></div><div class=chatRecipient>"+friend_name+"</div></div><div class=chatContent><div class=chatMessages><div id="+identifier+"tableContainer class=tableContainer><table id="+identifier+"messagesTable></table></div></div><div class=chatInput><textarea id="+identifier+"chatInput type='text' name='typedMessage' placeholder='type message here'></textarea></div></div></div></div>";
}

function sendChatMessage(caller){
  alert($(caller).val());
}

function removeChatBox(identifier){
  $("#"+identifier).slideUp(function(){
    $("#"+identifier).remove();
  });
}

function getMessages(friend_id, message_id, table_id, table_container_id){
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: {
      friend_id : friend_id,
      message_id : message_id
    },
    url: 'http://localhost/actions/getMessages.php',
    success: function(data){
      addMessagesToTable(data, table_id, friend_id);
      $(table_container_id).scrollTop($(table_container_id).height()+200);
      //var array = $.parseJSON(data);
      //addMessagesToTable(array, table);
    }
  });
}

function addMessagesToTable(data, table_id, friend_id){
  for(i = 0; i < data.length; i++){
    var message = data[i]['message'];
    var message_id = data[i]['message_id'];
    var sender_id = data[i]['sender_id'];
    var sender = "me";
    if(sender_id == friend_id){
      var sender = "friend";
    }
    var message = makeMessage(message, message_id, sender);
    $(message).prependTo($(table_id));
  }
  //prependTo("table > tbody");
}

function makeMessage(message, message_id, sender){
  return "<tr id="+message_id+"><td class='chatMessageTime'></td><td class='"+sender+" chatMessage'>"+message+"</td></tr>";
}
