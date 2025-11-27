# Luna Composer Agent Documentation

## Overview

Luna Composer is an AI-powered content generation agent integrated into the Visible Light platform. It serves as an intelligent assistant that generates thoughtful, human-friendly, long-form content based on comprehensive data analysis from clients' VL Hub Profiles.

## Role and Purpose

Luna Composer's primary role is to:

- **Generate Data-Driven Content**: Create long-form, thoughtful responses based on real client data from their VL Hub Profile
- **Analyze Patterns**: Contemplate and compare data across all streams and connections to identify trends, patterns, and insights
- **Provide Contextual Responses**: Use analytics, user behavior, and infrastructure data to generate relevant, actionable content
- **Serve as an AI Writing Assistant**: Help clients create reports, analyses, and strategic content based on their actual business data

## Integration with Visible Light

Luna Composer is deeply integrated into the Visible Light ecosystem:

1. **VL Hub Profile Integration**: Luna Composer retrieves comprehensive data from each client's VL Hub Profile via the REST API endpoint
2. **License Key Validation**: All requests are validated using the client's Visible Light license key, ensuring secure, authenticated access to their data
3. **Real-Time Data Access**: Luna Composer has access to live data from multiple sources including:
   - Google Analytics 4 (GA4) metrics and dimensions
   - Google Search Console data
   - Lighthouse performance reports
   - WordPress content and user data
   - Infrastructure connections (Cloudflare, SSL/TLS, AWS, etc.)
   - Competitor analysis data
   - Custom data streams and connections

## Data Retrieval Mechanism

### Endpoint Route

Luna Composer retrieves client data from the VL Hub Profile using the following endpoint:

```
https://visiblelight.ai/wp-json/vl-hub/v1/all-connections?license={VL_LICENSE_KEY}
```

### License Key Validation

The client's Visible Light license key is appended to the URL as a query parameter to:
- **Authenticate the request**: Validate that the user has authorized access to the data
- **Fetch client-specific data**: Retrieve only the data associated with the authenticated license key
- **Ensure data security**: Prevent unauthorized access to client information

### Example Request

For a client with license key `VL-AWJJ-8J6S-GD6R`, the full endpoint URL would be:

```
https://visiblelight.ai/wp-json/vl-hub/v1/all-connections?license=VL-AWJJ-8J6S-GD6R
```

## Data Sources and Access

Luna Composer has comprehensive access to client data from various sources:

### Analytics Data

- **Google Analytics 4 (GA4)**:
  - Traffic metrics (users, sessions, pageviews, bounce rate, engagement rate)
  - Geographic data (cities, countries, regions)
  - Device breakdown (desktop, mobile, tablet)
  - Traffic sources (organic, paid, referral, social)
  - Top pages and content performance
  - Event tracking and conversions
  - Revenue and e-commerce data

- **Google Search Console**:
  - Search queries with impressions, clicks, CTR, and position
  - Top performing pages
  - Geographic search performance
  - Device-specific search data
  - Date range analysis

### Performance Data

- **Lighthouse Reports**:
  - Performance scores
  - Accessibility metrics
  - SEO scores
  - Best practices audits
  - Specific optimization opportunities

### Infrastructure Data

- **WordPress Content**:
  - Published posts and pages
  - User data and engagement metrics
  - Plugin and theme information
  - Content performance metrics

- **Connections**:
  - Cloudflare zones and security settings
  - SSL/TLS certificate status
  - AWS S3 buckets
  - Server configurations
  - Database connections

### Competitive Intelligence

- **Competitor Analysis**:
  - Domain rankings
  - Lighthouse performance comparisons
  - Keyword analysis
  - Meta information

## Data Analysis Approach

Luna Composer is designed to:

### Contemplate ALL Data

Luna Composer analyzes data from **all available streams and connections**, not just a single source. This includes:

- All active data streams in the client's VL Hub Profile
- All connected services and platforms
- Historical data patterns and trends
- Cross-platform data correlations

### Compare and Identify Patterns

Luna Composer actively:

- **Compares metrics** across different time periods to identify spikes, dips, and trends
- **Correlates data** from multiple sources (e.g., GA4 traffic with Search Console queries)
- **Identifies patterns** in user behavior, content performance, and business metrics
- **Detects anomalies** that may require attention or optimization

### Generate Thoughtful Responses

When generating content, Luna Composer:

- **Uses actual data**: References specific numbers, metrics, and insights from the client's data
- **Provides context**: Explains what the data means and why it matters
- **Offers actionable insights**: Suggests concrete steps based on the analysis
- **Maintains human-friendly tone**: Writes in a conversational, professional style
- **Creates long-form content**: Generates comprehensive, detailed responses suitable for reports, analyses, and strategic documents

## Example Use Cases

### Traffic Analysis

When asked to "Find and report on spikes or dips in web traffic that may be impacting Google Ad spend," Luna Composer will:

1. Retrieve GA4 metrics (sessions, pageviews, users) from the client's VL Hub Profile
2. Analyze traffic sources to identify paid vs. organic traffic
3. Compare metrics across time periods to identify spikes and dips
4. Correlate traffic patterns with Search Console data
5. Generate a comprehensive report with specific numbers, trends, and recommendations

### Content Performance Analysis

When analyzing content performance, Luna Composer will:

1. Access WordPress content data (posts, pages, engagement metrics)
2. Cross-reference with GA4 page performance data
3. Compare Search Console query data with content topics
4. Identify top-performing content and opportunities
5. Generate strategic recommendations based on actual performance data

### Performance Optimization

When asked about site performance, Luna Composer will:

1. Review Lighthouse reports for performance scores
2. Analyze specific optimization opportunities
3. Compare performance metrics with competitor data
4. Correlate performance with user engagement metrics
5. Provide prioritized recommendations with specific impact estimates

## Technical Implementation

### Frontend Data Fetching

Luna Composer's frontend implementation:

1. **Fetches client data** from the `/wp-json/vl-hub/v1/all-connections` endpoint
2. **Extracts analytics data** from streams (GA4, Search Console, Lighthouse, etc.)
3. **Structures the data** into a comprehensive `clientData` object
4. **Sends the data** to the backend with each prompt request

### Backend Processing

The backend (WordPress plugin):

1. **Receives client data** in the request body
2. **Merges analytics data** into the facts array
3. **Formats data** into a comprehensive facts text document
4. **Sends to GPT-4o** with explicit instructions to use the data
5. **Generates response** based on actual client data

### System Prompt Instructions

Luna Composer's system prompt explicitly instructs GPT-4o to:

- Use ONLY the exact data provided from the VL Hub Profile
- Never claim it doesn't have access to analytics data
- Identify patterns and trends in the data
- Provide specific insights based on actual numbers
- Compare data across sources when relevant
- Generate thoughtful, human-friendly, long-form responses

## Security and Privacy

- **License Key Validation**: All requests require a valid Visible Light license key
- **Client Data Isolation**: Each client only has access to their own data
- **Secure API Endpoints**: All data transmission occurs over HTTPS
- **No Data Storage**: Analytics data is fetched in real-time and not permanently stored by Luna Composer

## Conclusion

Luna Composer is a powerful AI agent that leverages comprehensive client data from VL Hub Profiles to generate thoughtful, data-driven content. By analyzing all available streams and connections, comparing patterns, and using actual metrics, Luna Composer provides clients with actionable insights and strategic content based on their real business data.

---

**Last Updated**: 2025-01-27  
**Version**: 1.0  
**Maintained By**: Visible Light Development Team

