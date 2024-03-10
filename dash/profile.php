<?php
session_start();
if (!((isset($_SESSION['userType'])) || (isset($_SESSION['userId'])))) {
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
  <title>findmates.com | My profile..</title>
  <link rel="shortcat icon" href="../assets/imgs/logo.png">
  <link rel="stylesheet" href="../assets/icons/fontawesome-web/css/all.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/master.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/events_page.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/profile.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/sidebar.css">
  <style>
    #container header nav ul li a#linkProfile{
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
<?php
$prof = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$online'"));
$names = ($prof['lname'] == NULL) ? $prof['fname'] : $prof['fname']." ".$prof['lname'];
?>
            <div class="profile" id="holder_events_container">
              <div class="picture">
                <img <?php echo "src='../".$prof['picture']."' title='".$names."' alt='Profile picture'"; ?> id="propic">
                <span onclick="open_update('update_profile_picture','picture')"><i class="fas fa-user-edit" title="Change profile picture"></i></span>
              </div>
              <div class="fullname">
                <div class="">
                  Full names <span onclick="open_update('update_names','names')"><i class="fas fa-user-edit" title="Update names"></i></span>
                </div>
                <?php echo $names; ?>
              </div>
              <div class="bio">
                <div class="">
                  Biography <span onclick="open_update('update_bio','bio')"><i class="fas fa-user-edit" title="Update bio"></i></span>
                </div>
                <?php echo html_entity_decode($prof['bio'],ENT_QUOTES); ?>
              </div>
              <div class="others locAddress">
                <div class="">
                  Location address & Join date <span onclick="open_update('update_address','address')"><i class="fas fa-user-edit" title="Update birthday and location"></i></span>
                </div>
                <span><i class="fas fa-map-marker-alt"></i> <?php echo $prof['address']; ?></span> &nbsp; &nbsp;
                <!--<span><i class="fas fa-birthday-cake"></i> &nbsp; Born:  27 January 2000</span> &nbsp;-->
                <span><i class="fas fa-calendar-week"></i> Joined: <?php echo date("F Y",strtotime($prof['regDate'])); ?></span> &nbsp;
              </div>
              <div class="others mailmobile">
                <div class="">
                  Email address & mobile number <span onclick="open_update('update_mail_mobile','mailmob')"><i class="fas fa-user-edit" title="Update email & mobile"></i></span>
                </div>
                <?php echo "<i class='fas fa-envelope'></i> ".$prof['email']." &nbsp; &nbsp; <i class='fas fa-phone'></i> ".$prof['mobile']; ?>
              </div>
              <div class="others">
                <div class="">
                  <i class="fas fa-key"></i> &nbsp; Password <span onclick="open_update('update_password','pass')"><i class="fas fa-user-edit" title="Update password"></i></span>
                </div>
              </div>
              <!--<div class="activity">
              User posts (events / visits & tours)
            </div>-->
            </div>

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
