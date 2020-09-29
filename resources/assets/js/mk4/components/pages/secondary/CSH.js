import React from 'react'
import Accordion from '../../Accordion'

const CSH = props => (
  <div className="accordion">
    {Object.keys(props).map(key => ( 
      props[key].title && (
        <Accordion 
          key={key}
          id={props[key].title.replace(/ /g, '-')}
          title={props[key].title}
          innerDetails={props[key].description}
          contents={props[key].content}
        />
      ))
    )}
  </div>
)

export default CSH