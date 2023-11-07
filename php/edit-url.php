<?php
    include "config.php";

    $original_url = mysqli_real_escape_string($con, $_POST['original_url']);
    $original_url = str_replace(' ', '', $original_url);
    $gen_str = mysqli_real_escape_string($con, $_POST['gen_str']);

    if (!empty($original_url)){
        if (str_contains($original_url,"http://urls/")){
            $explode_url = explode('/', $original_url);
            $str = end($explode_url);
            if ($str != "" ){
                $select_sql = mysqli_query($con, "SELECT short_url FROM url WHERE short_url = '$str' && short_url != '$gen_str'");
                if (mysqli_num_rows($select_sql) == 0) {
                    $update_sql = mysqli_query($con, "UPDATE url SET short_url = '$str' WHERE short_url = '$gen_str'");
                    if ($update_sql) {
                        echo "success";
                    } else {
                        echo "Что-то пошло не так. Попробуйте еще раз!";
                    }
                } else {
                    echo "Этот URL уже существует!";
                }
            } else {
                echo "Надо ввести короткий URL!";
            }
        } else {
            echo "Нельзя исправлять домен!";
        }
    } else {
        echo "Надо ввести короткий URL!";
    }