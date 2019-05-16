<?php

$recaptchaAPI = "https://www.google.com/recaptcha/api/siteverify";
$recaptchaSiteKey = "";
$recaptchaSecretKey = "";

if (!$_POST){
    $alert = '';
}else{

    $recaptchaResponse = trim( $_POST['recaptchaResponse'] );

    $recaptcha = file_get_contents("$recaptchaAPI?secret=$recaptchaSecretKey&response=$recaptchaResponse");
    $res = json_decode( $recaptcha );

    // echo var_dump($res);

    if( !($res->success == true) || !($res->score >= 0.5) ){
        $alert = 'You seems to be a robot, please refresh the page and try sending form again';
    }else{
        $alert = "Thanks! We'll get back to you asap"; //Success message
    }

}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>CreativeWay Digital Agency</title>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptchaSiteKey; ?>"></script>
        <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo $recaptchaSiteKey; ?>', {action: 'homepage'}).then(function(token) {
                var el = document.getElementById('recaptchaResponse');
                el.value = token
                // console.log(el)
            });
        });
        </script>
    </head>
    <body>
        <h2>Get it touch</h2>
            <form action="index.php" method="post">
                <div><input id="name" type="text" name="name" required placeholder="Name*" /></div>
                <div><input id="email" type="email" name="email"  required placeholder="Email*" /></div>
                <div><input id="phone" type="telephone" name="phone"  required placeholder="Phone*" /></div>
                <div><input id="subject" type="text" name="subject" placeholder="Subject" /></div>
                <div><textarea id="message" name="message" placeholder="Message" rows="4"></textarea></div>
                <input type="hidden" id="recaptchaResponse" name="recaptchaResponse" value="">
                <div><input type="submit" name="submit" value="Send" /></div>
                <h3><?php echo $alert ?></h3>
            </form>
    </body>
</html>