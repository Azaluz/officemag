<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->IncludeComponent(
    'OM:product-by-article',
    ''
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
