# Bitrix-migrations (fork)

*Форк проекта [arrilot/bitrix-migrations](https://github.com/arrilot/bitrix-migrations).*

## Изменения

* Добавлен класс `Arrilot\BitrixMigrations\MigratorCli`, превращающий в интерфейс командной строки любой php-файл.

* Таким образом, мигратор может быть установлен в любую папку, а не только в корень проекта.

* Команда `install` больше не выдает ошибку, если таблица с миграциями уже создана.

## Подключение

* Создайте файл `migrator.php`.

* Добавьте в него следующий код:

```php
require 'vendor/autoload.php';
Arrilot\BitrixMigrations\MigratorCli('document_root', 'path_to_migrations_folder', 'migrations_table_name');
```

* Теперь этот файл стал интерфейсом командной строки - теперь он может обрабатывать команды `php migrator.php install` и так далее (см. [документацию](https://github.com/arrilot/bitrix-migrations#Доступные-команды) основного проекта).