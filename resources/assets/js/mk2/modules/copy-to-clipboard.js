module.exports = function() {

  const pre = document.getElementsByClassName('clipboard');
  const clipboardBtn = document.createElement('div');
  clipboardBtn.className = "clipboard__btn";
  pre.appendChild(clipboardBtn);

  pre.addEventListener('mouseover', () => {
    console.log("show button");
    clipboardBtn.classList.toggle('clipboard__btn--hover');
  });

  // for (let i = 0; i < pre.length; i++) {
  //   accordion[i].addEventListener("click", function() {

  clipboardBtn.addEventListener('click', () => {

    var range, selection;

    if (document.body.createTextRange) {
      range = document.body.createTextRange();
      range.moveToElementText(pre);
      range.select();
    } else if (window.getSelection) {
      selection = window.getSelection();        
    range = document.createRange();
      range.selectNodeContents(pre);
      selection.removeAllRanges();
      selection.addRange(range);
    }
    
    try {
      document.execCommand('copy');
    }
    catch (err) {
      console.log('unable to copy text');
    }
  });
}