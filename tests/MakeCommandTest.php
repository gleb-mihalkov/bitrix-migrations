<?php

namespace Arrilot\Tests\BitrixMigrations;

use Mockery as m;

class MakeCommandTest extends TestCase
{
    protected function mockCommand($files)
    {
        $database = m::mock('Arrilot\BitrixMigrations\Interfaces\DatabaseRepositoryInterface');

        return m::mock('Arrilot\BitrixMigrations\Commands\MakeCommand[abort, info, message, getMigrationObjectByFileName]',
                [$this->getConfig(), $database, $files]
            )
            ->shouldAllowMockingProtectedMethods();
    }

    public function testItCreatesAMigrationFile()
    {
        $files = m::mock('Arrilot\BitrixMigrations\Interfaces\FileRepositoryInterface');
        $files->shouldReceive('createDirIfItDoesNotExist')->once();
        $files->shouldReceive('getContent')->once()->andReturn('class ClassPlaceholder {}');
        $files->shouldReceive('putContent')->once();

        $command = $this->mockCommand($files);
        $command->shouldReceive('message')->once();
        $command->registerTemplate([
            'name'        => 'default',
            'path'        => '/vendor/arrilot/bitrix-migrations/templates/migration.default.template',
            'description' => 'Default migration template',
        ]);

        $this->runCommand($command, ['test_migration']);
    }
}
