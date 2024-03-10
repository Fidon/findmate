<?php

session_start();
$res = array(
  'status' => 0,
  'sms' => 'Unknown error, please try again later.',
  'input' => ''
);

if(isset($_POST['ev_name'])){
  $name = htmlentities(trim($_POST['ev_name']),ENT_QUOTES);
  $category = $_POST['ev_category'];
  $location = htmlentities(trim($_POST['ev_location']),ENT_QUOTES);
  $startDate = explode('T',$_POST['startDate']);
  $endDate = explode('T',$_POST['endDate']);
  $min = $_POST['miniFee'];
  $max = $_POST['maxFee'];
  $details = htmlentities(trim($_POST['eventDetails']),ENT_QUOTES);
  $first = strtotime($startDate[0].' '.$startDate[1].':00');
  $last = strtotime($endDate[0].' '.$endDate[1].':00');
  $hours = abs($last - $first)/(60*60);
  $host = $_SESSION['userId'];
  $st_date = date("Y-m-d H:i:s",$first);
  $ed_date = date("Y-m-d H:i:s",$last);
  include "../db_config.php";
  $firstDate = strtotime($startDate[0]);
  $today = strtotime(date("Y-m-d"));


  if (strlen($name) >= 5) {
    if (strlen($location) >= 5) {
      if (strlen($details) >= 10) {
        if ($firstDate > $today) {
          if (($last > $first) && ($hours >= 1)) {
            if ($min >= 0) {
              if ($max >= $min) {
                $imgInfo = getimagesize($_FILES["picture"]["tmp_name"]);
                $width = $imgInfo[0];
                $height = $imgInfo[1];
                $fileName = basename($_FILES["picture"]["name"]);
                $targetFilePath = "assets/imgs/profile_pictures/".$fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowTypes = array('jpg', 'png', 'jpeg', 'PNG', 'JPG', 'JPEG');
                if(in_array($fileType, $allowTypes)) {
                  if ($_FILES["picture"]["size"] <= 4000000) {
                    $sql = "INSERT INTO `events`(`ev_host`,`category`,`eventTitle`,`eventVenue`,`startDate`,`endDate`,`maxFee`,`minFee`,`eventDescription`)
                    VALUES('$host','$category','$name','$location','$st_date','$ed_date','$max','$min','$details')";
                    if (mysqli_query($config,$sql)) {
                      $id = mysqli_insert_id($config);

                      //Save event tags
                      $tmpTag = mysqli_query($config,"SELECT `userId` FROM `user` WHERE `tag`='Yes'");
                      if (mysqli_num_rows($tmpTag) > 0) {
                        while ($a=mysqli_fetch_assoc($tmpTag)) {
                          $tmp_id = $a['userId'];
                          mysqli_query($config,"INSERT INTO `event_tags`(`eventId`,`userId`) VALUES('$id','$tmp_id')");
                          mysqli_query($config,"UPDATE `user` SET `tag`='No' WHERE `userId`='$tmp_id'");
                        }
                      }

                      //Upload event picture
                      $ext = explode(".", $_FILES['picture']['name']);
                      $imgExt = end($ext);
                      $folder = "../../assets/imgs/events_pictures/".$id.".".$imgExt;
                      $path = "assets/imgs/events_pictures/".$id.".".$imgExt;
                      if (move_uploaded_file($_FILES['picture']['tmp_name'], $folder)) {
                        mysqli_query($config,"UPDATE `events` SET `eventImage`='$path' WHERE `eventId`='$id'");
                        $res['status'] = 1;
                        $res['sms'] = "Event posted successfully!";
                        $res['input'] = '';
                      } else {
                        mysqli_query($config,"DELETE FROM `events` WHERE `eventId`='$id'");
                        $res['status'] = 0;
                        $res['sms'] = "Failed to post your event";
                        $res['input'] = '';
                      }
                    } else {
                      $res['status'] = 0;
                      $res['sms'] = "Failed to post your event";
                      $res['input'] = '';
                    }
                  } else {
                    $res['status'] = 2;
                    $res['sms'] = "Event picture size should not exceed 4MB";
                    $res['input'] = 'picture';
                  }
                } else {
                  $res['status'] = 2;
                  $res['sms'] = "Please select valid picture format to upload";
                  $res['input'] = 'picture';
                }
              } else {
                $res['status'] =2;
                $res['sms'] = "Max entrance fee should be greater than minimum fee";
                $res['input'] = 'maxFee';
              }
            } else {
              $res['status'] = 2;
              $res['sms'] = "Min entrance fee should not be less than 0";
              $res['input'] = 'minFee';
            }
          } else {
            $res['status'] = 2;
            $res['sms'] = "The difference between start and end date should be at least 1 hour";
            $res['input'] = 'endDate';
          }
        } else {
          $res['status'] = 2;
          $res['sms'] = "Event start date should be greater than today date";
          $res['input'] = 'startDate';
        }
      } else {
        $res['status'] = 2;
        $res['sms'] = "Event description should have at least 10 characters";
        $res['input'] = 'eventDets';
      }
    } else {
      $res['status'] = 2;
      $res['sms'] = "Event location should have at least 5 characters";
      $res['input'] = 'ev_location';
    }
  } else {
    $res['status'] = 2;
    $res['sms'] = "Event name should have at least 5 characters";
    $res['input'] = 'ev_name';
  }
  echo json_encode($res);
}
?>
