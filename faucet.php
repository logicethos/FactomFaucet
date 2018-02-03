<?php

inclide("wallet.php");

$isEC = substr($_POST["address"],0,2) === "EC";
$isFA = substr($_POST["address"],0,2) === "FA";

#Check address entered
if (strlen($_POST["address"])!=52 || (!$isEC && !$isFA))
{
 die("Invalid address. Must start with FA or EC, and be 52 characters long.");
}


# Verify captcha
$post_data = http_build_query(
    array(
        'secret' => $_SERVER["RECAPTCHA_SECRET"],
        'response' => $_POST['g-recaptcha-response'],
        'remoteip' => $_SERVER['REMOTE_ADDR']
    )
);
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $post_data
    )
);
$context  = stream_context_create($opts);
$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
$result = json_decode($response);


if (!$result->success)
{
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");         
}
else
{
  if ($isEC)
  {
    $output = shell_exec("/go/bin/factom-cli buyec ".$walletAddress." ".$_POST["address"]." ".$ecToGive." 2>&1"); 
  }
  else
  {
    $output = shell_exec("/go/bin/factom-cli sendfct ".$walletAddress." ".$_POST["address"]." ".$fctToGive." 2>&1");
  }
  echo "<pre>$output</pre>";                 
 
}

?>
<button onclick="history.go(-1);">Back </button>