<?php
session_start();
error_reporting(E_ALL^E_NOTICE);
if (!(isset($_SESSION['userId']))) {
  echo "<script> window.location.href='../' </script>";
}
include "../php/db_config.php";
$online = $_SESSION['userId'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>findmates.com|Host & attend.. enjoy with your mates</title>
  <link rel="shortcat icon" href="../assets/imgs/logo.png">
  <link rel="stylesheet" href="../assets/icons/fontawesome-web/css/all.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/master.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/events_page.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/sidebar.css">
  <style>
    #container header nav ul li a#linkEvents {
      background-color: #05386B;
      color: #FFFFFF;
    }
  </style>
</head>
  <body>
    <div id="container">
      <?php include "includes/header.html"; ?>
      <div id="main">
        <div id="topSpace"></div>
        <div class="container_events">
          <div class="events">
            <span id="holder_events_container">
            <button type="button" id="new_event" onclick="open_popup('modal_new_event')" title="Click to create new event"><span>New event</span> <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            <form class="search" action="" method="post" autocomplete="off">
              <select class="" id="search_filter" form="">
                <option value="1">Search by..</option>
                <option value="2">Category</option>
                <option value="3">Title/name</option>
                <option value="4">Location & venue</option>
              </select>
              <input type="text" id="search_string" placeholder="Search events...">
              <button type="submit" onclick="search_events(event)"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            <div class="list_events_wrapper">
<?php
$today = date("Y-m-d H:i:s");
$selectEvents = mysqli_query($config,"SELECT * FROM `events` WHERE (`startDate` >= '$today') ORDER BY `startDate` ASC");
if (mysqli_num_rows($selectEvents) == 0) { ?>
  <div class="list_events">
    <h3>No events posted yet!</h3>
  </div>
<?php } else {
while ($row=mysqli_fetch_assoc($selectEvents)) {
$ev_id = $row['eventId'];
$img = $row['eventImage'];
$heading = $row['eventTitle'];
$host = $row['ev_host'];
$startDate = date("M d, Y h:i a",strtotime($row['startDate']));
$postDay = date("d-M-Y h:i a",strtotime($row['postDate']));
$ev_venue = $row['eventVenue'];
$ev_details = $row['eventDescription'];
$joinBtn=''; $followers='';

$count_forum = mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$ev_id'");
if (mysqli_num_rows($count_forum)==1) {
  $x = mysqli_fetch_assoc($count_forum);
  $for_id = $x['forumId'];
  $count_mates = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$for_id'");
  $followers = mysqli_num_rows($count_mates);
  $followers = ($followers<10) ? '0'.$followers : $followers;
  $followers = ($followers>99) ? '99+' : $followers;
} else {
  $followers = '00';
}


if (!($host == $online)) {
  $forum = mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$ev_id'");
  if (mysqli_num_rows($forum)==0) {
    $joinBtn = 'join';
  } else {
    $a = mysqli_fetch_assoc($forum);
    $f_id = $a['forumId'];
    $member = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$f_id' AND `userId`='$online'");
    if (mysqli_num_rows($member)==0) {
      $joinBtn = 'join';
    } else {
      $joinBtn = 'member';
    }
  }
} else {
  $forum = mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$ev_id'");
  if (mysqli_num_rows($forum)==1) {
    $joinBtn = 'member';
  }
}

   ?>
  <div class="list_events" id="evDiv<?php echo $ev_id; ?>">
    <div class="img">
      <img <?php echo "src='../".$img."' title='".$heading."' alt='".$heading."'"; ?>>
    </div>
    <div class="details">
      <span class="head"><?php echo $heading; ?></span>
      <span><i class="far fa-calendar-alt"></i> <?php echo $startDate; ?></span>
      <span class="sp_venue"><i class="fas fa-map-marker-alt"></i> <?php echo $ev_venue; ?></span>
      <span class="joined"><i class="fa fa-users" aria-hidden="true"></i> Joined: <?php echo $followers; ?></span>
      <div class=""><?php echo $ev_details; ?></div>
      <span class="btns">
        <button type="button" class="view" onclick="viewEvent('<?php echo $ev_id; ?>')">View info <i class="far fa-eye"></i></button>
<?php if($joinBtn=='join') { ?>
        <button type="button" class="join" id="join<?php echo $ev_id; ?>" onclick="join_event('index',<?php echo $ev_id; ?>)">Join <i class="fas fa-sign-in-alt"></i></button>
        <button type="button" class="loading" id="load<?php echo $ev_id; ?>" style="display:none"><i class="fas fa-spinner fa-pulse"></i></button>
        <button type="button" class="forum" id="forum<?php echo $ev_id; ?>" style="display:none" onclick="forum_chat('<?php echo $ev_id; ?>','y')">Forum <i class="fas fa-comments"></i></button>
<?php } elseif ($joinBtn=='member') { ?>
      <button type="button" onclick="forum_chat('<?php echo $ev_id; ?>','y')">Forum <i class="fas fa-comments"></i></button><?php } ?></span>
      <span class="date"><?php echo $postDay; ?></span>
    </div>
  </div>
<?php }
}
?>
            </div>
          </span>

    <!-- ************************* EVENTS' THREADS FOR MESSAGES **********************************-->
    <div class="thread" id="holder_threads_container">
      <div class="heading" id="threadHead">
        <span class="icon back" onclick="exitForumSms()"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
        <img src="" alt="">
        <span class="name"></span>
        <span class="icon" onclick="view_forum_options()"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>
      </div>
      <div class="options" id="optionsForum">
        <span class="view" onclick="view_other_mates('View')"><i class="fas fa-users"></i> View other mates</span>
        <span class="leave" onclick="leave_event()"><i class="fas fa-sign-out-alt"></i> Leave event</span>
        <span class="manage" onclick="view_other_mates('Manage')"><i class="fas fa-users"></i> Event members</span>
      </div>
      <div class="messages" id="messagesHolder">

      </div>
      <form class="newsms" action="" method="post" id="newForumMessage">
        <textarea name="message_forum" placeholder="Message..." required></textarea>
        <input type="hidden" name="forum_id" value="" required>
        <button type="submit" class="sendBtn">Send <i class="fas fa-paper-plane"></i></button>
        <button type="button" class="loadBtn" style="display:none"><i class="fas fa-spinner fa-pulse"></i></button>
      </form>
    </div>
    <!--  ***********************************************************************************-->
</div>
          <?php include "includes/sidebar.php"; ?>
        </div>
      </div>
      <?php
        include "includes/pop_up_modals.html";
        include "../common/footer.html";
      ?>
    </div>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/master.js"></script>
    <script src="../assets/js/ajax/after_login.js"></script>
  </body>
</html>
