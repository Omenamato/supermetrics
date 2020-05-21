ASSIGNMENT
Fetch and manipulate JSON data from a fictional Supermetrics Social Network REST API.

INTRODUCTION
Why do we give this assignment and how we assess this assignment?
This example highlights some of the key components of working at Supermetrics. We use this assignment to determine the level of your coding level and where you might fit in our developer stack. There is no wrong answer or wrong way of doing this. Please try to do this by yourself. This task may take up to between 3-5 hours and should be done in object oriented PHP.
NOTE: Please do not use any existing framework such as Laravel, Symfony, Django etc. You may use external standalone libraries if you need.

TASK
    1. Register a short-lived token on the fictional Supermetrics Social Network REST API
    2. Fetch the posts of a fictional user on a fictional social platform and process their posts. You will have 1000 posts over a six month period. Show stats on the following: - Average character length of a post / month - Longest post by character length / month - Total posts split by week - Average number of posts per user / month
    3. Design the above to be generic, extendable and easy to maintain by other staff members.
    4. You do not need to create any HTML pages for the display of the data. JSON output of the stats is sufficient.
    5. Return the assignment in any of the following ways: - Use the custom link in the bottom of this email OR - Place on a github/bitbucket/gitlab repo that we can access, you can use a public repo OR - Zip or Tar the files into an archive and send it along to us by email OR - Place in a Dropbox that we can access.

API DOCS
    1. Use the following endpoint to register a token:

POST: https://api.supermetrics.com/assignment/register

PARAMS:
client_id: ju16a6m81mhid5ue1z3v2g0uh
email: your@email.address
name: Your Name

RETURNS:
sl_token: This token string should be used in the subsequent query. Please note that this token will only last 1 hour from when the REGISTER call happens. You will need to register and fetch a new token as you need it.
client_id: returned for informational purposes only
email: returned for informational purposes only

    2. Use the following endpoint to fetch posts:

GET: https://api.supermetrics.com/assignment/posts

PARAMS:
sl_token: Token from the register call
page: integer page number of posts (1-10)

RETURNS:
page: What page was requested or retrieved
posts: 100 posts per page
