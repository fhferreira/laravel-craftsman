<?php

namespace Tests\Feature;

use App\CraftsmanFileSystem;
use Carbon\Carbon;
use PHPUnit\Framework\Assert;
use Tests\TestCase;
use Tests\TestHelpersTrait;

/**
 * Class CraftMigrationTest
 * @package Tests\Feature
 */
class CraftMigrationTest extends TestCase
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

        $this->withoutExceptionHandling();

        $this->fs = new CraftsmanFileSystem();
    }

    /** @test */
    public function should_execute_default_craft_migration_command()
    {
        $class = "CreateTestsTable";
        $model = "App/Models/Test";
        $migrationName = "create_tests_table";

        $this->artisan("craft:migration {$migrationName} --model {$model}")
            ->assertExitCode(0);

        $this->assertMigrationFileExists($migrationName);

        $filename = $this->fs->getLastFilename("database/migrations", $migrationName);

        $this->assertFileContainsString($filename, $class);
        $this->assertFileContainsString($filename, "Schema::create('tests', function (Blueprint \$table) {");

        $this->fs->rmdir("database/migrations");
    }

    /** @test */
    public function should_execute_craft_migration_command_with_table()
    {
        $model = "App/Models/Test";
        $tablename = "tests";
        $migrationName = "create_tests_table";

        $this->artisan("craft:migration {$migrationName} --model {$model} --tablename {$tablename}")
            ->assertExitCode(0);

        $this->assertMigrationFileExists($migrationName);

        $this->fs->rmdir("database/migrations");
    }

    /** @test */
    public function should_create_migration_with_fields()
    {
        $model = "App/Models/Contacts";
        $tablename = "contacts";
        $migrationName = "create_contacts_table";
        $fieldList = "--fields fname:string@25:nullable,lname:string@50:nullable,email:string@80:nullable:unique,dob:datetime,notes:text,deleted_at:timezone";

        $this->artisan("craft:migration {$migrationName} --model {$model} --tablename {$tablename} --fields {$fieldList}")
            ->assertExitCode(0);

        $this->assertMigrationFileExists($migrationName);

        $migrationFilename = $this->fs->getLastFilename("database/migrations", $migrationName);
        $data = file_get_contents($migrationFilename);

        $this->assertStringContainsString("\$table->string('fname',25)->nullable();", $data);
        $this->assertStringContainsString("\$table->string('lname',50)->nullable();", $data);
        $this->assertStringContainsString("\$table->string('email',80)->nullable()->unique();", $data);
        $this->assertStringContainsString("\$table->datetime('dob');", $data);
        $this->assertStringContainsString("\$table->text('notes');", $data);
        $this->assertStringContainsString("\$table->timezone('deleted_at');", $data);

        $this->fs->rmdir("database/migrations");
    }

    /** @test */
    public function should_build_complex_field_data()
    {

        $migrationName = "create_test_migration";
        $dt = Carbon::now()->format('Y_m_d_His');
        $migrationFilename = $dt."_".$migrationName;

        $fields = "first_name:string@20:nullable, last_name:string@60:nullable, email:string@80:nullable:unique";

        $data = [
            "model" => "App/Models/Test",
            "tablename" => "tests",
            "fields" => $fields,
        ];

        $this->fs->createFile("migration", $migrationFilename, $data);

        $lastFilename = $this->fs->getLastFilename("database/migrations", $migrationName);

        $this->assertFileExists($lastFilename);

        $this->assertFileContainsString($lastFilename, "\$table->string('first_name',20)->nullable();");

        unlink($lastFilename);
    }


    // check to see if migration file was created. Since the filename is changed (adding timestamp)
    // we can only validate the core migration ($migrationName) is actually created
    /**
     * @param $migrationName
     */
    private function assertMigrationFileExists($migrationName)
    {
        foreach (scandir("database/migrations") as $filename) {
            if (!strpos($filename, $migrationName)) {
                Assert::assertTrue(true);
                return;
            }
        }

        Assert::assertTrue(false);
    }
}
