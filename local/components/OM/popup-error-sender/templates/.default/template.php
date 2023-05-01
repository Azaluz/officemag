<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div id="popup" class="popup">
    <div class="popup-content">
        <div class="popup-header">
            <h2>Отправить ошибку администратору?</h2>
        </div>
        <div class="popup-body">
            <p id="selected-text"></p>
        </div>
        <div class="popup-footer">
            <button id="send-button">Отправить</button>
            <button id="cancel-button">Отмена</button>
        </div>
    </div>
</div>
