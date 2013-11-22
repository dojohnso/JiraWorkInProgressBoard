Jira Work In Progress Board
===========================

A dashboard view for work in progress capacity status.

Useful for development shop TVs that display status widgets. index.php auto refreshes an iframe to avoid full widget refreshing.

Under capacity boards are displayed in green blocks. Over capacity boards are displayed in red. The name(s) of the column(s) in the board that are over will be displayed in this case.

See example.html for an example that includes a failure.

Usage
=====

Set your user and url values at the top of capacity.php, load in a browser or any dashboard widget html view

Put index.php and capacity.php into a /capacity folder on your server, and point your widget to http://yourhost.com/path/to/capacity. It will auto-refresh inside an iframe every 5 minutes by default.
