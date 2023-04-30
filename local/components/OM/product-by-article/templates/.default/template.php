<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="task-3-wrapper">
    <input type="text" id="product-article" placeholder="Введите артикул товара">
    <div class="prod-wrapper js-prod-wrapper">
            <div id="product-name" class="product-name"></div>
            <div id="product-price" class="product-price"></div>
            <label for="product-quantity">Количество:</label>
            <input type="number" id="product-quantity" value="1" min="1">
            <input type="submit" id="add-to-basket" value="Добавить">
    </div>
</div>
