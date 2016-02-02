<html>
<head>
<title>Facebook Page Album</title>
<style type='text/css'>
	body
	{
		font-family:arial;
	}
	#wrapper
	{
		width:880px;
		margin:0 auto:
	}
	#back
	{
		display:block;
		padding:5px;
		float:left;
	}
	#backAlbums
	{
		display:block;
		padding:5px;
		float:right;
	}
	#next
	{
		float:right;
		display:block;
		padding:5px;
	}
	#prev
	{
		float:left;
		display:block;
		padding:5px;
	}
	.ImageLink
	{
		display:block;
		float:left;
		padding:5px;
		margin:5px;
	}
	.ImageLink img
	{
		width:150px;
	}
</style>
</head>

<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '449727038566262',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
</script>
<div id ="wrapper">
<?php
	define('PAGE_ID', '295515697154911');
	define('APP_ID','449727038566262');
	define('APP_SECRET','449727038566262|xyX8fPkkTGvV6nuGA6Mm7O5vG7w');
	include("phpcUrl.php");
	$face = new FacePageAlbum(PAGE_ID, $_GET['aid'], $_GET['aurl'], APP_ID, APP_SECRET);
?>
</div>
</body>
</html>