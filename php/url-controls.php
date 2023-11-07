<?php
    include "config.php";
    $full_url = mysqli_real_escape_string($con, $_POST['full_url']);

    if (!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)){
        $rand_url = substr(md5(microtime()), rand(0, 26), 5);
        $query = mysqli_query($con, "SELECT short_url FROM url WHERE short_url = '$rand_url'");
        if (mysqli_num_rows($query) > 0) {
            echo "Something went wrong. Please regenerate the url";
        } else {
            $sql = mysqli_query($con, "INSERT INTO url (short_url, full_url, clicks) VALUES ('$rand_url', '$full_url', '0' )");
            if ($sql) {
                $short_url_query = mysqli_query($con, "SELECT short_url FROM url WHERE short_url = '$rand_url'");
                $short_url = mysqli_fetch_assoc($short_url_query);
                echo $short_url['short_url'];
            } else {
                echo "Something went wrong. Please try again.";
            }
        }
    } else {
        echo "$full_url - невалидный URL-адрес";
    }
