<?php

declare(strict_types=1);

namespace OfficeMag\IblockHelper;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

try {
    Loader::includeModule("iblock");
} catch (LoaderException $e) {
}

class IblockHelper
{
    /**
     * Возвращает id инфоблока по символьному коду
     *
     * @param $iblockCode
     * @return mixed
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getIblockIdByCode($iblockCode): mixed
    {
        $result = IblockTable::getList([
            'filter' => [
                '=CODE' => $iblockCode,
            ],
            'select' => ['ID'],
        ])->fetch();

        if ($result) {
            return $result['ID'];
        }

        return false;
    }
}
