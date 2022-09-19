<?php

include("connection.php");

if ($_GET['function'] == "logout") {
    session_unset();
}

if ($_GET['function'] == "deleteAccount") {

    $deleteFollowingQuery = "DELETE FROM `isFollowing` WHERE follower = " . mysqli_real_escape_string($link, $_SESSION['id']) . "";
    $deleteIsFollowingQuery = "DELETE FROM `isFollowing` WHERE isFollowing = " . mysqli_real_escape_string($link, $_SESSION['id']) . "";
    $deleteTweetQuery = "DELETE FROM `tweets` WHERE userid = " . mysqli_real_escape_string($link, $_SESSION['id']) . "";
    $deleteUserQuery = "DELETE FROM `users` WHERE id = " . mysqli_real_escape_string($link, $_SESSION['id']) . "";

    mysqli_query($link, $deleteFollowingQuery);
    mysqli_query($link, $deleteIsFollowingQuery);
    mysqli_query($link, $deleteTweetQuery);
    mysqli_query($link, $deleteUserQuery);
    session_unset();
    echo "<p class='alert alert-danger'>Your account has been deleted</p>";
}


function time_since($since)
{
    $chunks = array(
        array(60 * 60 * 24 * 365, 'year'),
        array(60 * 60 * 24 * 30, 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24, 'day'),
        array(60 * 60, 'hour'),
        array(60, 'min'),
        array(1, 'sec')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 ' . $name : "$count {$name}s";
    return $print;
}

function displayTweets($type)
{
    global $link;
    if ($type == "public") {
        $whereClause = "";
    } else if ($type == 'isFollowing') {
        $query = "SELECT * FROM `isFollowing` WHERE follower = " . mysqli_real_escape_string($link, $_SESSION['id']);
        $result = mysqli_query($link, $query);
        $whereClause = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // while ($row = mysqli_fetch_assoc($result)) {
                if ($whereClause == "") $whereClause = "WHERE";
                else $whereClause .= " OR";
                $whereClause .= " userid = " . $row['isFollowing'];
            }
        } else {
            $whereClause = "Cancel Query";
        }
    } else if ($type == 'yourtweets') {
        $whereClause = "WHERE userId = " . mysqli_real_escape_string($link, $_SESSION['id']);
    } else if ($type == 'search') {
        echo "<p>Showing search results for '" . mysqli_real_escape_string($link, $_GET['q']) . "':</p>";
        $whereClause = "WHERE `tweet` LIKE '%" . mysqli_real_escape_string($link, $_GET['q']) . "%'";
    } else if (is_numeric($type)) {

        $userQuery = "SELECT * FROM `users` WHERE id = " . mysqli_real_escape_string($link, $type) . " LIMIT 1";
        $userQueryResult = mysqli_query($link, $userQuery);
        $user = mysqli_fetch_assoc($userQueryResult);
        echo "<h2>" . mysqli_real_escape_string($link, $user['email']) . "'s Tweets</h2>";
        $whereClause = "WHERE userid = " . mysqli_real_escape_string($link, $type);
    }

    $query = "SELECT * FROM `tweets` " . $whereClause . " ORDER BY `datetime` DESC";

    $result = mysqli_query($link, $query);
    if ($result->num_rows == 0) {
        // if (mysqli_num_rows($result) == 0) {
        echo "there are no tweets to display";
    } else {
        while ($row = $result->fetch_assoc()) {
            // while ($row = mysqli_fetch_assoc($result)) {

            $userQuery = "SELECT * FROM `users` WHERE id = " . mysqli_real_escape_string($link, $row['userid']) . " LIMIT 1";
            $userQueryResult = mysqli_query($link, $userQuery);
            $user = mysqli_fetch_assoc($userQueryResult);

            echo "<div tweetId=" . $row['id'] . " class='tweet'>";
            echo "<p><a href='?page=publicprofiles&userId=" . $user['id'] . "'>" . $user['email'] . "</a><span class='time'>" . time_since(time() - strtotime($row['datetime'])) . " ago</span>" . "</p>";
            echo "<p>" . $row['tweet'] . "</p>";
            echo '<div id="toggleFollow" type="button" class="btn-link toggleFollow" data-userId="' . $row["userid"] . '">';

            $isFollowingquery = "SELECT * FROM `isFollowing` WHERE follower = " . mysqli_real_escape_string($link, $_SESSION['id']) . " AND isFollowing = " . mysqli_real_escape_string($link, $row['userid']) . " LIMIT 1 ";
            $isFollowingQueryResult = mysqli_query($link, $isFollowingquery);

            if ($_SESSION['id'] == $user['id']) {
                echo "";
                // echo "<button id='deleteTweet' class='btn btn-danger' >delete</button>";
            } else if ($isFollowingQueryResult->num_rows > 0) {
                // if (mysqli_num_rows($isFollowingQueryResult) > 0) {
                echo "Unfollow";
            } else {
                echo "Follow";
            }

            echo '</div>';
            //pass in $row['id] to get id of tweet i want to delete pass in as dataId

            if ($_SESSION['id'] == $user['id']) {
                echo '<button id="deleteTweet" tweetId=' . $row['id'] . ' class="btn btn-outline-danger" >Delete Tweet</button>';
                echo "<div id='deletedTweet' class='alert alert-danger'>Tweet Deleted</div>";
            }
            echo '</div>';
        }
    }
}

function displaySearch()
{
    echo '
    <form class="form-inline">
    <div class="btn-group">
      <input type="hidden" name="page" value="search">
      <input type="text" class="form-control me-2" name="q" id="search" type="search" placeholder="Search" aria-label="Search">
      <button type="submit" id="searchButton" class="btn btn-outline-primary">Search Tweets</button>
    </div> </form><hr>';
}

function displayTweetBox()
{
    if ($_SESSION['id'] > 0) {

        echo '
        <div id="tweetSuccess" class="alert alert-success">Your tweet was posted successfully</div>
        <div id="tweetFail" class="alert alert-danger"></div>
        <div class="form-group" id="tweetBox">
           <textarea class="form-control me-2" id="tweetContent"> </textarea>
        </div>
          <button id="postTweetButton" class="btn btn-outline-primary">Post Tweets</button>
        ';
    }
}

function displayUsers()
{
    global $link;
    $query = "SELECT * FROM `users` LIMIT 10";
    $result = mysqli_query($link, $query);
    // while ($row = $result->fetch_assoc()) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p><a href='?page=publicprofiles&userId=" . $row['id'] . "'>" . $row['email'] . "</a></p>";
    }
}

function displayYourTimelineOrTweets($type)
{
    if ($_SESSION['id'] != "") {
        displayTweets($type);
    } else {
        echo "<p>Must be logged in</p>";
    }
}

function displayUsername()
{
    if ($_SESSION['id'] != "") {
        global $link;
        $emailQuery = "SELECT * FROM `users` WHERE id = " . $_SESSION['id'] . "";

        $doEmailQuery = mysqli_query($link, $emailQuery);
        $user = $doEmailQuery->fetch_assoc();
        // print_r($user);
        echo $user["email"];
    } else {
        echo "";
    }
}
