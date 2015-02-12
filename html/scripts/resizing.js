$(window).resize(function(){
  if(window.innerWidth < 1600){
    $("#right-panel").css("max-width", "790px");
    $("#right-panel").css("margin", "0 auto");
    $("#right-panel").css("position", "static");
  }
  else {
    $("#right-panel").css("max-width", "20%");
    $("#right-panel").css("margin", "0");
    $("#right-panel").css("position", "fixed");
  }
});
