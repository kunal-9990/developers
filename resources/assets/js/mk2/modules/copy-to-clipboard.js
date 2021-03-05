module.exports = function() {
  

  // var x = document.createElement("BUTTON");
  // var t = document.createTextNode("Click me");
  // x.appendChild(t);
  // pre.parentElement().appendChild(x);

  const pre = document.querySelector('pre');

  pre.addEventListener('click', () => {
    console.log("click pre!");
      var x = pre.createElement("BUTTON");
    var t = pre.createTextNode("Click me");
    x.appendChild(t);
    pre.parentElement().appendChild(x);
    // parentLink.parentElement.classList.toggle('manual-toc__category--is-open');
    // parentLink.parentElement.nextElementSibling.classList.toggle('manual-toc__sub-category-wrap--is-expanded');
  });
}
