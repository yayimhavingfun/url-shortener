<?php
    include "config.php";
    if(isset($_GET['id'])) {
        $url_id = mysqli_real_escape_string($con, $_GET['id']);
        $sql = mysqli_query($con, "DELETE FROM url WHERE id = '$url_id'");
    } elseif ($_GET['delete'] == 'all') {
        $delete_query = mysqli_query($con, "DELETE FROM url");
    }
    header("Location: ../");