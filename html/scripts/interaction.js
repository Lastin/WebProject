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
  var identifier = friend_id+"chat";
  var chatBox_id = identifier+"ChatBox";
  if($(document).width() < ($("#chatBoxesContainer").width() + 400)){
    removeChatBox(addedChatBoxes[0]);
    addedChatBoxes.shift();
  }
  if($("#"+chatBox_id).length){
    removeChatBox(chatBox_id);
  } else {
    $("#chatBoxesContainer").append(makeChatBox(chatBox_id, friend_name));
    addedChatBoxes.push(chatBox_id);
    var table_id = chatBox_id+"MessagesTable";
    var table_container_id = chatBox_id+"TableContainer";
    var input_id = chatBox_id+"ChatInput";
    getMessages(friend_id, -1, table_id, table_container_id);
    $("#"+input_id).keyup(function(event){
      if(event.keyCode == 13){
        sendChatMessage(input_id, table_id, friend_id, table_container_id);
      }
    });
    $("#"+table_container_id).scroll(function(){
      console.log("scrolly scrolly");
    });
    $("#"+chatBox_id).slideDown();
  }
}


function makeChatBox(chatBox_id, friend_name){
  return "<div class=chatBox id="+chatBox_id+"><div class=chatTitle><div class=chatCloseBtn><a href='#' onclick='removeChatBox(\""+chatBox_id+"\")'>x</a></div><div class=chatRecipient>"+friend_name+"</div></div><div class=chatContent><div class=chatMessages><div id="+chatBox_id+"TableContainer class=tableContainer><table id="+chatBox_id+"MessagesTable></table></div></div><div class=chatInput><textarea maxlength=4000 id="+chatBox_id+"ChatInput type='text' name='typedMessage' placeholder='type message here'></textarea></div></div></div></div>";
}

function removeChatBox(chatBox_id){
  $("#"+chatBox_id).slideUp(function(){
    $("#"+chatBox_id).remove();
  });
  var index = addedChatBoxes.indexOf(chatBox_id);
  if(index > -1)
    addedChatBoxes.splice(index, 1);
}

function getMessages(friend_id, message_id, table_id, table_container_id){
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: {
      friend_id : friend_id,
      message_id : message_id
    },
    url: "http://localhost/actions/getMessages.php",
    success: function(data){
      addMessagesToTable(data, table_id, friend_id);
      scrollToTheBottom(table_container_id);
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
    $(message).prependTo($("#"+table_id));
  }
  //prependTo("table > tbody");
}

function scrollToTheBottom(table_container_id){
  var sp = $("#"+table_container_id)
  var height = $("#"+table_container_id).height();
  var total_height = $("#"+table_container_id).scrollTop();
  sp.scrollTop(height+total_height);
}

function makeMessage(message, message_id, sender){
  return "<tr id="+message_id+"></td><td><div class='chatMessage "+sender+"'>"+message+"</div></td></tr>";
  //<td class='chatMessageTime'>
}

function addSentMessage(message, message_id, table_id){
  var message = makeMessage(message, message_id, "me");
  $(message).appendTo($("#"+table_id));
}

function sendChatMessage(input_id, table_id, receiver_id, table_container_id){
  var message = $("#"+input_id).val();
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: {
      message : message,
      receiver_id : receiver_id
    },
    url: "http://localhost/actions/sendMessage.php",
    success: function(data){
      if(data > 0){
        addSentMessage(message, data, table_id);
        $("#"+input_id).val("");
        scrollToTheBottom(table_container_id);
      }
    }
  });
}
