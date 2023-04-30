<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->IncludeComponent(
    'OM:product-by-article',
    ''
);
