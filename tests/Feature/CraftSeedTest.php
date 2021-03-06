<?php

namespace Tests\Feature;

use App\CraftsmanFileSystem;
use Tests\TestCase;
use Tests\TestHelpersTrait;

/**
 * Class CraftSeedTest
 * @package Tests\Feature
 */
class CraftSeedTest extends TestCase
{
    use TestHelpersTrait;

    /**
     * @var CraftsmanFileSystem
     */
    protected $fs;

    /**
     *
     */
    function setUp(): void
    {
        parent::setUp();

        $this->fs = new CraftsmanFileSystem();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function should_execute_craft_seed_command()
    {
        $class = "TestsTableSeeder";
        $model = "Test";
        $rows = "25";

        $this->artisan("craft:seed TestsTableSeeder --model App/Models/{$model} --rows {$rows}")
            ->assertExitCode(0);

        $seedPath = $this->fs->seed_path();
        $filename = $this->pathJoin($seedPath, "{$class}.php");

        $this->assertFileContainsString($filename, "class {$class} extends Seeder");
        $this->assertFileContainsString($filename, "factory({$model}::class,{$rows})->create();");

        $this->fs->rmdir("database/seeds");
    }
}
