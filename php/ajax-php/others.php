<?php

session_start();
include "../db_config.php";
$online = $_SESSION['userId'];
$res = array(
  'status' => 0,
  'sms' => ''
);


//Select tags on event post
if (isset($_REQUEST['search_people_tags']) && ($_REQUEST['search_people_tags']!=='')) {
  $query = $_REQUEST['search_people_tags'];
  $searching = mysqli_query($config,"SELECT * FROM `user` WHERE ((`fname` LIKE '%$query%') OR (`lname` LIKE '%$query%')) AND (`userId`!='$online') AND (`tag`='No') ORDER BY `fname` ASC LIMIT 4");
  if (mysqli_num_rows($searching) > 0) {
    while ($get=mysqli_fetch_assoc($searching)) {
      $name = ($get['lname']==NULL) ? $get['fname'] : $get['fname']." ".$get['lname'];
     ?>
     <div class="user<?php echo $get['userId']; ?>" onclick="add_tag('<?php echo $get['userId']; ?>','user<?php echo $get['userId']; ?>')">
       <img src="../<?php echo $get['picture']; ?>" alt="dp picture">
       <span><?php echo $name; ?></span>
     </div>
  <?php } } else {
    echo "No results found";
  }
}


//Add temporary tags
if (isset($_REQUEST['add_temporary_tag']) && ($_REQUEST['add_temporary_tag']!=='')) {
  $user = $_REQUEST['add_temporary_tag'];
  $update = mysqli_query($config,"UPDATE `user` SET `tag`='Yes' WHERE `userId`='$user'");
  if ($update) {
    $get = mysqli_fetch_assoc(mysqli_query($config,"SELECT `fname`, `lname` FROM `user` WHERE `userId`='$user'"));
    $name = ($get['lname']==NULL) ? $get['fname'] : $get['fname']." ".$get['lname'];
    ?>
    <span class="spn<?php echo $user; ?>"><?php echo $name; ?> <i class='far fa-times-circle' onclick="removeTmp_Tag('<?php echo $user; ?>','spn<?php echo $user; ?>')"></i></span>
<?php  }
}


//Search events
if (isset($_REQUEST['search_event']) && (isset($_REQUEST['search_filter']))) {
  $filter = "";
  $str = $_REQUEST['search_event'];
  if($_REQUEST['search_filter'] == '2') {
    $filter = "category";
  } elseif ($_REQUEST['search_filter'] == '3') {
    $filter = "eventTitle";
  } elseif ($_REQUEST['search_filter'] == '4') {
    $filter = "eventVenue";
  }
  $today = date("Y-m-d H:i:s");
  $selectEvents = mysqli_query($config,"SELECT * FROM `events` WHERE (`startDate` >= '$today') AND `$filter` LIKE '%$str%' ORDER BY `startDate` ASC");
  if (mysqli_num_rows($selectEvents) == 0) { ?>
    <div class="list_events">
      <h3>No results found!</h3>
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
}


//Remove temporary tag specific user
if (isset($_REQUEST['removeTmp_Tag']) && ($_REQUEST['removeTmp_Tag']!=='')) {
  $user = $_REQUEST['removeTmp_Tag'];
  $update = "UPDATE `user` SET `tag`='No' WHERE `userId`='$user'";
  if (mysqli_query($config,$update)) {echo "1";} else {echo "0";}
}


//Fetch and display event details
if ((isset($_REQUEST['get_event'])) && ($_REQUEST['get_event'] !== '') && (isset($_REQUEST['tag_id'])) && ($_REQUEST['tag_id'] !== '')) {
  $tag_id = $_REQUEST['tag_id'];
  if ($tag_id !== 0) {
    $selectUnread = mysqli_query($config,"SELECT * FROM `event_tags` WHERE `tag_id`='$tag_id' AND `status`='Unread'");
    if (mysqli_num_rows($selectUnread) == 1) {
      mysqli_query($config,"UPDATE `event_tags` SET `status`='Read' WHERE `tag_id`='$tag_id'");
    }
  }


  $event = $_REQUEST['get_event'];
  $getEvent = mysqli_query($config,"SELECT * FROM `events` WHERE `eventId`='$event'");
  $a = mysqli_fetch_assoc($getEvent);
  $img = $a['eventImage'];
  $heading = $a['eventTitle'];
  $startDate = date("D, F d Y - h:i a",strtotime($a['startDate']));
  $endDate = date("D, F d Y - h:i a",strtotime($a['endDate']));
  $postDay = date("d - Y",strtotime($a['postDate']));
  $postMonth = date("F",strtotime($a['postDate']));
  $postTime = date("h:i a",strtotime($a['postDate']));
  $ev_venue = $a['eventVenue'];
  $ev_details = $a['eventDescription'];
  $host = $a['ev_host'];
  $miniFee = $a['minFee'];
  $maxFee = $a['maxFee'];
  $user = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$host'"));
  $user_names = ($user['lname'] == NULL) ? $user['fname'] : $user['fname']." ".$user['lname'];
  $joinBtn = '';
  if (!($host == $online)) {
    $forum = mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$event'");
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
    $forum = mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$event'");
    if (mysqli_num_rows($forum)==1) {
      $joinBtn = 'member';
    }
  }
  $selectTags = mysqli_query($config,"SELECT * FROM `event_tags` WHERE `eventId`='$event'");
  if (mysqli_num_rows($selectTags) > 0) {
    $mentions = "";
    while($tag=mysqli_fetch_assoc($selectTags)) {
      $us_id = $tag['userId'];
      $get = mysqli_fetch_assoc(mysqli_query($config,"SELECT `fname`,`lname` FROM `user` WHERE `userId`='$us_id'"));
      $namestag = ($get['lname'] == NULL) ? $get['fname'] : $get['fname']." ".$get['lname'];
      if ($mentions == "") {
        $mentions = "<a href='#".$namestag."'>#".$namestag."</a>";
      } else {
        $mentions .= " &nbsp; <a href='#".$namestag."'>#".$namestag."</a>";
      }
    }
  } else {
    $mentions = "This event has no tags!";
  }

?>
<div class="details_holder">
  <div class="leftside">
    <div class="eventPicture">
      <img <?php echo "src='../".$img."' title='".$heading."'"; ?>>
    </div>
    <div class="invited"><!--You're invited by: Daniel Bryan WWE--></div>
    <div class="about">About this event</div>
    <div class="readEvent"><?php echo html_entity_decode($heading)."<br><br>".html_entity_decode($ev_details); ?></div>
    <div class="share">
      <span>Share with friends</span>
      <i class="fab fa-facebook"></i>
      <i class="fab fa-whatsapp"></i>
      <i class="fab fa-instagram"></i>
      <i class="fab fa-twitter"></i>
    </div>
  </div>
  <div class="rightside">
    <div class="ev_post">
<?php if($joinBtn=='join'){ ?>
      <button type="button" class="joinbtn" onclick="join_event('viewer',<?php echo $event; ?>)">Join event <i class="fas fa-sign-in-alt"></i></button>
      <button type="button" class="loading" style="display:none"><i class="fas fa-spinner fa-pulse"></i></button>
      <button type="button" class="forum" style="display:none" onclick="forum_chat('<?php echo $event; ?>')">Forum <i class="fas fa-comments"></i></button>
<?php } elseif ($joinBtn=='member') { ?>
      <button type="button" onclick="forum_chat('<?php echo $event; ?>')">Forum <i class="fas fa-comments"></i></button><?php } ?><br><br><br><br>
      <?php echo "<b>".$postMonth."</b><br>".$postDay."<br>".$postTime; ?>
    </div>
    <div class="ev_title"><b>Title:</b> &nbsp; <?php echo html_entity_decode($heading); ?></div>
    <div class="ev_host"><b>By:</b> &nbsp; <?php echo $user_names; ?></div>
    <div class="ev_entrance"><b>Entrance:</b> &nbsp; <?php echo "Tsh. ".number_format($miniFee)." - Tsh. ".number_format($maxFee); ?></div>
    <div class="dateTime">
      <b>Date and time</b>
      From: <?php echo $startDate; ?> EAT<br>
      To: <?php echo $endDate; ?> EAT
    </div>
    <div class="location">
      <b>Location and venue</b>
      <?php echo $ev_venue; ?>
    </div>
    <div class="tags">
      <b>Tags #</b>
      <?php echo $mentions; ?>
    </div>
    <div class="contacts">
      <b>Contacts</b>
      <?php echo $user['mobile']; ?>
    </div>
  </div>
</div>
<?php }



//Join/folllow event
if ((isset($_REQUEST['join_event'])) && ($_REQUEST['join_event']!=='')) {
  $event = $_REQUEST['join_event'];
  $checkForum = mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$event'");
  if (mysqli_num_rows($checkForum)==1) {
    $frm = mysqli_fetch_assoc($checkForum);
    $f_id = $frm['forumId'];
    $checkMates = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$f_id' AND `userId`='$online'");
    if (mysqli_num_rows($checkMates)==0) {
      $join_mates = "INSERT INTO `event_mates`(`forumId`,`userId`) VALUES('$f_id','$online')";
      if(mysqli_query($config,$join_mates)) {
        echo '1';
      } else {
        echo '0';
      }
    } else {
      echo '1';
    }
  } else {
    $x = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `events` WHERE `eventId`='$event'"));
    $hostId = $x['ev_host'];
    $create_forum = "INSERT INTO `forums`(`eventId`,`hostId`) VALUES('$event','$hostId')";
    if (mysqli_query($config,$create_forum)) {
      $forum_id = mysqli_insert_id($config);
      $join_mates = "INSERT INTO `event_mates`(`forumId`,`userId`) VALUES('$forum_id','$online')";
      if(mysqli_query($config,$join_mates)) {
        echo '1';
      } else {
        echo '0';
      }
    } else {
      echo '0';
    }
  }
}


//Send forum messages
if ((isset($_POST['forum_id'])) && ($_POST['forum_id'] !== '')) {
  $event_id = $_POST['forum_id'];
  $forumCheck = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$event_id'"));
  $forum = $forumCheck['forumId'];
  $message = htmlentities(trim($_POST['message_forum']),ENT_QUOTES);
  $insert = "INSERT INTO `messages`(`forumId`,`userId`,`message`) VALUES('$forum','$online','$message')";
  if (mysqli_query($config,$insert)) {
    $res['status'] = 1;
    $res['sms'] = $event_id;
  } else {
    $res['status'] = 0;
  }
  echo json_encode($res);
}



//Open forum & view message convo
if ((isset($_REQUEST['get_forum_sms'])) && ($_REQUEST['get_forum_sms'] !== '')) {
  $event_id = $_REQUEST['get_forum_sms'];
  $forumCheck = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$event_id'"));
  $forum = $forumCheck['forumId'];
  $get_sms = mysqli_query($config,"SELECT * FROM `messages` WHERE `forumId`='$forum' ORDER BY `postDate` ASC");
  if (mysqli_num_rows($get_sms) == 0) { ?>
    <div class="nomessage">
      No any messages to show for this forum!<br>You may start a conversation..
    </div>
<?php  } else {
    while ($get=mysqli_fetch_assoc($get_sms)) {
      $date = date("d/m/Y h:i a",strtotime($get['postDate']));
      $id = $get['userId'];
      $frm = $get['forumId'];
      $checkHost = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `forums` WHERE `forumId`='$frm'"));
      $user = mysqli_fetch_assoc(mysqli_query($config,"SELECT `fname`,`lname` FROM `user` WHERE `userId`='$id'"));
      $names = ($user['lname'] == NULL) ? $user['fname'] : $user['fname']." ".$user['lname'];
      $isHost = ''; $hostTitle = '';
      if ($checkHost['hostId'] == $id) {$isHost='host'; $hostTitle=' - <i>Event host</i>';}
      if ($id == $online) { ?>
    <div class="mine <?php echo $isHost; ?>">
      <div class="sms">
        <?php echo html_entity_decode($get['message'],ENT_QUOTES); ?>
      </div>
      <span class="dates"><?php echo $date; ?></span>
    </div>
  <?php } else { ?>
  <div class="others <?php echo $isHost; ?>">
    <span class="sender"><?php echo $names.$hostTitle; ?></span>
    <div class="sms">
      <?php echo html_entity_decode($get['message'],ENT_QUOTES); ?>
    </div>
    <span class="dates"><?php echo $date; ?></span>
  </div>
  <?php
      }
    }
  }
}


//View other mates in the event forum
if ((isset($_REQUEST['view_other_mates'])) && ($_REQUEST['view_other_mates'] !== '')) {
  $event_id = $_REQUEST['view_other_mates'];
  $getFrm = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$event_id'"));
  $forum = $getFrm['forumId'];
  $selMates = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$forum'");
  if (mysqli_num_rows($selMates) > 0) {
    while($get=mysqli_fetch_assoc($selMates)) {
      $user = $get['userId'];
      $find = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$user'"));
      $img = $find['picture'];
      $names = ($find['lname'] == NULL) ? $find['fname'] : $find['fname']." ".$find['lname']; ?>
      <div class="othermates">
        <img src="<?php echo '../'.$img; ?>" alt="DP picture">
        <span class="name"><?php echo $names; ?></span>
      </div>
<?php    }
  }
}


//Manage or remove mates from event forum
if ((isset($_REQUEST['manage_event_mates'])) && ($_REQUEST['manage_event_mates'] !== '')) {
  $event_id = $_REQUEST['manage_event_mates'];
  $getFrm = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$event_id'"));
  $forum = $getFrm['forumId'];
  $selMates = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$forum'");
  if (mysqli_num_rows($selMates) > 0) {
    while($get=mysqli_fetch_assoc($selMates)) {
      $user = $get['userId'];
      $find = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$user'"));
      $img = $find['picture'];
      $names = ($find['lname'] == NULL) ? $find['fname'] : $find['fname']." ".$find['lname']; ?>
      <div class="othermates btn<?php echo $user; ?>">
        <img src="<?php echo '../'.$img; ?>" alt="DP picture">
        <span class="name"><?php echo $names; ?></span>
        <button type="button" onclick="remove_event_mate('<?php echo $forum; ?>','<?php echo $user; ?>','btn<?php echo $user; ?>')">Remove</button>
      </div>
<?php    }
  }
}


//Leave event forum
if ((isset($_REQUEST['leave_event'])) && ($_REQUEST['leave_event'] !== '')) {
  $event_id = $_REQUEST['leave_event'];
  $getFrm = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$event_id'"));
  $forum = $getFrm['forumId'];
  $selMates = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `userId`='$online' AND `forumId`='$forum'");
  if (mysqli_num_rows($selMates) > 0) {
    $delete = mysqli_query($config,"DELETE FROM `event_mates` WHERE `userId`='$online' AND `forumId`='$forum'");
    if ($delete) { echo "1"; } else { echo "0"; }
  }
}



//Remove mate from event forum
if ((isset($_REQUEST['remove_event_mate'])) && (isset($_REQUEST['user_info']))) {
  $forum = $_REQUEST['remove_event_mate'];
  $user = $_REQUEST['user_info'];
  $selMates = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `userId`='$user' AND `forumId`='$forum'");
  if (mysqli_num_rows($selMates) > 0) {
    $delete = mysqli_query($config,"DELETE FROM `event_mates` WHERE `userId`='$user' AND `forumId`='$forum'");
    if ($delete) { echo "1"; } else { echo "0"; }
  }
}


//Load and fill forum details in convo screen
if ((isset($_REQUEST['get_forum_details'])) && ($_REQUEST['get_forum_details'] !== '')) {
  $event_Id = $_REQUEST['get_forum_details'];
  $dets = mysqli_fetch_assoc(mysqli_query($config,"SELECT `ev_host`,`eventTitle`,`eventImage` FROM `events` WHERE `eventId`='$event_Id'"));
  $image = $dets['eventImage'];
  $title = html_entity_decode($dets['eventTitle'],ENT_QUOTES);
  if ($dets['ev_host'] == $online) {
    echo "<span id='ev_host_id' style='display:none'>host_".$dets['ev_host']."</span>";
  } else {
    echo "<span id='ev_host_id' style='display:none'>Nothost_".$dets['ev_host']."</span>";
  }
   ?>
  <span class="icon back" onclick="exitForumSms()"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
  <img src="<?php echo '../'.$image; ?>" alt="event image">
  <span class="name"><?php echo $title; ?></span>
  <span class="icon" onclick="view_forum_options()"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>
<?php   }




//Get names in profile update
if (isset($_REQUEST['get_names']) && ($_REQUEST['get_names']=='1')) {
  $get = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$online'"));
  $names = ($get['lname'] == NULL) ? $get['fname']."_split_" : $get['fname']."_split_".$get['lname'];
  echo $names;
}

//Get bio details in profile update
if (isset($_REQUEST['get_bio']) && ($_REQUEST['get_bio']=='1')) {
  $get = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$online'"));
  echo html_entity_decode($get['bio'],ENT_QUOTES);
}

//Get location address in profile update
if (isset($_REQUEST['get_address']) && ($_REQUEST['get_address']=='1')) {
  $get = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$online'"));
  echo html_entity_decode($get['address'],ENT_QUOTES);
}

//Get email address & mobile number in profile update
if (isset($_REQUEST['get_mail_mob']) && ($_REQUEST['get_mail_mob']=='1')) {
  $get = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$online'"));
  echo $get['email']."____".$get['mobile'];
}


//Change profile picture
if (isset($_POST['profile_picture']) && ($_POST['profile_picture']=='1')) {
  $res['form'] = "picture";
  $getImg = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `user` WHERE `userId`='$online'"));
  $fileName = basename($_FILES["picture"]["name"]);
  $targetFilePath = "../../assets/imgs/profile_pictures/".$fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
  $allowTypes = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG');
  $ext = explode(".", $_FILES['picture']['name']);
  $imgExt = end($ext);
  $folder = "../../assets/imgs/profile_pictures/".$online.".".$imgExt;
  $path = "assets/imgs/profile_pictures/".$online.".".$imgExt;
  if(in_array($fileType, $allowTypes)) {
    if ($_FILES["picture"]["size"] <= 2000000) {
      if (unlink("../../".$getImg['picture'])) {
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $folder)) {
          mysqli_query($config,"UPDATE `user` SET `picture`='$path' WHERE `userId`='$online'");
          $res['status'] = 1;
          $res['sms'] = "Profile picture updated successfully!";
          $res['newimg'] = "../assets/imgs/profile_pictures/".$online.".".$imgExt;
        } else {
          $res['status'] = 0;
          $res['sms'] = "Failed to update profile picture";
        }
      } else {
        $res['status'] = 0;
        $res['sms'] = "Failed to update profile picture";
      }
    } else {
      $res['status'] = 0;
      $res['sms'] = "Event picture size should not exceed 2MB";
    }
  } else {
    $res['status'] = 0;
    $res['sms'] = "Please select valid picture format to upload";
  }
  echo json_encode($res);
}


//Change user names
if (isset($_POST['us_names']) && $_POST['us_names']=='1') {
  $res['form'] = "names";
  if ($_SESSION['userType'] == '1') {
    $fname = $_POST['firstN'];
    $lname = $_POST['lastN'];
    if ((ctype_alpha($fname)) && (strlen($fname)>=3) && (strlen($fname)<=15)) {
      if ((ctype_alpha($lname)) && (strlen($lname)>=3) && (strlen($lname)<=15)) {
        $update = "UPDATE `user` SET `fname`='$fname', `lname`='$lname' WHERE `userId`='$online'";
        if (mysqli_query($config,$update)) {
          $res['status'] = 1;
          $res['sms'] = "Names updated successfully!";
        } else {
          $res['status'] = 0;
          $res['sms'] = "Failed to update names";
        }
      } else {
        $res['status'] = 2;
        $res['sms'] = "Last name should have only alphabets 3 to 15 long";
        $res['input'] = "lastN";
      }
    } else {
      $res['status'] = 2;
      $res['sms'] = "First name should have only alphabets 3 to 15 long";
      $res['input'] = "firstN";
    }
  } else {
    $names = $_POST['firstN'];
    if ((strlen($names)>=5) && (strlen($names)<=50)) {
      $update = "UPDATE `user` SET `fname`='$names' WHERE `userId`='$online'";
      if (mysqli_query($config,$update)) {
        $res['status'] = 1;
        $res['sms'] = "Names updated successfully!";
      } else {
        $res['status'] = 0;
        $res['sms'] = "Failed to update names";
      }
    } else {
      $res['status'] = 2;
      $res['sms'] = "Name should be 5 to 50 characters long";
      $res['input'] = "firstN";
    }
  }
  echo json_encode($res);
}


//Update user bio
if (isset($_POST['user_biography']) && $_POST['user_biography']=='1') {
  $res['form'] = "bio";
  $bionew = htmlentities(trim($_POST['bio_new']),ENT_QUOTES);
  if (strlen(trim($_POST['bio_new'])) >= 10) {
    $update = "UPDATE `user` SET `bio`='$bionew' WHERE `userId`='$online'";
    if (mysqli_query($config,$update)) {
      $res['status'] = 1;
      $res['sms'] = "Bio updated successfully!";
    } else {
      $res['status'] = 0;
      $res['sms'] = "Failed to update bio";
    }
  } else {
    $res['status'] = 0;
    $res['sms'] = "Please enter at least one sentence of your new bio..";
  }
  echo json_encode($res);
}


//Update user location address
if (isset($_POST['loc_address']) && $_POST['loc_address']=='1') {
  $res['form'] = "location";
  $address = htmlentities(trim($_POST['location']),ENT_QUOTES);
  if (strlen(trim($_POST['location'])) >= 5) {
    $update = "UPDATE `user` SET `address`='$address' WHERE `userId`='$online'";
    if (mysqli_query($config,$update)) {
      $res['status'] = 1;
      $res['sms'] = "Location address updated successfully!";
    } else {
      $res['status'] = 0;
      $res['sms'] = "Failed to update location address";
    }
  } else {
    $res['status'] = 0;
    $res['sms'] = "Location address should have atleast 5 characters";
  }
  echo json_encode($res);
}


//Update email address & mobile number
if (isset($_POST['emailNew']) && isset($_POST['mobileNew'])) {
  $res['form'] = "mobmail";
  $email = $_POST['emailNew'];
  $mobile = $_POST['mobileNew'];
  $checkEmail = mysqli_query($config,"SELECT `email` FROM `user` WHERE `email`='$email' AND `userId`!='$online'");
  $checkMobile = mysqli_query($config,"SELECT `mobile` FROM `user` WHERE `mobile`='$mobile' AND `userId`!='$online'");
  if ((strlen($mobile) == 10) && (substr($mobile,0,1) == '0') && (ctype_digit($mobile))) {
    if (mysqli_num_rows($checkEmail) == 0) {
      if (mysqli_num_rows($checkMobile) == 0) {
        $update = "UPDATE `user` SET `email`='$email', `mobile`='$mobile' WHERE `userId`='$online'";
        if (mysqli_query($config,$update)) {
          $res['status'] = 1;
          $res['sms'] = "Phone number & email address updated successfully!";
        } else {
          $res['status'] = 0;
          $res['sms'] = "Failed to update phone & email address";
        }
      } else {
        $res['status'] = 2;
        $res['sms'] = "This phone number is already used by another user";
        $res['input'] = 'mobile';
      }
    } else {
      $res['status'] = 2;
      $res['sms'] = "This email address is already used by another user";
      $res['input'] = 'email';
    }
  } else {
    $res['status'] = 2;
    $res['sms'] = "Phone number should start with 0 & have 10 digits only";
    $res['input'] = 'mobile';
  }
  echo json_encode($res);
}


//Update password
if (isset($_POST['passOld']) && isset($_POST['passNew']) && isset($_POST['pass'])) {
  $currentPass = $_POST['passOld'];
  $newPass = $_POST['passNew'];
  $confirmPasss = $_POST['pass'];
  $upper = preg_match('/[A-Z]/',$newPass);
  $lower = preg_match('/[a-z]/',$newPass);
  $number = preg_match('/\d/',$newPass);
  $specialChars = preg_match('/[^a-zA-Z\d]/',$newPass);
  $updatedPass = password_hash($newPass,PASSWORD_BCRYPT);
  $get = mysqli_fetch_assoc(mysqli_query($config,"SELECT `password` FROM `user` WHERE `userId`='$online'"));
  if (password_verify($currentPass,$get['password'])) {
    if (strlen($newPass) >= 6) {
      if ($newPass == $confirmPasss) {
        if ($upper && $lower && $number && $specialChars) {
          $update = "UPDATE `user` SET `password`='$updatedPass' WHERE `userId`='$online'";
          if (mysqli_query($config,$update)) {
            $res['status'] = 1;
            $res['sms'] = "Password updated successfully!";
          } else {
            $res['status'] = 0;
            $res['sms'] = "Failed to update password";
          }
        } else {
          $res['status'] = 2;
          $res['sms'] = "Password should have at least one upper & lower case, number & special character.";
          $res['input'] = 'passNew';
        }
      } else {
        $res['status'] = 2;
        $res['sms'] = "New password does't match!";
        $res['input'] = 'passNew';
      }
    } else {
      $res['status'] = 2;
      $res['sms'] = "New password should be at least 6 characters long";
      $res['input'] = 'passNew';
    }
  } else {
    $res['status'] = 2;
    $res['sms'] = "Incorrect current password";
    $res['input'] = 'passOld';
  }
  echo json_encode($res);
}
 ?>
