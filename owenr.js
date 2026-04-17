let owner=JSON.parse(localStorage.getItem("ownerData"));

let key=localStorage.getItem("ownerKey");

let owners=JSON.parse(localStorage.getItem(key)) || [];

if(owner){

document.getElementById("name").innerHTML=owner.name;

document.getElementById("flat").innerHTML=owner.flat;

document.getElementById("mobile").innerHTML=owner.mobile;

document.getElementById("amount").innerHTML=owner.maintenance;

if(owner.status=="paid"){

document.getElementById("status").innerHTML="🟢 Paid";

}else{

document.getElementById("status").innerHTML="🔴 Pending";

}

}


function pay(){

owners.forEach(function(o){

if(o.flat==owner.flat){

o.status="paid";

}

});

localStorage.setItem(key,JSON.stringify(owners));

alert("Maintenance Paid");

location.reload();

}