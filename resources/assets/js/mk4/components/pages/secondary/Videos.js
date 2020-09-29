import React, { Component } from 'react'
import ReactPaginate from 'react-paginate';
import Dropdown from '../../Dropdown'
import Grid from '../../Grid'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faSort, faFilter } from '@fortawesome/free-solid-svg-icons'

class Videos extends Component {

  constructor(props) {
    super(props);
    this.state = {
      dropdownOptions: [],
      selectedFilters: [],
      selectedVideos: [],
      paginatedVideos: [],
      pageNumber: 0,
      postsPerPage: (this.props.postsPerPage && this.props.postsPerPage > 0) ? this.props.postsPerPage : 9
    }

    this.allVideos = []
    this.allVideoFilters = []
    this.hashFilter = []
    this.updateSelectedFilters = this.updateSelectedFilters.bind(this)
    this.handlePageClick = this.handlePageClick.bind(this)
  }


  componentDidMount() {
    let tags = []
    let categories = []

    this.props.tags.results.map(tag => {
      tags.push({ "value": tag.slug, "label": tag.name, group: "Filters" })
    });

    this.props.categories.results.map(category => {
      if (category.slug !== 'uncategorized') {
        categories.push({ "value": category.slug, "label": category.name, group: "Products" })
      }
    })

    this.allVideoFilters = categories.concat(tags)

    if (window.location.hash) {
      this.hashFilter = this.allVideoFilters.filter(filter => filter.value === window.location.hash.replace('#', '').toLowerCase())
    }

    this.props.videos.results.map((item, i) => {
      let tagList = item.tags.map(id => this.props.tags.results.find(o => o.id === id).name);
      let catList = item.categories.filter(c => c !== 1).map(id => this.props.categories.results.find(o => o.id === id).name);
      this.allVideos.push({
        id: item.id,
        slug: item.slug,
        title: item.title.rendered,
        // date: item.date,
        tags: item.tags,
        categories: item.categories,
        acf: item.acf,
        // image: item.acf.post_image,
        videoFilters: catList.concat(tagList)
      })
    })

    this.setState({ 
      selectedVideos: this.allVideos,
      selectedFilters: this.hashFilter.length > 0 ? this.hashFilter : this.allVideoFilters,
      dropdownOptions: [
        {
          label: "Products",
          options: categories
        },
        {
          label: "Filters",
          options: tags
        }]
    }, () => this.filterVideos())
  }

  updateSelectedFilters(selectedFilters) {  
    this.setState({ selectedFilters }, () => this.filterVideos())
  }

  filterVideos() {
    let filteredVideos = []
    if (this.state.selectedFilters && this.state.selectedFilters.length > 0) {
      this.allVideos.map((video, i) => {
        if (this.state.selectedFilters.some(r => video.videoFilters.includes(r.label))) {
          filteredVideos.push(video)
        }
      })
      this.setState({ 
        selectedVideos: filteredVideos
      }, () => this.paginateVideos())
    } else {
      this.setState({
        selectedVideos: this.allVideos
      }, () => this.paginateVideos())
    }
  }

  handlePageClick(data) {
    this.setState({ pageNumber: data.selected }, () => { this.paginateVideos() })
  }

  paginateVideos() {
    this.setState({
        paginatedVideos: this.state.selectedVideos.slice(this.state.pageNumber * this.state.postsPerPage, (this.state.pageNumber + 1) * this.state.postsPerPage)
    })
  }

  render() {
    let pageCount = Math.ceil(this.state.selectedVideos.length / this.state.postsPerPage)
    return (
      <div>
        <div className="filter">
          <div className="filter__wrapper">
            <FontAwesomeIcon icon={faFilter} />
            <Dropdown 
              options={this.state.dropdownOptions} 
              preSelected={this.hashFilter.length > 0 ? this.state.selectedFilters : []}
              onChange={this.updateSelectedFilters}
              isMulti="true"
            />
          </div>
        </div>
        <Grid 
          type="videos"
          items={this.state.paginatedVideos} 
          slug={this.props.videoSlug}
        />
        { pageCount > 1 && (
          <ReactPaginate
              previousLabel="&lsaquo;"
              nextLabel="&rsaquo;"
              breakLabel={'...'}
              breakClassName={'break-me'}
              pageCount={pageCount}
              marginPagesDisplayed={2}
              pageRangeDisplayed={2}
              onPageChange={this.handlePageClick}
              containerClassName={'pagination blog-overview__pagination'}
              subContainerClassName={'pages pagination'}
              activeClassName={'active'}
          />
        )}
      </div> 
    )
  }
}

export default Videos