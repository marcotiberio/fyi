# Block: Stager Opt-in

Newsletter sign-up form that registers contacts for a Stager opt-in.
Docs: https://help.stager.co/en/articles/697455-opt-ins-compliance

The browser posts to `/wp-json/flynt/v1/stager-optin`. WordPress then calls
`https://{organization}.stager.co/api/ticketshop/optin/register`, so the token is never exposed
to the browser. Stager sends a confirmation email, and the contact is only registered after
they click the link in it (double opt-in).

## Setup

1. In Stager, go to Settings > Marketing > Opt-ins, create an opt-in and generate a token.
2. In WordPress, go to Global Options > Block Stager Optin and enter the organization subdomain and token.
   You can also define `STAGER_ORGANIZATION` and `STAGER_OPTIN_TOKEN` in `wp-config.php`, which override the options.
3. Edit the labels and consent text in Blocks Settings > Block Stager Optin.
4. Add "Block: Stager Opt-in" to a page.

When sending mailings in Stager, build the audience with the rule
"Mailings - Has opt-ins - for one or more of - [opt-in name]" to stay GDPR compliant.
