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

///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
//activatePrice($config, $db);
//transliteAliasProduct($config, $db);
//transliteAliasCategory($config, $db);
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

function activatePrice ($config, $db) {
	$query_product = "SELECT virtuemart_product_id FROM ".$config->dbprefix."virtuemart_products";
	$product_result = $db->query($query_product);

	while ($product_array = $product_result->fetch_row()) {

		$query_update_price = "UPDATE ".$config->dbprefix."virtuemart_product_prices SET virtuemart_shoppergroup_id = 0 WHERE virtuemart_product_price_id = ". $product_array[0];
		$db->query($query_update_price);
		//echo "UPDATE ".$config->dbprefix."virtuemart_product_prices SET virtuemart_shoppergroup_id = 0 WHERE virtuemart_product_price_id = ". $product_array[0]."<br/>";
	}
}

function transliteAliasCategory($config, $db){
	$query_category = "SELECT slug, virtuemart_category_id FROM ".$config->dbprefix."virtuemart_categories".$config->lang;
	$category_result = $db->query($query_category);

	while ($category_array = $category_result->fetch_row()) {
		$category_arr_tranlit = (string) encodestring($category_array[0]);
		$query_update_slug_category = "UPDATE ".$config->dbprefix."virtuemart_categories".$config->lang. " SET slug = '".$category_arr_tranlit."' WHERE virtuemart_category_id = ". $category_array[1];
		$db->query($query_update_slug_category);
		//echo "UPDATE ".$config->dbprefix."virtuemart_categories".$config->lang. " SET slug = '".$category_arr_tranlit."' WHERE virtuemart_category_id = ". $category_array[1]."<br/>";
	}
}

function transliteAliasProduct($config, $db){
	$query_product = "SELECT slug, virtuemart_product_id FROM ".$config->dbprefix."virtuemart_products".$config->lang;
	$product_result = $db->query($query_product);

	while ($product_array = $product_result->fetch_row()) {
		$product_arr_tranlit = (string) encodestring($product_array[0]);
		$query_update_slug_product = "UPDATE ".$config->dbprefix."virtuemart_products".$config->lang. " SET slug = '".$product_arr_tranlit."' WHERE virtuemart_product_id = ". $product_array[1];
		$db->query($query_update_slug_product);
		//echo "UPDATE ".$config->dbprefix."virtuemart_products".$config->lang. " SET slug = '".$product_arr_tranlit."' WHERE virtuemart_product_id = ". $product_array[1]."<br/>";
	}
}

function encodestring($string) 
{ 
	$table = array(
					"Є"=>"YE","І"=>"I","Ѓ"=>"G","і"=>"i","№"=>"-","є"=>"ye","ѓ"=>"g",
					"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
					"Е"=>"E","Ё"=>"YO","Ж"=>"ZH",
					"З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
					"М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
					"С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"CH",
					"Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'",
					"Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA",
					"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
					"е"=>"e","ё"=>"yo","ж"=>"zh",
					"з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
					"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
					"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"ch",
					"ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
					"ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
					" "=>"_","—"=>"_",","=>"_","!"=>"_","@"=>"_",
					"#"=>"-","$"=>"","%"=>"","^"=>"","&"=>"","*"=>"",
					"("=>"",")"=>"","+"=>"","="=>"",";"=>"",":"=>"",
					"'"=>"","~"=>"","`"=>"","?"=>"","/"=>"",
					"["=>"","]"=>"","{"=>"","}"=>"","|"=>""
	);

	return str_replace(array_keys($table), array_values($table),$string);
}

$db->close();
?>