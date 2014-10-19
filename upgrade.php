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

function activatePrice ($config, $db) {
	$query_product = "SELECT virtuemart_product_id FROM ".$config->dbprefix."virtuemart_products";
	$product_result = $db->query($query_product);

	while ($product_array = $product_result->fetch_row()) {

		$query_update_price = "UPDATE ".$config->dbprefix."virtuemart_product_prices SET virtuemart_shoppergroup_id = 0 WHERE virtuemart_product_price_id = ". $product_array[0];
		$db->query($query_update_price);
		//echo "UPDATE ".$config->dbprefix."virtuemart_product_prices SET virtuemart_shoppergroup_id = 0 WHERE virtuemart_product_price_id = ". $product_array[0]."<br/>";
	}
}

$db->close();
?>