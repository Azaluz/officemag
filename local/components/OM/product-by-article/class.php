<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Catalog\PriceTable;
use Bitrix\Currency\CurrencyLangTable;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Iblock\ElementPropertyTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;

/**
 * Компонент добавления товара по артикулу
 */
class ProductByArticle extends CBitrixComponent implements Controllerable
{
    /**
     * Выполнение компонента
     *
     * @return void
     */
    public function executeComponent(): void
    {
        $this->IncludeComponentTemplate();
    }

    /**
     * Конфигурация экшенов компонента
     *
     * @return array
     */
    public function configureActions(): array
    {
        return [];
    }

    /**
     * Возвращает элемент по артикулу
     *
     * @param string $article
     *
     * @return string|false
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException|LoaderException
     */
    public function getProductAction(string $article): bool|string
    {
        Loader::includeModule('catalog');

        $rsItem = PropertyTable::getList([
            'select' => [
                'PRODUCT_ID' => 'PROD.ID',
                'PRODUCT_NAME' => 'PROD.NAME',
                'PRICE' => 'PRICE_LIST.PRICE',
                'CURRENCY_SYMBOL' => 'CURRENCY_LANG.FORMAT_STRING',
            ],
            'filter' => [
                '=CODE' => 'ARTNUMBER',
                '=PROPERTIES.VALUE' => $article,
            ],
            'runtime' => [
                'PROPERTIES' => [
                    'data_type' => ElementPropertyTable::class,
                    'reference' => [
                        '=this.ID' => 'ref.IBLOCK_PROPERTY_ID',
                    ],
                    'join_type' => 'left',
                ],
                'PROD' => [
                    'data_type' => ElementTable::class,
                    'reference' => [
                        '=this.PROPERTIES.IBLOCK_ELEMENT_ID' => 'ref.ID',
                    ],
                    'join_type' => 'left',
                ],
                'PRICE_LIST' => [
                    'data_type' => PriceTable::class,
                    'reference' => [
                        '=this.PROD.ID' => 'ref.PRODUCT_ID',
                    ],
                    'join_type' => 'left',
                ],
                'CURRENCY_LANG' => [
                    'data_type' => CurrencyLangTable::class,
                    'reference' => [
                        '=this.PRICE_LIST.CURRENCY' => 'ref.CURRENCY',
                        '=ref.LID' => ['?', LANGUAGE_ID],
                    ],
                    'join_type' => 'left',
                ],
            ],
            'group' => ['ID'],
        ])->fetch();

        $result = [];

        if ($rsItem) {
            $decimalPart = fmod($rsItem['PRICE'], 1);

            if ($decimalPart == 0) {
                $rsItem['PRICE'] = number_format($rsItem['PRICE'], 0, '.', ' ');
            }

            $formattedPrice = html_entity_decode(preg_replace('/#/', $rsItem['PRICE'], $rsItem['CURRENCY_SYMBOL'], 1));
            $result = [
                'ID' => $rsItem['PRODUCT_ID'],
                'NAME' => $rsItem['PRODUCT_NAME'],
                'PRICE' => $formattedPrice,
            ];
        }

        return json_encode($result ?: null);
    }

    /**
     * Добавляет товар в корзину
     *
     * @param string $productId
     * @param int    $quantity
     *
     * @return void
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ArgumentTypeException
     * @throws LoaderException
     * @throws NotImplementedException
     * @throws NotSupportedException
     * @throws ObjectNotFoundException
     */
    public function addToBasketAction(string $productId, int $quantity): void
    {
        Loader::includeModule('sale');
        Loader::includeModule('catalog');

        $basket = Basket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());
        if ($item = $basket->getExistsItems('catalog', $productId)[0]) {
            $item->setField('QUANTITY', $item->getQuantity() + $quantity);
        } else {
            $item = $basket->createItem('catalog', $productId);
            $item->setFields(
                [
                    'QUANTITY' => $quantity,
                    'CURRENCY' => CurrencyManager::getBaseCurrency(),
                    'LID' => Context::getCurrent()->getSite(),
                    'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                ]
            );
        }

        $basket->save();
    }
}
