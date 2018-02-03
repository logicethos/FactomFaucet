<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
 </head>
 <body>
  <p>
  <h1>Factom Faucet</h1>
  </p>
  <script src='https://www.google.com/recaptcha/api.js'></script>

  <form action="faucet.php" target="_self" method="post">
      <div> 
       <input type="text" name="address" id="address" placeholder="FCT or EC Address" size="35" style="width: 500px;" >
      </div>
      <p>
            <div class="g-recaptcha" data-sitekey="<?php echo $_SERVER["RECAPTCHA"];?>"></div>
      </p>
      <div>
       <button>Submit</button>
      </div>
  </form>
 </body>
</html>
