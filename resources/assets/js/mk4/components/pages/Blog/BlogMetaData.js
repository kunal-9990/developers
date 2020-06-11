import React from 'react'
import moment from 'moment'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faTag, faTags } from '@fortawesome/free-solid-svg-icons'

/* TODO:
translate 
*/

const BlogMetaData = ({ author, date, tags, allTags, categories, allCategories }) => {

  let tagList = tags.map(id => allTags.results.find(o => o.id === id).name);
  let categoryList = categories.map(id => allCategories.results.find(o => o.id === id).name);
  let filters = categoryList.concat(tagList).join(', ')

  return (
    <div className="metadata">
      <div>
        <span>Author</span>{author}
      </div>
      <div>
        <span>Date</span>{ moment(date).format("LLL") }
      </div>
      <div>
        <FontAwesomeIcon icon={faTags} />{ filters }
      </div>
    </div>
  )
}

export default BlogMetaData