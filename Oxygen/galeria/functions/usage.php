Simple usage you just need to create instance of class with operator new 
and it will autamaticlly echo out some albums,
if someone wants to expand on this class please do.

USAGE: You just need to get facebook app key, app secret and page id (form facebook http://www.facebook.com/pages/nameOfPage/PageId)
and create instance of FacePageAlbum class 

$face = new FacePageAlbum('PAGE_ID', $_GET['aid'], $_GET['aurl'], 'APP_ID', 'APP_SECRET');

IMPORTANT!: Do not change $_GET['aid'], $_GET['aurl']

PS you can also use it without app secret and app id for pages that dont need token