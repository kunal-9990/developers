module.exports = () => {

  const parentLink = document.querySelector('.manual-toc__category a');

  parentLink.addEventListener('click', () => {
    parentLink.parentElement.classList.toggle('manual-toc__category--is-open');
    parentLink.parentElement.nextElementSibling.classList.toggle('manual-toc__sub-category-wrap--is-expanded');
  });

};