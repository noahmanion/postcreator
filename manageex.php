?<? php
//include the Facebook PHP SDK
{
  "require" : {
    "facebook/php-sdk-v4" : "4.0.*"
  }
}
 
//instantiate the Facebook library with the APP ID and APP SECRET
$facebook = new Facebook(array(
    'appId' => '767268540057032',
    'secret' => '1cbe63c2896966954ede8a6435aee015',
    'cookie' => true
));
 
//get the news feed of the active page using the page's access token
$page_feed = $facebook->api(
    '/me/feed',
    'GET',
    array(
        'access_token' => $_SESSION['active']['access_token']
    )
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nettuts+ Page Manager</title>
    <link rel="stylesheet" href="css/reset.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <script src="js/jquery.min.js"></script>
     
    <style>
    body {
        padding-top: 40px;
        background-color: #EEEEEE;
    }
    img {
        vertical-align: middle;
    }
    #main {
        text-align: center;
    }
     
    .content {
        background-color: #FFFFFF;
        border-radius: 0 0 6px 6px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        margin: 0 -20px;
        padding: 20px;
    }
    .content .span6 {
        border-left: 1px solid #EEEEEE;
        margin-left: 0;
        padding-left: 19px;
        text-align: left;
    }
    .page-header {
        background-color: #F5F5F5;
        margin: -20px -20px 20px;
        padding: 20px 20px 10px;
        text-align: left;
    }
    </style>
     
</head>
<body>
<script src="js/bootstrap.js"></script>
<script>
$('.topbar').dropdown()
</script>
<div class="topbar">
    <div class="fill">
    <div class="container">
        <a class="brand" href="/">Nettuts+ Page Manager</a>
        <ul class="nav secondary-nav">
            <li class="dropdown" data-dropdown="dropdown">
                <a class="dropdown-toggle" href="#">Switch Page</a>
                <ul class="dropdown-menu">
                    <?php foreach($_SESSION['accounts'] as $page): ?>
                    <li>
                        <a href="switch.php?page_id=<?php echo $page['id']; ?>">
                            <img width="25" src="http://graph.facebook.com/<?php echo $page['id']; ?>/picture" alt="<?php echo $page['name']; ?>" />
                            <?php echo $page['name']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </div>
    </div>
</div>
<div id="main" class="container">
    <div class="content">
        <div class="page-header">
            <h1>
                <img width="50" src="http://graph.facebook.com/<?php echo $_SESSION['active']['id']; ?>/picture" alt="<?php echo $_SESSION['active']['name']; ?>" />
                <?php echo $_SESSION['active']['name']; ?>
                <small><a href="http://facebook.com/profile.php?id=<?php echo $_SESSION['active']['id']; ?>" target="_blank">go to page</a></small>
            </h1>
        </div>
        <div class="row">
            <div class="span10">
                <ul id="feed_list">
                    <?php foreach($page_feed['data'] as $post): 
                    <?php if( ($post['type'] == 'status' || $post['type'] == 'link') && !isset($post['story'])): ?>
<li>
    <div class="post_photo">
        <img src="http://graph.facebook.com/<?php echo $post['from']['id']; ?>/picture" alt="<?php echo $post['from']['name']; ?>"/>
    </div>
     
    <div class="post_data">
        <p><a href="http://facebook.com/profile.php?id=<?php echo $post['from']['id']; ?>" target="_blank"><?php echo $post['from']['name']; ?></a></p>
        <p><?php echo $post['message']; ?></p>
        <?php if( $post['type'] == 'link' ): ?>
        <div>
            <div class="post_picture">
                <?php if( isset($post['picture']) ): ?>
                <a target="_blank" href="<?php echo $post['link']; ?>">
                    <img src="<?php echo $post['picture']; ?>" width="90" />
                </a>
                <?php else: ?>
                &nbsp;
                <?php endif; ?>
            </div>
            <div class="post_data_again">
                <p><a target="_blank" href="<?php echo $post['link']; ?>"><?php echo $post['name']; ?></a></p>
                <p><small><?php echo $post['caption']; ?></small></p>
                <p><?php echo $post['description']; ?></small></p>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>
</li>
<?php endif; ?>
?>
                    <?php if( ($post['type'] == 'status' || $post['type'] == 'link') && !isset($post['story'])): ?>
                    <?php //do some stuff to display the post object ?>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="span6">
                <h3>Post a new update</h3>
                <img src="post_breakdown.png" alt="Facebook Post Cheat Sheet" width="340" /><br />
                <form method="POST" action="newpost.php" class="form-stacked">
                <label for="message">Message:</label>
                 <input class="span5" type="text" id="message" name="message" placeholder="Message of post" />
                <label for="picture">Picture:</label>
                <input class="span5" type="text" id="picture" name="picture" placeholder="Picture of post" />
                <label for="link">Link:</label>
                <input class="span5" type="text" id="link" name="link" placeholder="Link of post" />
                <label for="name">Name:</label>
                <input class="span5" type="text" id="name" name="name" placeholder="Name of post" />
                <label for="caption">Caption:</label>
                <input class="span5" type="text" id="caption" name="caption" placeholder="Caption of post" />
                <label for="description">Description:</label>
                <input class="span5" type="text" id="description" name="description" placeholder="Description of post" />
     
                <div class="actions">
                    <input type="submit" class="btn primary" value="Post" />
                    <input type="reset" class="btn" value="Reset" />
    </div>
</form>
            </div>
        </div>
    </div>
</div>
</body>
</html>