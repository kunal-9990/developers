import React from 'react'

const Links = ({ links }) => {
  let linklist = ''
  if (links) {
    linklist = links.map((link, i) => (
      <li className="toc__sub-category">
        <a className="" href={link.link.url} target={link.link.target} key={i}>
          {link.link.title}
        </a>
      </li>
    ))
  }
  return linklist
}

const SubCategoryLinks = ({ content }) => {
  return (
    <li className="toc__sub-category">
      <a className="chevron" href="#">{content.sub_category_title}</a>
      <ul className="toc__topic-wrap toc__topic-wrap--is-expanded">
        <Links links={content.links}/>
      </ul>
    </li>
  )
} 

const CategoryLinks = ({ content }) => {
  let items = content.map((item, i) => (
    (item.acf_fc_layout == 'links') ? <Links links={item.links} key={i}/> : <SubCategoryLinks content={item} key={i}/>
  ))
  return <ul className="toc__sub-category-wrap toc__sub-category-wrap--is-expanded">{items}</ul>
}

const TOC = ({ toc }) => {
  let categories = toc.map((cat, i) => {
    return (
      <li className="toc__category toc__category--is-open" key={i}>
        <a className="chevron" href="#">{cat.toc_category_title}</a>
        <CategoryLinks content={cat.toc_category_content} />
      </li>
    )
  })

  return (
    <div className="toc__container">
      <div className="toc__container">
        <ul className="toc">
          {categories}
        </ul>
      </div>
    </div>
  )
}

export default TOC