<?php
session_start();
if (!((isset($_SESSION['userType'])) || (isset($_SESSION['userId'])))) {
  echo "<script> window.location.href='../' </script>";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>findmates.com|Host & attend.. enjoy with your mates</title>
  <link rel="shortcat icon" href="../assets/imgs/udom-logo.png">
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
            <div class="thread" id="holder_threads_container" style="display:block">
              <div class="heading" id="threadHead">
                <span class="icon back" onclick="forumId()"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
                <img src="../assets/imgs/events/Patoranking.jpg" alt="">
                <span class="name">Christian Brown's birthday party</span>
                <span class="icon"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>
              </div>
              <div class="messages">
                <div class="nomessage">
                  No any messages to show for this forum!<br>You may start a conversation
                </div>
                <!--<div class="others">
                  <span class="sender">Joseph Anderson</span>
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="mine">
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="others">
                  <span class="sender">Joseph Anderson</span>
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="others">
                  <span class="sender">Joseph Anderson</span>
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="mine">
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="others">
                  <span class="sender">Joseph Anderson</span>
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="mine">
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="others">
                  <span class="sender">Joseph Anderson</span>
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="others">
                  <span class="sender">Joseph Anderson</span>
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>
                <div class="mine">
                  <div class="sms">
                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                    demonstrate the visual form of a document or a typeface without relying on meaningful
                    content.
                  </div>
                  <span class="dates">24/09/2021 17:51</span>
                </div>-->
              </div>
              <form class="newsms" action="index.html" method="post">
                <textarea name="message" placeholder="Message..." required autofocus></textarea>
                <button type="submit" name="sendBtn">Send <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
              </form>
            </div>
          </div>
          <div class="sidebar">
            <!-- MY EVENTS THREADS-->
            <div class="wrapper">
              <span class="heading">My events' threads<span>View all</span></span>
              <div class="">
                Sherehe ya harusi Mr. Sanga - Morogoro itakayofanyika mnamo tarehe 30
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56 </span>
              </div>
              <div class="">
                Christian Brown's birthday party
                <span>Date: 28/12/2021 &nbsp; Mates: 99+ &nbsp; New mesages: 56+ </span>
              </div>
              <div class="">
                Charity event organized by UDOM Ambasadors - Nkuhungu village Dodoma
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56 </span>
              </div>
              <div class="">
                Charity event organized by UDOM Ambasadors - Nkuhungu village Dodoma
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56 </span>
              </div>
              <div class="">
                Christian Brown's birthday party
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56 </span>
              </div>
            </div>

            <!-- EVENTS THAT I'VE JOINED -->
            <div class="wrapper">
              <span class="heading">Joined events' threads<span>View all</span></span>
              <div class="">
                Sherehe ya harusi Mr. Sanga - Morogoro itakayofanyika mnamo tarehe 30
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56<i class="fa fa-star" aria-hidden="true"></i></span>
              </div>
              <div class="">
                Christian Brown's birthday party
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56<i class="fa fa-star" aria-hidden="true"></i></span>
              </div>
              <div class="">
                Charity event organized by UDOM Ambasadors - Nkuhungu village Dodoma
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56</span>
              </div>
              <div class="">
                Charity event organized by UDOM Ambasadors - Nkuhungu village Dodoma
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56</span>
              </div>
              <div class="">
                Christian Brown's birthday party
                <span>Date: 28/12/2021 &nbsp; Mates: 34 &nbsp; New mesages: 56</span>
              </div>
            </div>

            <!-- INVITATIONS RECEIVED -->
            <div class="wrapper">
              <span class="heading">Events invitations received<span>View all</span></span>
              <div class="">
                Sherehe ya harusi Mr. Sanga - Morogoro itakayofanyika mnamo tarehe 30
              </div>
              <div class="">
                Christian Brown's birthday party
              </div>
              <div class="">
                Charity event organized by UDOM Ambasadors - Nkuhungu village Dodoma
              </div>
            </div>
            <!-- JOIN REQUESTS SENT -->
            <div class="wrapper">
              <span class="heading">Events join requests sent<span>View all</span></span>
              <div class="">
                Sherehe ya harusi Mr. Sanga - Morogoro itakayofanyika mnamo tarehe 30
              </div>
              <div class="">
                Christian Brown's birthday party
              </div>
              <div class="">
                Charity event organized by UDOM Ambasadors - Nkuhungu village Dodoma
              </div>
            </div>

            <!-- REQUESTS RECEIVED -->
            <div class="wrapper">
              <span class="heading">Events join requests received<span>View all</span></span>
              <div class="">
                Sherehe ya harusi Mr. Sanga - Morogoro itakayofanyika mnamo tarehe 30
              </div>
              <div class="">
                Christian Brown's birthday party
              </div>
              <div class="">
                Charity event organized by UDOM Ambasadors - Nkuhungu village Dodoma
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        include "../common/footer.html";
      ?>
    </div>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/master.js"></script>
  </body>
</html>
