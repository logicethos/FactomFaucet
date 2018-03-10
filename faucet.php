<p>
<?php

include("wallet.php");

$isEC = substr($_POST["address"],0,2) === "EC";
$isFA = substr($_POST["address"],0,2) === "FA";

$factomcli = "/go/bin/factom-cli -s ".$_SERVER["FACTOMD"];
   
#Check address entered
if (strlen($_POST["address"])!=52 || (!$isEC && !$isFA))
{
   echo "Invalid address. Must start with FA or EC, and be 52 characters long.";
}
else
{

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
    echo "reCAPTCHA failed. Go back and try it again.";
   }
   else
   {   
       if ($isEC)
       {
          $output = shell_exec($factomcli." buyec ".$walletAddress." ".$_POST["address"]." ".$ecToGive." 2>&1"); 
       }
       else
       {
          $output = shell_exec($factomcli." sendfct ".$walletAddress." ".$_POST["address"]." ".$fctToGive." 2>&1");
       }
       echo "<pre>$output</pre>";
   }
}

?>
</p>
<button onclick="history.go(-1);">Back </button>
