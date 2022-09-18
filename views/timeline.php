<div class="container mainContainer wrapper">


    <div class="row">
    <div class="col-8">
        <h2>Tweets</h2>
        <?php if ($_SESSION['id'] != "") {?>
        <?php displayTweets("isFollowing");  ?>
        <?php } else { ?>
          <p>must be logged in</p>
          <?php } ?>
    </div>
    <div class="col-4">

    <?php displaySearch(); ?>
    <?php displayTweetBox(); ?>

    </div>
  </div>
    

    <div class="push"></div>
</div>