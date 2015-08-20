<!DOCTYPE html>
<html lang="en">
<head>
	<title>Noah's Post Creator</title>
	<!--<link rel="stylesheet" href="/css/reset.css" type="text/css" />-->
	<link rel="stylesheet" href="/css/bootstrap.css" type="text/css">
	<script src="/js/jquery-2.1.4.min.js"></script>

	<style>
	body {
		padding-top: 40px;
	}
	#main {
		margin-top: 80px;
		text-align: center;
	}
	</style>
		</head>
	<body>
	<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '767268540057032',
      xfbml      : true,
      version    : 'v2.3'
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

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
			<div class="navbar-header">
				<a class="brand" href="/">Noah's Post Creator</a>
			</div>
		</div>
		<div id="main" class="container">
			<a href="connect4.php" class="btn btn-lg btn-primary">Login Via FB</a>
		</div>
		</div>
<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>

	</body>
</hmtl>