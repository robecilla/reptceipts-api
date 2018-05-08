import React from 'react'
import PropTypes from 'prop-types'
import Helmet from 'react-helmet'
import './index.css'

import Header from '../components/header'

const Layout = ({ children, data }) => (
  <div className="main">
    <Header />
    <Helmet>
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>{data.site.siteMetadata.title}</title>
      <link
        href="/atom"
        type="application/atom+xml"
        rel="alternate"
        title={data.site.siteMetadata.title}
      />
    </Helmet>
    {children()}
  </div>
)

Layout.propTypes = {
  children: PropTypes.func,
}

export default Layout

export const query = graphql`
  query SiteTitleQuery {
    site {
      siteMetadata {
        title
      }
    }
  }
`
