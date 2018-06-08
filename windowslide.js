var image1=new Image();
image1.src="./images/medical1.jpg";
var image2=new Image();
image2.src="./images/medical2.jpg";
var image3=new Image();
image3.src="./images/medical3.jpg";
var image4=new Image();
image4.src="./images/medical4.jpg";

var step=1;
function slideit(){
    document.images.slide.src=eval('image'+step+'.src');
    if(step<4)
        step++;
    else
        step=1;
    setTimeout("slideit()",3000);
}
slideit();