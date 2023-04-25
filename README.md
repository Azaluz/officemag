# officemag
1. Прописываем доступы к бд в .env_template
2. Переименовываем файл .env_template в .env
3. Закидываем [bitrixsetup.php](https://www.1c-bitrix.ru/download/cms.php#tab-subsection-2) в корень проекта
4. Выполняем команду в консоли docker compose up -d (При использовании vpn могут быть проблемы со скачиванием пакетов)
5. Переходим по адресу \*сервер\*/bitrixsetup.php
6. В поле "Сервер баз данных" заполнить названием контейнера mysql (db по дефолту)
