// module.exports = () => {

//   const parentItem = document.querySelectorAll('.parent');
//   const cookieNotification = document.querySelector('.cookie');

//   $('.header__dropdown .subnav .parent').click(() => {


//     // var children = $(this).parent.find('.children');
//     // $('.children').not(children).hide();
//     // children.show()
//     // setCookie('cookie-consent', true)
//     // cookieNotification.style.display = "none";
//     // $('ul.children').not($(this).siblings()).slideUp();
//     // $(this).siblings('ul.children').style.display = "block";
//     parentItem.parentElement.classList.toggle('subnav--opened');
//     parentItem.nextElementSibling.classList.toggle('children--opened');
//     // $(this).classList.toggle('test');

//   });


//   function setCookie(cname, cvalue) {
//     document.cookie = cname + "=" + cvalue + ";path=/";
//   }

// };

module.exports = () => {
  console.log("YES!");
  $(document).ready(function () {
    let headerHeight = $('.header').height();
    $('.subnav--opened .children').css("top", (1 + headerHeight) + "px")
    $('.subnav .parent').on("click", function() {
      console.log("click");
      $('.subnav').not($(this).parent()).removeClass('subnav--opened')
      $(this).toggleClass('parent--opened')
      $(this).parent().toggleClass('subnav--opened')
    })
  });
};
