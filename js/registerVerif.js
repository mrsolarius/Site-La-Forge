/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
const pass = document.getElementById("psw");
console.log(pass);
const msg = document.getElementById("passtip");

const repeatpass = document.getElementById("psw-repeat");
const pswerr = document.getElementById("pswerr");

pass.addEventListener('keydown',function(){
   if(pass.value.length <5){
       pass.style.borderBottom = "3px solid red";
       msg.innerHTML = 'Trop court';
       msg.style.color = 'red';
   }else if(pass.value.length <10){
       pass.style.borderBottom = "3px solid #ff4c07";
       msg.innerHTML = 'Facile à craker';       
       msg.style.color = '#ff4c07';
   }else if(pass.value.length <12){
       pass.style.borderBottom = "3px solid #ff7907";
       msg.innerHTML = 'Encore faible';
       msg.style.color = '#ff7907';
   }else if(pass.value.length <14){
       pass.style.borderBottom = "3px solid #72af4c";
       msg.innerHTML = 'Pas mal';
       msg.style.color = '#72af4c';
   }else if(pass.value.length <16){
       pass.style.borderBottom = "3px solid #2ECC40";
       msg.innerHTML = 'Assez bon';
       msg.style.color = '#2ECC40';
   }else if(pass.value.length <20){
       pass.style.borderBottom = "3px solid #2ECC40";
       msg.innerHTML = '👍😃';
       msg.style.color = '#2ECC40';
   }
   else if(pass.value.length >=52){
       msg.innerHTML = 'Joey on t\'a reconue 😆';
       msg.style.color = '#000000';
   }
   if(pass.value.length<=1){
    pass.style.borderBottom = "3px solid #fffFff";
    msg.innerHTML = '';
    }
});



function formverify(){
    if(pass.value === repeatpass.value){
        return true;
    }else{
        msg.innerHTML = '';
        pswerr.innerHTML = "Les mots de passe ne correspondent pas";
        pswerr.style.color = "red";
        repeatpass.style.border = "solid 3px red";
        pass.style.border = "solid 3px red";
        return false;
    }
}