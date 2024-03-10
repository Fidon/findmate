<div class="sidebar">
  <!-- MY EVENTS THREADS-->
  <div class="wrapper" id="myEvents">
    <span class="heading">My events' forums<span onclick="view_all('myEvents')">View more</span></span>
    <?php
$getMythreads = mysqli_query($config,"SELECT * FROM `forums` WHERE `hostId`='$online' LIMIT 4");
if(mysqli_num_rows($getMythreads) == 0) {   ?>
  <div class="" style="text-align:center">
    You have no any event forum for now!
  </div>
<?php   } else {
  while($get=mysqli_fetch_assoc($getMythreads)) {
  $ev = $get['eventId'];
  $frm = $get['forumId'];
  $got = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `events` WHERE `eventId`='$ev'"));
  $mates = mysqli_num_rows(mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$frm'"));
  $mates = ($mates > 99) ? "99+" : $mates;
  $mates = ($mates < 10) ? "0".$mates : $mates;
?>
<div class="" onclick="forum_chat('<?php echo $ev; ?>','y')">
  <?php echo html_entity_decode($got['eventTitle'],ENT_QUOTES); ?>
  <span>Date: <?php echo date("d/m/Y",strtotime($got['startDate'])); ?> &nbsp; Mates: <?php echo $mates; ?><!-- &nbsp; New mesages: 56+--></span>
</div>
<?php }   } ?>
  </div>

  <!-- EVENTS THAT I'VE JOINED -->
  <div class="wrapper" id="myJoinedEvents">
    <span class="heading">Joined events' threads<span onclick="view_all('myJoinedEvents')">View more</span></span>
    <?php
    $get_joined = mysqli_query($config,"SELECT * FROM `forums` WHERE `hostId`!='$online' LIMIT 4");
    if(mysqli_num_rows($get_joined) == 0) {   ?>
      <div class="" style="text-align:center">
        You have no any event forum for now!
      </div>
    <?php   } else {
      while($get=mysqli_fetch_assoc($get_joined)) {
      $ev = $get['eventId'];
      $frm = $get['forumId'];
      $got = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `events` WHERE `eventId`='$ev'"));
      $checkEv = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$frm' AND `userId`='$online'");
      while($mate=mysqli_fetch_assoc($checkEv)) {
        $mates = mysqli_num_rows(mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$frm'"));
        $mates = ($mates > 99) ? "99+" : $mates;
        $mates = ($mates < 10) ? "0".$mates : $mates;
    ?>
    <div class="" onclick="forum_chat('<?php echo $ev; ?>','y')">
      <?php echo html_entity_decode($got['eventTitle'],ENT_QUOTES); ?>
      <span>Date: <?php echo date("d/m/Y",strtotime($got['startDate'])); ?> &nbsp; Mates: <?php echo $mates; ?><!-- &nbsp; New mesages: 56+--></span>
    </div>
  <?php }   }   } ?>
  </div>

  <!-- EVENTS TAGS -->
  <div class="wrapper" id="myEventTags">
    <span class="heading">Event #tags<span onclick="view_all('myEventTags')">View more</span></span>
    <?php
    $getTags = mysqli_query($config,"SELECT * FROM `event_tags` WHERE `userId`='$online' ORDER BY `tagDate` DESC LIMIT 4");
    if (mysqli_num_rows($getTags) > 0) {
      while($get=mysqli_fetch_assoc($getTags)) {
        $ev = $get['eventId'];
        $tag_id = $get['tag_id'];
        $got = mysqli_fetch_assoc(mysqli_query($config,"SELECT * FROM `events` WHERE `eventId`='$ev'"));
        $count_forum = mysqli_query($config,"SELECT * FROM `forums` WHERE `eventId`='$ev'");
        if (mysqli_num_rows($count_forum)==1) {
          $x = mysqli_fetch_assoc($count_forum);
          $for_id = $x['forumId'];
          $count_mates = mysqli_query($config,"SELECT * FROM `event_mates` WHERE `forumId`='$for_id'");
          $mates = mysqli_num_rows($count_mates);
          $mates = ($followers<10) ? '0'.$mates : $mates;
          $mates = ($followers>99) ? '99+' : $mates;
        } else {
          $mates = '00';
        }
        $bell = ($get['status'] == "Unread") ? "<i class='fas fa-bell'></i>" : "";
      ?>
      <div class="" onclick="viewEvent('<?php echo $ev; ?>','<?php echo $tag_id; ?>')">
        <?php echo html_entity_decode($got['eventTitle'],ENT_QUOTES); ?>
        <span>Date: <?php echo date("d/m/Y",strtotime($got['startDate'])); ?> &nbsp; Mates: <?php echo $mates; ?><!-- &nbsp; New mesages: 56+ --><?php echo $bell; ?></span>
      </div>
    <?php }
  } else { ?>
      <div class="" style="text-align:center">
        You have no any event tag yet!
      </div>
<?php  } ?>
  </div>
</div>
