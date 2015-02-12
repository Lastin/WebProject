$('.comment-input').keypress(
  function(e){
    if(e.which == 13){
      //alert(this.value);
    }
  }
);

function comment(postId){
  $.ajax({
    url: "actions/writePost.php"
  });
}
