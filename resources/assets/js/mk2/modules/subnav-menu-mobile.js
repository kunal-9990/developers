// module.exports = () => {
//   $(document).ready(function () {
//     let headerHeight = $('.header').height();
//     $('.subnav .children').css("top", (1 + headerHeight) + "px")
//     $('.subnav .parent').on("click", function() {
//       $('.subnav').not($(this).parent()).removeClass('subnav--opened')
//       $(this).toggleClass('parent--opened')
//       $(this).parent().toggleClass('subnav--opened')
//     })
//   });
// };


module.exports = function() {
  var accordion = document.getElementsByClassName('accordion-tab');
  for (let i = 0; i < accordion.length; i++) {
    accordion[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
        panel.style.display = "none";
      } else {
        panel.style.display = "block";
      }
    });
  }
}
