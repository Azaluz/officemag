<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Config\Option;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Mail\Event;

/**
 * Компонент добавления товара по артикулу
 */
class PopupErrorSender extends CBitrixComponent implements Controllerable
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
        return [
            'sendMail' => [
                'prefilters' => []
            ],
        ];
    }

    /**
     * Функция для рассылки текста ошибки
     *
     * @param string $text
     *
     * @return void
     */
    public function sendMailAction(string $text): void
    {
        Event::send([
            'EVENT_NAME' => 'FEEDBACK_FORM',
            'LID' => SITE_ID,
            'C_FIELDS' => [
                'EMAIL_TO' => Option::get("main", "email_from"),
                'TEXT' => $text,
            ],
        ]);
    }
}
