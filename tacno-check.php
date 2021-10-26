<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mysejahteri</title>
    <meta name="robots" content="follow, index" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/style.css?v=1.0.2" />

    <?php include 'mysql-db.php' ?>


</head>

<body>
    <?php
        $name = $_POST[name];
        $phone_insert = $_POST[phone];
        $full_phone = $_POST[full_number];
        $country_code = substr($full_phone, 0, strlen($full_phone)-strlen($phone_insert));
        $tac_submitted = $_POST[tac1].$_POST[tac2].$_POST[tac3].$_POST[tac4].$_POST[tac5].$_POST[tac6];
        $verification_status = $_COOKIE[tacNum] === $tac_submitted;
    ?>

    <div class="app__container">
        <div class="app__wrapper">
            <div class="app__logo"><img src="dist/images/svg/cvd_logo.svg" alt="" /></div>
            <div class="app__headline">Enter your <span class="app__name_newln">6-digit TAC</span></div>
            <div class="app__desc app__desc_tacno">
                <?php
                if ($verification_status) {
                    // push new row into database
                    $sql = "INSERT INTO users (name, hp_number, country_code)
                    VALUES ('$name', '$phone_insert', '$country_code')";

                    if ($conn->query($sql) === TRUE) {
                        echo '
                        <p class="app__desc_1">Verification complete. New account registered</p>';
                    
                    } else {
                        echo '
                        <p class="app__desc_1">Error: '.$sql.'<br>'.$conn->error.'</p>';
                    }

                }
                else {
                    echo '
                    <p class="app__desc_1">TAC enterred is incorrect.</p>';
                }
                ?>
            </div>

            <?php
                if ($verification_status) {
                    echo '
                    <form action="scanner.php" method="post">';
                }
                else {
                    echo '
                    <form action="tacno-check.php" method="post">';
                }
          
                echo
                '<input type="hidden" name="name" value="'.$name.'">
                <input type="hidden" name="phone" value="'.$phone_insert.'">
                <input type="hidden" name="full_number" value="'.$full_phone.'">
                <input type="hidden" name="country_code" value="'.$country_code.'">';
                if ($verification_status) {
                    echo '
                    <div class="pin-wrapper">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" value="'.$_POST[tac1].'">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" value="'.$_POST[tac2].'">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" value="'.$_POST[tac3].'">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" value="'.$_POST[tac4].'">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" value="'.$_POST[tac5].'">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" value="'.$_POST[tac6].'">
                    </div>';

                    echo '
                    <div class="form_app_submit_container" style="display: flex; justify-content: flex-end; align-items: center">
                        <button type="submit" class="form_app_submit btn_orange">Complete <span class="next_arrow_icon"><img src="dist/images/svg/arrow_right_white.svg" alt=""></span></button>
                    </div>';
                }
                else {
                    echo '
                    <div class="pin-wrapper">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" name="tac1">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" name="tac2">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" name="tac3">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" name="tac4">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" name="tac5">
                        <input type="text" data-role="pin" maxlength="1" class="pin-input" name="tac6">
                    </div>';
                    echo '
                    <div class="form_app_submit_container" style="display: flex; justify-content: flex-end; align-items: center">
                        <button type="submit" class="form_app_submit btn_orange">Check <span class="next_arrow_icon"><img src="dist/images/svg/arrow_right_white.svg" alt=""></span></button>
                    </div>';
                }
                ?>
            </form>
            
            <?php
                if (!$verification_status) {
                    echo '<form action="tacno-check.php" method="post" style="display: flex; justify-content: flex-end">';
                    $name = $_POST[name];
                    $phone_insert = $_POST[phone];
                    $full_phone = $_POST[full_number];
                    $country_code = substr($full_phone, 0, strlen($full_phone)-strlen($phone_insert));
    
                    echo
                    '<input type="hidden" name="name" value="'.$name.'">
                    <input type="hidden" name="phone" value="'.$phone_insert.'">
                    <input type="hidden" name="full_number" value="'.$full_phone.'">
                    <input type="hidden" name="country_code" value="'.$country_code.'">';
                    
                    echo '<input type="submit" style="color: gray; margin: -34px 120px 0 0; font-size: 15px; text-decoration: underline; cursor: pointer; background-color: transparent" onclick=generateTac() value="Request TAC">
                    </form>';
                }
                ?>




        </div>
        <div class="app__artwork_name"><img src="dist/images/svg/cvd_artwork_tac.svg" alt=""></div>
    </div>

    <?php
        // echo $name;
        // echo $phone_insert;
        // echo $country_code;
        // echo $_COOKIE[tacNum];
        // echo $tac_submitted;
        // echo $verification_status;
    ?>

    <script>
        function generateTac() {
            tacNum = `${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}${Math.floor(Math.random() * 10)}`
            setCookie('tacNum', tacNum, 1)
            alert (`Your TAC number is ${tacNum}`)
        }

        function setCookie(cname, cvalue, exminutes) {
            const d = new Date();
            d.setTime(d.getTime() + (exminutes*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

  
  
    </script>


    <script src="dist/js/jquery-3.2.1.slim.min.js"></script>
    <script src="dist/js/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/pin.js"></script>
    <script src="dist/js/pin.js"></script>
    <script src="dist/js/app.js"></script>



</body>

</html>
