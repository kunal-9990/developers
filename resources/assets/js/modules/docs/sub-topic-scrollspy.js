module.exports = () => {
    const TOC_SUBTOPIC_CONTAINER = document.querySelector('.toc-subtopics');

    $(window).scroll(() => {
        const windscroll = $(window).scrollTop();
        if (windscroll >= 100) {
            $('.toc-content h2').each(function updateActiveSubToc(i) {
                if ($(this).position().top <= windscroll - 20) {
                    $('ul.nav li.toc-subtopics--active-nav').removeClass('toc-subtopics--active-nav');
                    $('ul.nav li').eq(i).addClass('toc-subtopics--active-nav');
                }
            });
        } else {
            $('ul.nav li.toc-subtopics--active-nav').removeClass('toc-subtopics--active-nav');
            $('ul.nav li:first').addClass('toc-subtopics--active-nav');
        }
    }).scroll();

    /* eslint-disable */
    var waypoint = new Waypoint({
        element: TOC_SUBTOPIC_CONTAINER,
        handler: function(direction) {
          if (direction === 'down') {
            TOC_SUBTOPIC_CONTAINER.classList.add('affix');
          } else {
            TOC_SUBTOPIC_CONTAINER.classList.remove('affix');
          }
        }
    })
    /* eslint-enable */
};
