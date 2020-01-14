/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function div_show() {
var asombrissement = document.getElementById('mainModal');
//document.getElementById('modalpanel').classList.toggle("visible");
if(asombrissement.style.display === "none"){
        asombrissement.style.display = "block";
        for (opacity = 0; opacity < 1.1; opacity = opacity + 0.1)
        {
            setTimeout(function () {
                asombrissement.style.opacity = opacity;
            }, 100);
        }  
    }else{
        for (opacity = 1; opacity > -0.9; opacity = opacity - 0.1)
        {
            setTimeout(function () {
                asombrissement.style.opacity = opacity;
            }, 500);
        }
        asombrissement.style.display = "none";
}


}

function fadeout() {
   myopacity = 0
   if (myopacity<1) {
      myopacity += .075;
     setTimeout(function(){fadeout()},100);
   }
   document.getElementById('mainModal').style.opacity = myopacity;
   
}
function fadein() {
    myopacity=1;
   if (myopacity<1) {
      myopacity += .075;
     setTimeout(function(){fadein()},100);
   }
   document.getElementById('mainModal').style.opacity = myopacity;
   
}
function beginAnimBox (){
    var asombrissement = document.getElementById('mainModal');
    asombrissement.style.opacity = 1;
    hmm = setInterval(animBox,5000);

}

function animBox(){
    var asombrissement = document.getElementById('mainModal');
    if(asombrissement.style.opacity == 0){
        clearInterval();
    } else {
      asombrissement.style.opacity -= 0.1;
    }
}