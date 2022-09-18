<div class="container mainContainer wrapper">
  

    <div class="row">
    <div class="col-8">

    <?php if ($_GET['userId']) {?>
        <?php displayTweets($_GET['userId']); ?>
    <?php } else { ?>
        <h2>Active Users</h2>
        <?php displayUsers(); ?>
    <?php } ?>
    </div>
    <div class="col-4">

    <?php displaySearch(); ?>
    <?php displayTweetBox(); ?>

    </div>
  </div>
    

    <div class="push"></div>
</div>