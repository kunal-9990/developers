module.exports = function() {
  
  const pre = document.querySelector('pre');

  var x = document.createElement("BUTTON");
  var t = document.createTextNode("Click me");
  x.appendChild(t);
  pre.parentElement().appendChild(x);
}
