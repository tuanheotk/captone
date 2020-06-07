<?php
  session_start();
  require_once('api-oauth.php');
  require_once('api-outlook.php');
  $auth_code = $_GET['code'];
  $redirectUri = 'http://localhost/event/api-authorize.php';
  
  $tokens = oAuthService::getTokenFromAuthCode($auth_code, $redirectUri);
  if ($tokens['access_token']) {
    $_SESSION['access_token'] = $tokens['access_token'];
    $_SESSION['refresh_token'] = $tokens['refresh_token'];

    // expires_in is in seconds
    // Get current timestamp (seconds since Unix Epoch) and
    // add expires_in to get expiration time
    // Subtract 5 minutes to allow for clock differences
    $expiration = time() + $tokens['expires_in'] - 300;
    $_SESSION['token_expires'] = $expiration;
    
    // Get the user's email & code
    $user = OutlookService::getUser($tokens['access_token']);

    $_SESSION['user_email'] = $user['EmailAddress'];
    $_SESSION['user_code'] = $user['DisplayName'];

    $email = $user['EmailAddress'];
    $code = $user['DisplayName'];

    // Check dont exist on db
    require('database-config.php');
    $sqlSearch = "SELECT id FROM account WHERE email = '".$email."'";
    $resultSearch = mysqli_query($conn, $sqlSearch);

    if (mysqli_num_rows($resultSearch) == 0) {
      // insert new account
      $sqlInsert = "INSERT INTO account(code, email) VALUES('".$code."', '".$email."')";
      $resultInsert = mysqli_query($conn, $sqlInsert);
    }

    // $sqlRole = "SELECT role FROM account WHERE email = '".$email."'";
    // $resultRole = mysqli_query($conn, $sqlRole);
    // $row = mysqli_fetch_assoc($resultRole);
    // $_SESSION["role"] = $row["role"];

    // Check Block
    // $sqlStatus = "SELECT status FROM account WHERE email = '".$email."'";
    // $resultStatus = mysqli_query($conn, $sqlStatus);
    // $rowStt = mysqli_fetch_assoc($resultStatus);

    // if ($rowStt["status"] == 0) {
    //   $_SESSION["disabled"] = true;
    // }
    
    
    // Redirect back to home page
    header("Location: /event");
  }
  else
  {
    echo "<p>ERROR: ".$tokens['error']."</p>";
  }
?>