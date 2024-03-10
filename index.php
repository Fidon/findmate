<?php
session_start();
if ((isset($_SESSION['userType'])) && (isset($_SESSION['userId']))) {
  echo "<script> window.location.href='dash' </script>";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to findmate|Find your companion.. enjoy the moment</title>
  <link rel="shortcat icon" href="assets/imgs/logo.png">
  <link rel="stylesheet" href="assets/icons/fontawesome-web/css/all.css">
  <link rel="stylesheet" type="text/css" href="assets/css/master.css">
  <link rel="stylesheet" type="text/css" href="assets/css/index_page.css">
  <style>
    #container header nav ul li a#link1 {
      background-color: #05386B;
      color: #FFFFFF;
    }
  </style>
</head>
  <body>
    <div id="container">
      <?php include "common/header.html"; ?>
      <div id="main">
        <div id="topSpace"></div>
        <div class="forms">
          <!--Welcome text-->
          <div class="welcome" id="welcomeId">
            <img src="assets/imgs/findmate.png" alt="happy people"><br>
            Got an event to host or place to visit..?<br>
            Welcome to <span>findmates.com</span> let's find mates to join and accompany you..<br>
            <button type="button" onclick="switch_elements('login_form','link2')">GET STARTED &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
          </div>

          <!--Login form-->
          <form id="login_form" action="" method="post" autocomplete="off">
            <span class="form-header">Login..</span>
            <span class="smsError"></span>
            <span class="smsSuccess"></span>
            <div class="input-wrapper">
              <input type="text" name="username" value="" placeholder="Email or mobile number" required>
              <span></span>
            </div>
            <div class="input-wrapper">
              <input type="password" name="password" value="" placeholder="Password.." required>
              <span></span>
            </div>
            <div class="input-wrapper btn">
              <button type="submit" name="login_Button" class="submitBtn">LOGIN</button>
              <button type="button" class="loadBtn"><i class="fas fa-spinner fa-pulse"></i></button>
              <a onclick="switch_elements('passReset_form','link2')">Forgot password?</a> &nbsp; Or &nbsp; <a onclick="switch_elements('user_reg','link3')">Join us today</a>
            </div>
          </form>

          <!-- Registration forms - SELECT TYPE OF ACCOUNT -->
          <form id="user_reg" action="" method="post" autocomplete="off">
            <span class="form-header">Create new account..</span>
            <div class="input-wrapper">
              <label>Choose the type of account</label>
              <select form="user_reg" name="accType" id="accType_us" onchange="switchForms(this)">
                <option value="">Account type..</option>
                <option value="1">Personal account</option>
                <option value="2">Institutional/group account</option>
              </select>
              <span></span>
            </div>
            <div class="input-wrapper btn">
              <a onclick="switch_elements('login_form','link2')">I've an account already!</a>
            </div>
          </form>

          <!--- personal account -->
          <form id="personalReg" method="post" enctype="multipart/form-data" onsubmit="create_account('personalReg',event)" autocomplete="off">
            <span class="form-header">Create new personal account..</span>
            <span class="smsError"></span>
            <span class="smsSuccess"></span>
            <div class="input-wrapper">
              <label>Choose the type of account</label>
              <select form="personalReg" name="accType" id="accType_P" onchange="switchForms(this)">
                <option value="">Account type..</option>
                <option value="1">Personal account</option>
                <option value="2">Institutional/group account</option>
              </select>
              <span></span>
            </div>
            <div class="input-wrapper">
              <input type="text" name="fname" value="" placeholder="First name" required>
              <span class="fname"></span>
            </div>
            <div class="input-wrapper">
              <input type="text" name="lname" value="" placeholder="Last name" required>
              <span class="lname"></span>
            </div>
            <div class="input-wrapper">
              <select form="personalReg" name="gender" required>
                <option value="">Gender..</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
              </select>
              <span></span>
            </div>
            <div class="input-wrapper">
              <input type="text" name="location" value="" placeholder="Location address" required>
              <span class="location"></span>
            </div>
            <div class="input-wrapper">
              <input type="email" name="email" value="" placeholder="Email address" required>
              <span class="email"></span>
            </div>
            <div class="input-wrapper">
              <input type="number" name="phone" value="" placeholder="Phone number" required>
              <span class="phone"></span>
            </div>
            <div class="input-wrapper">
              <textarea name="bio" placeholder="Bio.." required></textarea>
              <span class="bio"></span>
            </div>
            <div class="input-wrapper">
              <label>Add profile picture - jpg/png (optional)</label>
              <input type="file" name="picture" accept="image/*">
              <span class="picture"></span>
            </div>
            <div class="input-wrapper">
              <input type="password" name="pass1" value="" placeholder="New password" required>
              <span class="pass1"></span>
            </div>
            <div class="input-wrapper">
              <input type="password" name="pass2" value="" placeholder="Confirm password" required>
              <span></span>
            </div>
            <div class="input-wrapper btn">
              <button type="submit" class="submitBtn" name="register_person">JOIN</button>
              <button type="button" class="loadBtn"><i class="fas fa-spinner fa-pulse"></i> Please wait</button>
              <a onclick="switch_elements('login_form','link2')">I've an account already</a>
            </div>
            </form>

          <!--- Institutional account ------>
          <form id="institutionalReg" enctype="multipart/form-data" method="post" onsubmit="create_account('institutionalReg',event)">
            <span class="form-header">Create new institutional account..</span>
            <span class="smsError"></span>
            <span class="smsSuccess"></span>
            <div class="input-wrapper">
              <label>Choose the type of account</label>
              <select form="institutionalReg" name="accType" id="accType_Inst" onchange="switchForms(this)">
                <option value="">Account type..</option>
                <option value="1">Personal account</option>
                <option value="2">Institutional/group account</option>
              </select>
              <span></span>
            </div>
            <div class="input-wrapper">
              <input type="text" name="fname" value="" placeholder="Institution/company/group name" required>
              <span class="fname"></span>
            </div>
            <div class="input-wrapper">
              <input type="text" name="location" value="" placeholder="Location address" required>
              <span class="location"></span>
            </div>
            <div class="input-wrapper">
              <input type="email" name="email" value="" placeholder="Email address" required>
              <span class="email"></span>
            </div>
            <div class="input-wrapper">
              <input type="number" name="phone" value="" placeholder="Phone number" required>
              <span class="phone"></span>
            </div>
            <div class="input-wrapper">
              <textarea name="bio" placeholder="Institution/company/group bio.." required></textarea>
              <span class="bio"></span>
            </div>
            <div class="input-wrapper">
              <label>Add profile picture - jpg/png (optional)</label>
              <input type="file" name="picture" accept="image/*">
              <span class="picture"></span>
            </div>
            <div class="input-wrapper">
              <input type="password" name="pass1" value="" placeholder="New password" required>
              <span class="pass1"></span>
            </div>
            <div class="input-wrapper">
              <input type="password" name="pass2" value="" placeholder="Confirm password" required>
              <span class="pass2"></span>
            </div>
            <div class="input-wrapper btn">
              <button type="submit" name="register_inst">JOIN</button><br>
              <a onclick="switch_elements('login_form','link2')">I've an account already</a>
            </div>
          </form>

          <!-- Password reset form -->
          <form id="passReset_form" action="" method="post" autocomplete="off">
            <span class="form-header">Reset password..</span>
            <span class="form-message"></span>
            <div class="input-wrapper">
              <label>Enter your email address</label>
              <input type="email" name="email" value="" placeholder="Email address" required>
              <span></span>
            </div>
            <div class="input-wrapper btn">
              <button type="submit" name="reset_Button">RESET</button><br>
              <a onclick="switch_elements('login_form','link2')">I've just remembered my password!</a>
            </div>
          </form>

          <!-- About us text -->
          <div class="welcome well" id="aboutId">
            ABOUT findmate.....
          </div>

          <!-- Help text -->
          <div class="welcome well" id="helpId">
            How to enable JavaScript in case it's disabled in your browser..<br>
            1. &nbsp; Open settings in your browser<br>
            2. &nbsp
          </div>
        </div>
      </div>
      <?php include "common/footer.html"; ?>
    </div>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/master.js"></script>
    <script src="assets/js/ajax/newaccount-and-login.js"></script>
  </body>
</html>
