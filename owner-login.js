function login(){

let flat=document.getElementById("flat").value;
let mobile=document.getElementById("mobile").value;

let allKeys=Object.keys(localStorage);

let foundOwner=null;
let ownerKey=null;

allKeys.forEach(function(k){

if(k.startsWith("owners_")){

let owners=JSON.parse(localStorage.getItem(k)) || [];

owners.forEach(function(o){

if(o.flat==flat && o.mobile==mobile){

foundOwner=o;
ownerKey=k;

}

});

}

});

if(foundOwner){

localStorage.setItem("ownerData",JSON.stringify(foundOwner));
localStorage.setItem("ownerKey",ownerKey);

window.location="owner.html";

}else{

alert("Wrong Flat or Mobile");

}

}