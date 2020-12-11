import React from 'react'
import Slider from 'react-slick'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'

const DevTabs = ({ heading, description, tabs }) => {

  const settings = {
    arrows: true,
    // prevArrow: <ArrowPrev />,
    // nextArrow: <ArrowNext />,
    customPaging: function(i) {
      return(<h3>{tabs[i]['title']}</h3>)
    },
    dots: true,
    dotsClass: "tabs",
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    // responsive: [{
    //   breakpoint: 768,
    //   settings: "unslick",
    //   slidesToShow: 1
    // }]
  }

  let tabSlider = tabs.map((tab, i) => {
    return (
      <div className="tab-slide" key={i}>
        <div class="tab-slide__two-col">
          <p dangerouslySetInnerHTML={{ __html:tab.content}} />
          <div>
            <div className="tab-slide__cta">
              <a href={tab.link.url}>{tab.link.title || 'Learn more'}</a>
            </div>
          </div>
        </div>
        {/* <p>{block.description}</p>
        <div>
          <div className="second-nav__cta">
            <a href={block.link.url}>{block.link.title || 'Learn more'}</a>
          </div>
        </div> */}
      </div>
    )
  })

  return (
    <div className="dev-tabs">
      <div className="dev-landing__container">
        <h2>{heading}</h2>
        {description && <p>{description}</p>}
        <div className="dev">
          <Slider {...settings}>
            {tabSlider}
          </Slider>
        </div>
      </div>
    </div>
  )
}

export default DevTabs