<?php
$BOT_USERNAME = 'w_tracker_bot';
$BOT_TOKEN = '6029416728:AAHwd2YQYtT52jMsN8HfZQ3zxpTboKdcVWQ';
$REDIRECT_URI = 'https://alice8080.github.io/testt/';

function checkTelegramAuthorization($auth_data) {
    $check_hash = $auth_data['hash'];
    unset($auth_data['hash']);
    $data_check_arr = [];
    foreach ($auth_data as $key => $value) {
      $data_check_arr[] = $key . '=' . $value;
    }
    sort($data_check_arr);
    $data_check_string = implode("\n", $data_check_arr);
    $secret_key = hash('sha256', BOT_TOKEN, true);
    $hash = hash_hmac('sha256', $data_check_string, $secret_key);
    if (strcmp($hash, $check_hash) !== 0) {
      throw new Exception('Data is NOT from Telegram');
    }
    if ((time() - $auth_data['auth_date']) > 86400) {
      throw new Exception('Data is outdated');
    }
    return $auth_data;
  }

    if (isset($_GET['hash'])) {
        try {
            $auth_data = checkTelegramAuthorization($_GET);
            echo "Hello, " . $auth_data['username'];
        } catch (Exception $e) {
            die ($e->getMessage());
        }
    }  
?>

<html>
    <body>
    <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="w_tracker_bot" data-size="large" data-onauth="onTelegramAuth(user)" data-request-access="write"></script>
    <script type="text/javascript">
    function onTelegramAuth(user) {
        alert('Logged in as ' + user.first_name + ' ' + user.last_name + ' (' + user.id + (user.username ? ', @' + user.username : '') + ')');
    }
    </script>

    </body>
</html>
