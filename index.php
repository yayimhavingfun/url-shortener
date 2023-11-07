<?php
    include "php/config.php";
    if (isset($_GET)) {
        $new_url = '';
        foreach ($_GET as $key=>$val) {
            $u = mysqli_real_escape_string($con, $key);
            $new_url = str_replace('/', '', $u);
        }
        $sql = mysqli_query($con, "SELECT full_url FROM url WHERE short_url = '$new_url'");
        if (mysqli_num_rows($sql) > 0) {
            $clicks_query = mysqli_query($con, "UPDATE url SET clicks = clicks + 1 WHERE short_url = '$new_url'");
            if ($clicks_query) {
                $full_url = mysqli_fetch_assoc($sql);
                header("Location:" . $full_url['full_url']);
            }
        }
    }

    $display_count = mysqli_query($con, "SELECT clicks FROM url");
    $total = 0;
    while ($count = mysqli_fetch_assoc($display_count)) {
    $total += $count['clicks'];
    }

    $display_sql = mysqli_query($con, "SELECT * FROM url ORDER BY id DESC");
    $rows = mysqli_fetch_all($display_sql, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
</head>
<body>
    <div class="wrapper">
        <form action="#">
            <i class="url-icon uil uil-link"></i>
            <input type="text" name="full_url" placeholder="Вставьте длинный URL адрес" required>
            <button>Сократить</button>
        </form>
        <?php if (mysqli_num_rows($display_sql) > 0): ?>
            <div class="count">
                <span>Всего ссылок: <span><?= mysqli_num_rows($display_sql)?></span> и всего кликов: <span><?= $total?></span></span>
                <a href="php/delete.php?delete=all">Очистить все</a>
            </div>
            <div class="url-zone">
                <ul class="title">
                    <li>Короткий</li>
                    <li>Оригинальный</li>
                    <li>Клики</li>
                    <li>Действие</li>
                </ul>
                <?php foreach ($rows as $row):?>
                <ul class="links">
                    <li><a href="http://urls/'<?= $row['short_url'] ?>"><?= 'http://urls/'.$row['short_url']?></a></li>
                    <li><?php if ('http://urls/'.strlen($row['full_url']) > 65) {echo substr($row['full_url'], 0, 65).'...';} else {echo $row['full_url'];}?> </li>
                    <li><?= $row['clicks']?></li>
                    <li><a href="php/delete.php?id=<?= $row['id'] ?>">Удалить</a></li>
                </ul>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div>
    <div class="blur-effect"></div>
    <div class="popup-box">
        <div class="info">
            Ваша короткая ссылка готова! Вы можете отредактировать её сейчас, после сохранения отредактировать не получится!
        </div>
        <form>
            <label>Отредактировать ссылку:</label>
            <input type="text" spellcheck="false" value="example.com/xyz123">
            <i class="copy-icon uil uil-copy-alt"></i>
            <button>Сохранить</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
