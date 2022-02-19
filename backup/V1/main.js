var elem = document.querySelector(".point");
var prop = window.getComputedStyle(elem,null).getPropertyValue("--point-X-Origin");
var prop1 = window.getComputedStyle(elem,null).getPropertyValue("--point-Y-Origin");
//var height = window.getComputedStyle(elem,null).getPropertyValue("height");
console.log(prop);
console.log(prop1);
//console.log(height);