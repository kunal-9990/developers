module.exports = () => {
  $(document).ready(function () {
    let headerHeight = $('.header').height();
    $('.subnav .children').css("top", (1 + headerHeight) + "px");

    $('.parent').off().on("click", function(event) {
      event.stopPropagation();
      $('.subnav').not($(this).parent()).removeClass('subnav--opened')
      $(this).parent().toggleClass('subnav--opened')
    })
  });
};
