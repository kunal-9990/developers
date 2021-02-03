module.exports = () => {

  const parentLink = document.querySelector('.manual-toc__category a');

  parentLink.addEventListener('click', () => {
    parentLink.parentElement.classList.toggle('manual-toc__category--is-open');
    parentLink.parentElement.nextElementSibling.classList.toggle('manual-toc__sub-category-wrap--is-expanded');
  });



          // if (e.target.parentElement.classList.contains('toc__category')) {
        //     e.target.parentElement.classList.toggle('toc__category--is-open')
        //     e.target.nextElementSibling.classList.toggle('toc__sub-category-wrap--is-expanded')
        //   }
        //   if (e.target.parentElement.classList.contains('toc__sub-category')) {
        //     e.target.parentElement.classList.toggle('toc__sub-category--is-open')
        //     e.target.nextElementSibling.classList.toggle('toc__topic-wrap--is-expanded')
        //   }

};