module.exports = () => {

  const parentItem = document.querySelectorAll('.parent');
  const cookieNotification = document.querySelector('.cookie');

  $('.header__dropdown .subnav .parent').click(() => {


    // var children = $(this).parent.find('.children');
    // $('.children').not(children).hide();
    // children.show()
    // setCookie('cookie-consent', true)
    // cookieNotification.style.display = "none";
    // $('ul.children').not($(this).siblings()).slideUp();
    // $(this).siblings('ul.children').style.display = "block";
    parentItem.parentElement.classList.toggle('subnav--opened');
    parentItem.nextElementSibling.classList.toggle('children--opened');
    // $(this).classList.toggle('test');

  });


  function setCookie(cname, cvalue) {
    document.cookie = cname + "=" + cvalue + ";path=/";
  }

};