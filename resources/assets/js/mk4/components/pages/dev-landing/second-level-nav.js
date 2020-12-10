import React from 'react';

const SecondLevelNav = ({ heading, blocks }) => {
  console.log(heading)
  console.log(blocks)

  let navigation = blocks.map((block, i) => {
    return (
      <div>
        <h3>{block.title}</h3>
        <p>{block.description}</p>
      </div>
    )
  })
  

  return (
    <div className="dev-landing__second-nav">
      <h2>{heading}</h2>
      {navigation}
    </div>
  )
}

export default SecondLevelNav