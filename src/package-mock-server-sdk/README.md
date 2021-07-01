Клиент для доступа к API сайта гос.услуг.

**Реализованно:**

* 
***

**Подключение:**

В composer.json добавить

`{
  "repositories": [{
    "type": "composer",
    "url": "https://packagist.drom.ru"
  }]
}`

**Тесты:**

Для запуска выполнить команду `composer test`

**Перед комминтом:**

Запустить и проверить:
* `composer test`
* `composer phpstan`
* `composer phpcs`
  
Если есть ошибки в phpcs можно запустить:
* `composer phpcbf`
