# Todo
* Cache objects for later re-use (Page::find(1); Page::find(1); should only generate 2 db-requests (one for get_post and one for extend, second find should look in cache))
