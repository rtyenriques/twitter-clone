<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted">&copy; 2022 Company, Inc</span>
  </div>
</footer>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>


<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalHeader">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="alert alert-danger" id="loginAlert"></div>

        <form id="loginForm">
          <input type="hidden" name="loginActive" id="loginActive" value="1">
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="stayLoggedIn">
            <label class="form-check-label" for="exampleCheck1">Keep me logged in</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" id="toggleSignupLogin">Don't have an account</button>
        <button type="button" id="loginSignupButton" class="btn btn-primary">Login</button>
      </div>
    </div>
  </div>
</div>

<script>
  $("#toggleSignupLogin").click(function() {

    if ($("#loginActive").val() == "1") {
      $("#loginActive").val("0");
      $("#loginModalHeader").html("Signup");
      $("#loginSignupButton").html("Signup");
      $("#toggleSignupLogin").html("Already have an account");

    } else {
      $("#loginActive").val("1");
      $("#loginModalHeader").html("Login");
      $("#loginSignupButton").html("Login");
      $("#toggleSignupLogin").html("Don't have an account");
    }

  })

  $("#loginSignupButton").click(function() {
    $.ajax({
      type: "POST",
      url: "actions.php?action=loginSignup",
      data: "email=" + $("#email").val() + "&password=" + $("#password").val() + "&loginActive=" + $("#loginActive").val(),
      success: function(result) {
        if (result == 1) {
          window.location.assign("index.php");
        } else {
          $("#loginAlert").html(result).show();
        }
      }
    })
  })

  $(".toggleFollow").click(function() {
    var id = $(this).attr("data-userId")
    $.ajax({
      type: "POST",
      url: "actions.php?action=toggleFollow",
      data: "userId=" + id,
      success: function(result) {
        if (result == "1") {
          $("#toggleFollow[data-userId='" + id + "']").html("Follow");
        } else if (result == "2") {
          $("#toggleFollow[data-userId='" + id + "']").html("Unfollow");
        } else {
          alert("Must be logged in");
        }
      }
    })

  })

  $("#postTweetButton").click(function() {
    $.ajax({
      type: "POST",
      url: "actions.php?action=postTweet",
      data: "tweetContent=" + $("#tweetContent").val(),
      success: function(result) {
        if (result == "1") {
          $("#tweetSuccess").show();
          $("#tweetFail").hide();
        } else if (result != "") {
          $("#tweetFail").html(result).show();
          $("#tweetSuccess").hide();

        }

      }
    })

  })

  $("#deleteTweet").click(function() {
    var tweetId = $(this).attr("tweetId")
    $.ajax({
      type: "POST",
      url: "actions.php?action=deleteTweet",
      data: "tweetId=" + tweetId,
      success: function(result) {
        if (result == 1) {
          $("#deleteTweet").hide();
          $("#deletedTweet").show();
          // window.location.assign("views/yourtweets.php");
        }

      }
    })
  })
</script>


</html>