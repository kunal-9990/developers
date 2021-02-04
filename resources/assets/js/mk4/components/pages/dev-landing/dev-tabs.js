import React from 'react'
import Slider from 'react-slick'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'

const DevTabs = ({ heading, description, tabs }) => {

  // const settings = {
  //   arrows: true,
  //   // prevArrow: <ArrowPrev />,
  //   // nextArrow: <ArrowNext />,
  //   customPaging: function(i) {
  //     return(<h3>{tabs[i]['title']}</h3>)
  //   },
  //   adaptiveHeight: true,
  //   dots: true,
  //   dotsClass: "tabs",
  //   infinite: true,
  //   speed: 500,
  //   slidesToShow: 1,
  //   slidesToScroll: 1,
  //   // responsive: [{
  //   //   breakpoint: 768,
  //   //   settings: "unslick",
  //   //   slidesToShow: 1
  //   // }]
  // }

  const settings = {
    customPaging: function(i) {
      return(<h3>{tabs[i]['title']}</h3>)
    },
    appendDots: dots => <div className="dots-wrapper">{dots}</div>,
    arrows: false,
    dots: true,
    dotsClass: "tabs-nav",
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    adaptiveHeight: true
  };

  let tabSlider = tabs.map((tab, i) => {
    console.log(tab)
    return (
      <div key={i} className="tabs-slide">
        <div className="tabs-slide__container">
          <div className="tabs-slide__diagram">
            <div>
              {tab.columns.left_column.type === "headline" ? (
                <h3>{tab.columns.left_column.headline}</h3>
              ) : (
                <img src={tab.columns.left_column.image.url} />
              )}
            </div>
            {tab.arrows !== "none" && (
              <div className="arrow">
                {tab.arrows === "two" ? (
                  <p>two arrows</p>
                ) : (
                  <p>one arrow</p>
                )}
              </div>
            )}

            <div>
              {tab.columns.right_column.type === "headline" ? (
                <h3>{tab.columns.right_column.headline}</h3>
              ) : (
                <img src={tab.columns.right_column.image.url} />
              )}
            </div>
          </div>
          <div className="tabs-slide__content">
            <p dangerouslySetInnerHTML={{ __html:tab.content}} />
            <a className="btn" href={tab.link.url}>{tab.link.title || 'Learn more'}</a>
          </div>
        </div>
      </div>
    )
  })

  return (
    <div className="dev-tabs">
      <div className="dev-landing__container">
        <h2>{heading}</h2>
        {description && <p>{description}</p>}
        <div className="tabs-container">
          <Slider {...settings}>
            {tabSlider}
          </Slider>
        </div>
      </div>
    </div>
  )
}

export default DevTabs