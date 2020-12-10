import React from 'react';

const DevTabs = ({ heading, tabs }) => {
  console.log(heading)
  console.log(tabs)

  // let navigation = blocks.map((block, i) => {
  //   return (
  //     <div className="second-nav__block" key={i}>
  //       <div className="second-nav__title">
  //         <h3 dangerouslySetInnerHTML={{ __html: block.title }}/>
  //       </div>
  //       <p>{block.description}</p>
  //       <div>
  //         <div className="second-nav__cta">
  //           <a href={block.link.url}>{block.link.title || 'Learn more'}</a>
  //         </div>
  //       </div>
  //     </div>
  //   )
  // })

  return (
    <div className="dev-tabs">
      <div className="dev-landing__container">
              <h2>{heading}</h2>
              {/* <div className="second-nav__grid">
                {navigation}
              </div> */}
      </div>
    </div>
  )
}

export default DevTabs