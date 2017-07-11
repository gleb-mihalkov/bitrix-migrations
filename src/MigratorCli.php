<?php
namespace Arrilot
{
  use Arrilot\BitrixMigrations\Commands\MakeCommand;
  use Arrilot\BitrixMigrations\Commands\InstallCommand;
  use Arrilot\BitrixMigrations\Commands\MigrateCommand;
  use Arrilot\BitrixMigrations\Commands\RollbackCommand;
  use Arrilot\BitrixMigrations\Commands\TemplatesCommand;
  use Arrilot\BitrixMigrations\Commands\StatusCommand;
  use Arrilot\BitrixMigrations\Migrator;
  use Arrilot\BitrixMigrations\Storages\BitrixDatabaseStorage;
  use Arrilot\BitrixMigrations\TemplatesCollection;
  use Symfony\Component\Console\Application;

  /**
   * Содержит методы, для организации интерфейса командной строки в любом файле.
   */
  class MigratorCli
  {
    /**
     * Подключает пролог Битрикса.
     * @param  string $documentRoot Путь к корню сайта.
     * @return void
     */
    protected static function includeProlog($documentRoot)
    {
      $isIncluded = defined('INIT_INCLUDED') || INIT_INCLUDED === true;
      if ($isIncluded) return;

      $_SERVER['DOCUMENT_ROOT'] = $documentRoot;
      require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
    }

    /**
     * Загружает необходимые для работы мигратора модули Битрикс.
     * @return void
     */
    protected static function includeModules()
    {
      CModule::IncludeModule('iblock');
      CModule::IncludeModule('highloadblock');
    }

    /**
     * Инициализирует командный интерфейс мигратора.
     * @param  string $directory Путь к папке с миграциями для установки.
     * @param  string $table     Имя таблицы с установленными миграциями.
     * @return void
     */
    protected static function init($directory, $table)
    {
      $config = array('dir' => $directory, 'table' => $table);

      $database = new BitrixDatabaseStorage($table);
      $templates = new TemplatesCollection();
      $templates->registerBasicTemplates();

      $migrator = new Migrator($config, $templates, $database);

      $app = new Application('Migrator');
      $app->add(new MakeCommand($migrator));
      $app->add(new InstallCommand($table, $database));
      $app->add(new MigrateCommand($migrator));
      $app->add(new RollbackCommand($migrator));
      $app->add(new TemplatesCommand($templates));
      $app->add(new StatusCommand($migrator));
      $app->run();
    }

    /**
     * Запускает интерфейс командной строки.
     * @param  string $documentRoot Корень сайта.
     * @param  string $directory    Путь к папке с миграциями для установки.
     * @param  string $table        Имя таблицы с установленными миграциями.
     * @return void
     */
    public static function start($documentRoot, $directory, $table)
    {
      self::includeProlog($documentRoot);
      self::includeModules();
      self::init($directory, $table);
    }
  }
}