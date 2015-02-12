text = "SocialNetwork";
canvas = document.getElementById("logo");
context = canvas.getContext('2d');
context.textBaseline = 'top';

gradient = context.createLinearGradient(0,0,0,150);
gradient.addColorStop(0.1,"#75DDFF");
gradient.addColorStop(0.8,"#17C5FF");


var size = 60;
context.font = "bold " + size + "px Lucida Sans Unicode";
while(context.measureText(text).width>canvas.width) {
  size--;
  context.font = "bold " + size + "px Lucida Sans Unicode";
}
context.fillStyle = gradient;
context.fillText(text, 0, 0);
