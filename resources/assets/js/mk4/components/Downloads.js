import React from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faFileDownload } from '@fortawesome/free-solid-svg-icons';

const Downloads = props => {
console.log(props)
  let quickLinks = props.quick_link.map((link, i) => {
    return (
      <div key={i} className="quick-link">
          <div className="icon icon--desktop"><FontAwesomeIcon icon={faFileDownload} /></div>
          <div className="quick-link__content">
            <div>
              <div className="icon icon--mobile"><FontAwesomeIcon icon={faFileDownload} /></div>
              <h3>{link.title}</h3>
              {/* {link.version && (<span>{link.version}</span>)} */}
            </div>
            {link.description && (<p>{link.description} </p>)}
          </div>
          <a 
            className="mk4btn" 
            href={link.file_upload.url} 
            target="_blank" 
            download={link.file_upload.title}
          >
            <div>{link.button_label}</div>
          </a>
      </div>
    )
  })

  return(
    <section className="home__links">
      <div className="container">
        <div className="row">
          <div className="col-sm-12">
            { props.header && (<h2>{ props.header }</h2>) }
            { props.description && (<p>{ props.description }</p>) }
            <div className="quick-links">{ quickLinks }</div>
          </div>
        </div>
      </div>
    </section>
  )
}

export default Downloads