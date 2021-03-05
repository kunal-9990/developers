module.exports = function() {
  console.log("preeee");  
  
  const pre = document.querySelector('pre');

  pre.css('background-color', 'pink');

  var x = document.createElement("BUTTON");
  var t = document.createTextNode("Click me");
  x.appendChild(t);
  pre.parentElement().appendChild(x);
}
