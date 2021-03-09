module.exports = function() {

  $(document).ready(function () {
    var $button = $("<div>", {"class": "clipboard__btn"});
    $('.clipboard').append($button);
    $button.on("click", function() {
      var range = document.createRange();
      var sel = window.getSelection();
      range.selectNodeContents($(this).parent('.clipboard')[0]);
      sel.removeAllRanges();
      sel.addRange(range);
      
      try {
        document.execCommand('copy');
      }
      catch (err) {
        console.log('unable to copy text');
      }
    })
  });
}