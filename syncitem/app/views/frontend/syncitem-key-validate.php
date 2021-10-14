<?php
if (isset($_POST['Email'])) {

    function problem($error)
    {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }

    // validation expected data exists
    if (!isset($_POST['Email'])) {
        problem('We are sorry, but there appears to be a problem with the form you submitted.');
    }
    $email = $_POST['Email'];

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'The Email address you entered does not appear to be valid.<br>';
    }


    if (strlen($error_message) > 0) {
        problem($error_message);
    }
	
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

	
$url = 'https://dt25ugr2rh.execute-api.ap-southeast-1.amazonaws.com/api/register';
$ch = curl_init($url);
$data = array(
    'domain' => $actual_link,
    'email' => $email
);
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$results = json_decode($result);
$mainres = json_decode($results->output);

if(isset($mainres->statusCode) && $mainres->statusCode == 200){
    echo'<h2 class="result">'.$mainres->body->send.'</h2>';
}else{
    echo'<h2 class="result">'.$mainres[0]->message.'</h2>';
}
/*
	echo'<pre>';
	print_r(json_decode($results->output)); echo'<br>';
	print_r($result);
	print_r($results);
	echo'</pre>';
*/
}else{
?>

<form id="fcf-form-id" class="fcf-form-class" method="post" action="">
    <div class="container-fluid">
      <div class="row">
        <main>
          <div class="container">
            <div class="row">
              <div class="col-md-8 offset-md-2">
                <h1 class="text-center mt-5">Let's Get Started</h1>
                <div class="text-center pt-4">
                  <img src="<?= plugin_dir_url( __FILE__ ) ?>plugin-logo.jpg">
                </div>
                <table class="table table-striped table-sm table-startup mt-4">
                  <tbody>
                    <tr>
                      <td width="160px" >Email:</td>
                      <td><input name="Email" type="email" class="form-control"></td>
                    </tr>
                  </tbody>
                </table>
                <div class="text-center mt-4">
                  <button type="submit" class="btn btn-primary">Okay! Register Now!</button>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
</form>
<?php } ?>