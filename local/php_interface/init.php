<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php';

AddEventHandler("main", "OnProlog", "IncludeComponentOnAllPages");

function IncludeComponentOnAllPages(): void
{
    global $APPLICATION;
    $APPLICATION->IncludeComponent(
        "OM:popup-error-sender",
        ""
    );
}
