import React from 'react'
import Fade from 'react-reveal/Fade'

const ProductCta = ({ link, label, accent}) => (
  <div className="product-nav__button">
    <a 
      href={link} 
      style={{ backgroundColor: accent }}
      rel="noopener"
    >
      <span>{ label }</span>
    </a>
  </div>
)

const ProductNavigation = props => {
  let navGrid = props.navigation.map((navItem, key) => (
    <Fade bottom key={key}>
      <div className="product-nav__wrapper">
        <div className="product-nav__title">
          <div>
          { navItem.branding === 'text' || navItem.heading_type == "text" ? 
            navItem.text && <h2>{ navItem.text }</h2> :
            navItem.icon && <img src={navItem.icon.url} alt={navItem.icon.alt} /> 
          }
          </div>
          {(props.settings.layout === 'full' && navItem.button.label && navItem.button.link) && 
            <ProductCta label={navItem.button.label} link={navItem.button.link} accent={navItem.accent_colour} />
           }
        </div>
        <div className="product-nav__item" key={key} style={{ borderLeft: '5px solid ' + navItem.accent_colour}}>
          <div>
            { navItem.description && (<span>{ navItem.description }</span>) }
            <div className="product-nav__links">
              { navItem.links && navItem.links.map((link, key) => (
                <div key={key}>
                  <a href={link.link} rel="noopener" className="product-nav__cta">{ link.label }<span style={{ color: navItem.accent_colour }}>&#8250;</span></a>
                </div>
              ))}
            </div>
          </div>
           {(props.settings.layout === 'grid' && navItem.button.label && navItem.button.link) && 
            <ProductCta label={navItem.button.label} link={navItem.button.link} accent={navItem.accent_colour} />
           }
        </div>
      </div>
    </Fade>
  ))

  return (
    <div className="product-nav">
      <div className={props.settings.layout === 'full' ? 'product-nav__full' : 'product-nav__grid product-nav__grid--2col' }>
        { navGrid }
      </div>
    </div>
  )
}

export default ProductNavigation