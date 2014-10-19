<?php

require_once 'configuration.php';

$config = new JConfig;

$config->lang = '_ru_ru';

$db = new mysqli($config->host, $config->user, $config->password, $config->db);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} elseif (!mysqli_set_charset($db, "utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", mysqli_error($db));
}

$db->close();
?>