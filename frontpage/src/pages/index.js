import React from 'react'
import Link from 'gatsby-link'
//import apk from '../app-release.apk'

const IndexPage = ({ data }) => (
  <section>
    <h2>Welcome to the reptceipts API!</h2>
    <hr />
    <br />
    <p>
      There's nothing you can do from here, <br />visit{' '}
      <a href={data.site.siteMetadata.clientUrl} target="_blank">
        {' '}
        reptceipts.co.uk
      </a>{' '}
      or{' '}
      <a href="/" download>
        download
      </a>{' '}
      the reptceipts app to get started
    </p>
  </section>
)

export default IndexPage

export const query = graphql`
  query clientUrlQuery {
    site {
      siteMetadata {
        clientUrl
      }
    }
  }
`
