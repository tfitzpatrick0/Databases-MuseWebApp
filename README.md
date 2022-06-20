# Databases - Muse Web App

Spotify API and music database webapp

sql user - root
sql password - stingrays

FILES MODIFIED:

- CHANGED SQL LOGIN for EVERY LISTED .php file
- ADDED sql directory with database info

HOME PAGE:

- index.php -> changed redirects
- requestHandler.php -> changed redirects

SPOTIFY INTERACTIVE PAGE (uses API calls):

- song.php -> changed redirects

ADMIN LOGIN - REDIRECTS TO demo.php:

- login.php (ADMIN) -> changed redirects (add_admin.php and mods.php used to modify admin account data)
  - add_admin.php -> changed redirects
  - mods.php -> changed redirects

INTERACT WITH DATABASE(s):

- demo.php -> changed redirects
  - search.php -> changed redirect back to demo
  - update.php -> added redirect back to demo
  - delete.php -> changed redirect back to demo (needs work)
  - insert.php -> changed redirect back to demo

SPOTIFY LOGIN PAGE/API CALLS:

- oauth.php -> changed redirects
  - app.js -> changed redirect URL and API info

STATIC HTML:

- devplan.html -> changed redirects
- project.html -> changed redirects

TO DO:

1. Get Spotify API fully functional $
2. Improve the layout of home page $
3. Improve the layout of the Spotify interactive page $ --> (FIX SEARCH LINK PARAMS, AND REWORK PHP/ELEMENTS WITH INFO FOR API CALLS)
4. Improve the layout of the Spotify login page $
5. Improve the layout of the admin login page $ --> (NEED TO REWORK ADD_ADMIN/MODS, AND LAYOUT OF INFO MSG)
6. Improve the layout of the demo page $
7. Improve the layout of search/update/delete/insert $
8. Incorporate better functionality for the add_admin/mods files $
9. Improve the layout of static html pages $
10. Combine app.js and song.js into a single file $
11. Clean up unused files $
12. Clean up the database

FORMATTING:

1. php section of login.php $

CMD + SHIFT + R to refresh browser cache
