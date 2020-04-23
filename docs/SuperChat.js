const log4js = require('log4js')

log4js.configure({
appenders : {
system : {type : 'file', filename : 'system.log'}
},
categories : {
default : {appenders : ['system'], level : 'debug'},
}
});
const logger = log4js.getLogger('system');

logger.debug('Hello world!');
//---------------------------
const Canvas = require('canvas');
var path = require('path'),
dataUriToBuffer = require('data-uri-to-buffer'),
fs = require('fs'),
rand = (min, max) => Math.floor( Math.random() * ( max - min ))+ min;
const preset_money = [100,200,500,1000,2000,5000,8000,9000,10000];
var x = 0,
y = 0,  
w = 600,  
h = 120,  
r = 20,
color,
ty = 0,
offset = 0;
//result  = document.getElementById("result");
canvas = Canvas.createCanvas(600,1000);
context = canvas.getContext('2d');
context.lineJoin = 'round';
//canvas.registerFont(path.join(__dirname, 'NotoSansJP-Bold.otf'),{family: 'Noto Sans JP'});
//registerFont(path.join(__dirname, 'NotoSansJP-Bold.otf'), {family: 'Noto Sans JP'});
textbox = new Array();

textbox["money"] = process.argv[3];
if (textbox["money"] == -1){
  textbox["money"] = preset_money[rand(0,preset_money.length)];
}
console.log(textbox["money"]);
console.log(rand(0,preset_money.length));
textbox["name"] = process.argv[2];
textbox["comment"] = process.argv[4];







reset();
saveCanvas();


function reset() {
  
  var price = textbox["money"];
  const colors      = ["#134a9e","#00b8d4","#00bfa5","#ffb300","#e65100","#c2185b","#d00000"];
  const base_colors = ["#134a9e","#00e5ff","#1de9b6","#ffca28","#f57c00","#e91e63","#e62117"];
  const txt_colors  = ["white","black","black","black","black","white","white"];
  const n = [200,500,1000,2000,5000,10000];
  for (let index = 0; index < n.length; index++) {
    if(n[index] > price){
      color = colors[index];
      base_color = base_colors[index];
      txt_color = txt_colors[index];
      break;
    }
  }
  if(color == null){
    color = colors[n.length];
    base_color = base_colors[n.length];
    txt_color = txt_colors[n.length];
  }
  console.log(color);
  


  //context.clearRect(0,0,canvas.width,canvas.height);
  if((textbox.comment != "")&&(textbox.money >= 200)){
    drawsq(x,y,w,h,r,color,base_color,txt_color,true);
    drawsq_cm(x,y,w,h,r,color,base_color,txt_color);
  }else{
    drawsq(x,y,w,h,r,color,base_color,txt_color,false);
  }

    
}

function iconDraw(){
  context.save();
  context.beginPath() ;
  var r = 40;
  context.arc( r+20, h/2, r, 0 * Math.PI / 180, 360 * Math.PI / 180 ) ;
  context.clip(); 
  var output2 = fs.readFileSync(__dirname + '/userIcon.png');
  var img = new Canvas.Image; // Create a new Image
  img.src = output2;
  context.drawImage(img, 0, 0, img.width, img.height, 20,h/2-r, r*2,r*2);
  //context.drawImage(img, 50, 50, 100, 50, 10, 10, 200, 50);
  context.restore();
}


function drawComment(text){
  canvas2 = Canvas.createCanvas(600,1000);
  context2 = canvas2.getContext('2d');
  var current
  var ty = -20;
  while(text != ""){
    ty += 30;
    //console.log(text);
    current = drawLine(text, ty);
    text = text.substr(text.indexOf(current) + current.length);
  }
  return ty;
}

function drawLine(text, ty){
  offset = 30;
  context2.font = "30px 'Roboto, Arial, sans-serif'";
  var txwidth = context2.measureText(text);
  if (txwidth.width <= w - offset*2){
    context2.fillStyle = txt_color;
    context2.fillText(text,offset,y+h+offset+ty);
    return text;
  }else{
    return drawLine(text.substr(0,text.length-1),ty);
  }
}

function profileDraw(){
  context.fillStyle = txt_color;
  context.font = "20px 'sans-serif'";
  context.globalAlpha = 0.7;
  context.fillText(textbox["name"], 120, 45);
  context.globalAlpha = 1;
  context.font = "50px 'sans-serif'";
  context.fillText("￥"+Number(textbox.money).toLocaleString(), 110, 95);
}

function drawsq(x,y,w,h,r,color,base_color,txt_color, cm = false) {
  console.log(h);
  context.beginPath();
  context.lineWidth = 1;
  context.strokeStyle = color;
  context.fillStyle = color;
  context.moveTo(x,y + (r/2));
  if(cm == true){
    context.lineTo(x,y+h);
    context.lineTo(x+w,y+h);
  }else{
    context.arc(x+r,y+h-r,r,Math.PI,Math.PI*0.5,true);
    context.arc(x+w-r,y+h-r,r,Math.PI*0.5,0,1);
  }
  context.arc(x+w-r,y+r,r,0,Math.PI*1.5,1);
  context.arc(x+r,y+r,r,Math.PI*1.5,Math.PI,1);       
  context.closePath();
  context.stroke();
 
  context.fill();
  iconDraw();
  profileDraw();  
}

function drawsq_cm(x,y,w,h,r,color,base_color,txt_color) {
    ty = drawComment(textbox["comment"]);
    console.log(ty);
    context.beginPath();
    context.lineWidth = 1;
    context.strokeStyle = color;
    context.fillStyle = base_color;
    context.moveTo(x,y +h);
    context.arc(x+r,y+h-r + ty+offset*2,r,Math.PI,Math.PI*0.5,true);
    context.arc(x+w-r,y+h-r+ ty+offset*2,r,Math.PI*0.5,0,1);
    context.lineTo(x+w,y +h);
    context.closePath();
    context.stroke();
    context.fill();
    context.drawImage(canvas2,0,0,600,1000,0,0,600,1000);
}

function saveCanvas () {
    canvasDraw = Canvas.createCanvas(600,y+h+ ty+offset*2);
    contextDraw = canvasDraw.getContext('2d');
    contextDraw.drawImage(canvas,0,0);
    const canvasDataUrl = canvasDraw.toDataURL()
    const decoded = dataUriToBuffer(canvasDataUrl)
    var imageFilePath = __dirname+"/../result.png";
    fs.writeFile(imageFilePath, decoded, (err) => {
      if (err) {
        console.log('ファイルの保存に失敗しました')
        console.log(err)
      } else {
        console.log('ファイルを保存しました')
      }
    })
  }


