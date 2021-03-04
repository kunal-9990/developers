module.exports = () => {
  $(document).ready(function () {
    let headerHeight = $('.header').height();
    $('.subnav .children').css("top", (1 + headerHeight) + "px")
    $('.subnav .parent').on("click", function() {
      $('.subnav').not($(this).parent()).removeClass('subnav--opened')
      $(this).toggleClass('parent--opened')
      $(this).parent().toggleClass('subnav--opened')
    })
  });
};
