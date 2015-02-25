$(window).resize(function(){
  adjustSize();
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
  loadPosts(-1);
  adjustSize();
});

function adjustSize(){
  if(window.innerWidth < 1700 && window.innerWidth > 1300){
    $(".main-panel").css("margin", "4px");
    $("#right-panel").removeClass("right-panel-top");
    $("#right-panel").addClass("right-panel");
  } else if (window.innerWidth > 1700) {
    $(".main-panel").css("margin", "0 auto");
    $("#right-panel").removeClass("right-panel-top");
    $("#right-panel").addClass("right-panel");
  } else {
    $("#right-panel").addClass("right-panel-top");
    $("#right-panel").removeClass("right-panel");
  }
}

//MESSAGING SCRIPTS UP TO 224
//global variables
var addedChatBoxes = [];
var intervals = {};
var oldest_loaded = -1;

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
    getMessages(friend_id, -1, table_id, table_container_id, "newer");
    $("#"+input_id).keyup(function(event){
      var text = $("#"+input_id).val();
      if(validateInput(text)){
        if(event.keyCode == 13){
          sendChatMessage(input_id, table_id, friend_id, table_container_id);
        }
      }
    });
    var interval = setInterval(function(i, elem){
      if(!$("#"+table_id).length){
        clearInterval(interval);
      }
      refreshChat(friend_id, table_id, table_container_id);
    }, 5000);
    intervals[chatBox_id] = interval;
    $("#"+table_container_id).scroll(function(){
      if ($("#"+table_container_id).scrollTop() == 0){
        loadOlderMessages(friend_id, table_id, table_container_id);
      }
    });
    $("#"+chatBox_id).slideDown();
  }
}

function makeChatBox(chatBox_id, friend_name){
  return "<div class=chatBox id="+chatBox_id+"><div class=chatTitle><div class=chatCloseBtn><a href='#' onclick='removeChatBox(\""+chatBox_id+"\")'>x</a></div><div class=chatRecipient>"+friend_name+"</div></div><div class=chatContent><div class=chatMessages><div id="+chatBox_id+"TableContainer class=tableContainer><table id="+chatBox_id+"MessagesTable class = 'chatBoxTable'></table></div></div><div class=chatInput><textarea maxlength=4000 id="+chatBox_id+"ChatInput type='text' name='typedMessage' placeholder='type message here'></textarea></div></div></div></div>";
}

function loadOlderMessages(friend_id, table_id, table_container_id){
  var message_id = $("#"+table_id + " tr").first().attr("id");
  getMessages(friend_id, message_id, table_id, table_container_id, "older");
}

function removeChatBox(chatBox_id){
  $("#"+chatBox_id).slideUp(function(){
    $("#"+chatBox_id).remove();
  });
  var index = addedChatBoxes.indexOf(chatBox_id);
  if(index > -1)
    addedChatBoxes.splice(index, 1);
}

function getChatSpinner(){
  return "<tr><td><div class='chatSpinner'><img src='images/loading_spinner.gif' class='chatSpinner'></div></td></tr>"
}

function getMessages(friend_id, message_id, table_id, table_container_id, type){
  if(type == "older"){
    var spinner = getChatSpinner();
    $(spinner).prependTo($("#"+table_id));
  }
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: {
      friend_id : friend_id,
      message_id : message_id,
      type : type
    },
    url: "http://localhost/actions/getMessages.php",
    success: function(data){
      addMessagesToTable(data, table_id, friend_id, type, table_container_id);
      if(type == "older"){
        $("#"+table_container_id).scrollTop(18*(data.length-1));
      }
    }
  });
}

function addMessagesToTable(data, table_id, friend_id, type, table_container_id){
  if(type == "newer"){
    addNewerMessages(data, table_id, friend_id);
    if(data.length>0)
      scrollToTheBottom(table_container_id);
  } else {
    addOlderMessages(data, table_id, friend_id);
  }
}

function extractDataFromMessage(data, friend_id){
  var message = data['message'];
  var message_id = data['message_id'];
  var sender_id = data['sender_id'];
  var sender = "me";
  if(sender_id == friend_id){
    var sender = "friend";
  }
  return makeMessage(message, message_id, sender);
}

function addNewerMessages(data, table_id, friend_id){
  for(i = data.length-1; i>=0 ; i--) {
    var message = extractDataFromMessage(data[i], friend_id);
    $(message).appendTo($("#"+table_id));
  }
}

function addOlderMessages(data, table_id, friend_id){
  $("#"+table_id + " tr").first().remove();
  for(i = 0; i < data.length; i++){
    var message = extractDataFromMessage(data[i], friend_id);
    $(message).prependTo($("#"+table_id));
  }
}

function scrollToTheBottom(table_container_id){
  var sp = $("#"+table_container_id);
  var height = $("#"+table_container_id).height();
  console.log(height);
  sp.scrollTop(height+600);
}

function makeMessage(message, message_id, sender){
  return "<tr id="+message_id+"><td><div class='chatMessage "+sender+"'>"+message+"</div></td></tr>";
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
      if(data >= 0){
        addSentMessage(message, data, table_id);
        $("#"+input_id).val("");
        scrollToTheBottom(table_container_id);
      }
      else if(data < 0) {
        $("#"+input_id).val("");
      }
    }
  });
}

function validateInput(text){
  text = text.trim();
  if(text.length > 0){
    return true;
  }
  return false;
}

function refreshChat(friend_id, table_id, table_container_id){
  var message_id = $("#"+table_id + " tr").last().attr("id");
  if(message_id == null){
    message_id = -1;
  }
  getMessages(friend_id, message_id, table_id, table_container_id, "newer");
}

//below are posts related scripts

function loadPosts(oldest_loaded){
  $.ajax({
    dataType: "JSON",
    type: "POST",
    data: {
      oldest_loaded : oldest_loaded
    },
    url: "http://localhost/actions/getPosts.php",
    success: function(data){
      $("#posts_container").append(data['data']);
      oldest_loaded = data['oldest_loaded'];
    }
  });
}

function loadOlderPosts(){

}

function writeComment(post_id, form){
  $.ajax({
    type: "POST",
    data: {
      post_id : post_id,
      comment : form.comment.value
    },
    url: "http://localhost/actions/writeComment.php",
    success: function(data){
      form.comment.value = "";
      $("#"+post_id+"postComments").append(data);
    }
  });
}

function writeNewPost(form){
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: {
      "post_content" : form.newPostTextarea.value
    },
    url: "http://localhost/actions/writePost.php",
    success: function(data){
      if(data['success']==1){
        $("#posts_container").prepend(data['post']);
        form.newPostTextarea.value = "";
      } else {
        $("#newPostWarning").html(data['warning']);
      }
    }
  });
}

//other stuff

function viewProfile(member_id){
  $.ajax({
    type: "GET",
    dataType: "JSON",
    url: "http://localhost/actions/viewProfile.php?id="+member_id,
    success: function(data){
      if(data['success'] == 1){
        $("#main-panel").html(data['profile']);
        loadPostsOfMember(member_id);
      }
    }
  });
}

function loadPostsOfMember(member_id){
  $.ajax({
    type: "POST",
    dataType: "JSON",
    data: {
      id : member_id
    },
    url: "http://localhost/actions/getPostsOfMember.php",
    success: function(data){
      if(data['success'] == 1){
        $(".posts_container").html(data['posts']);
      }
    }
  });
}

function removeFriend(id){
  $.ajax({
    type: "POST",
    url: "http://localhost/actions/removeFriend.php",
    data: {
      "friend_id" : id
    },
    success: function(data){
      if(data == 1){
        location.reload();
      }
    }
  });
}

function searchFriend(form){
  $.ajax({
    type: "POST",
    url: "http://localhost/actions/searchFriend.php",
    dataType: "JSON",
    data: {
      "string" : form.searchMemberInput.value
    },
    success: function(data){
      if(data['success'] == 1){
        $("#searchResultTable").html(data['result']);
      }
    }
  });
}

function inviteFriend(friend_id){
  $.ajax({
    type: "POST",
    url: "http://localhost/actions/requestFriendship.php",
    data: {
      "friend_id" : friend_id
    },
    success: function(data){
      console.log(data);
      if(data == 1){
        $("#befriendButton").html("Cancel Invitation");
        $("#befriendButton").removeClass("invite");
        $("#befriendButton").addClass("cancel");
        $("#befriendButton").attr("onclick", "cancelInvitation("+friend_id+")");
      }
    }
  });
}

function cancelInvitation(friend_id){
  $.ajax({
    type: "POST",
    url: "http://localhost/actions/cancelFriendshipRequest.php",
    data: {
      "friend_id" : friend_id
    },
    success: function(){
      $("#befriendButton").html("Invite to friends");
      $("#befriendButton").removeClass("cancel");
      $("#befriendButton").addClass("invite");
      $("#befriendButton").attr("onclick", "inviteFriend("+friend_id+")");
    }
  });
}

function confirmFriendship(friend_id){
  $.ajax({
    type: "POST",
    url: "http://localhost/actions/confirmFriendship.php",
    data: {
      "friend_id" : friend_id
    },
    success: function(){
      $("#befriendButton").html("Unfriend");
      $("#befriendButton").removeClass("confirm");
      $("#befriendButton").addClass("unfriend");
      $("#befriendButton").attr("onclick", "removeFriend("+friend_id+")");
    }
  });
}

function changeImage(){
  $("#imageSelector").click();
}
function uploadImage(){
  var file = document.getElementById("imageSelector").files[0];
  if(file){
    var reader = new FileReader();
    reader.readAsText(file);
    reader.onload = function(e){
      $.ajax({
        type: "POST",
        url: "http://localhost/actions/uploadImage.php",
        data: {
          "image" : e.target.result
        },
        success: function(data){
          console.log(data);
        }
      });
    }
  }
}
