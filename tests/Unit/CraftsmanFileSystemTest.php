<?php

namespace Tests\Unit;

use App\CraftsmanFileSystem;
use Carbon\Carbon;
use Tests\TestCase;
use Tests\TestHelpersTrait;

/**
 * Class CraftsmanFileSystemTest
 * @package Tests\Unit
 */
class CraftsmanFileSystemTest extends TestCase
{
    use TestHelpersTrait;

    /**
     * @var CraftsmanFileSystem
     */
    protected $fs;

    /**
     * CraftsmanFileSystemTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->fs = new CraftsmanFileSystem();
    }

    /**
     * setUp
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        rmdir("resources/views/coverage");
    }

    /** @test */
    public function should_return_correct_controller_path()
    {
        // store models in Models directory in app directory
        $result = $this->fs->path_join(app_path(), "Controllers");

        $path = $this->fs->model_path("Controllers");

        $this->assertSame($result, $path);
    }

    /** @test */
    public function should_return_correct_migration_path()
    {
        // store models in Models directory in app directory
        $result = $this->fs->path_join(app_path(), "migrations");

        $path = $this->fs->model_path("migrations");

        $this->assertSame($result, $path);
    }

    /** @test */
    public function should_return_correct_factory_path()
    {
        // store models in Models directory in app directory
        $result = $this->fs->path_join(app_path(), "factory");

        $path = $this->fs->model_path("factory");

        $this->assertSame($result, $path);
    }

    /** @test */
    public function should_return_correct_default_model_path()
    {
        // store models in Models directory in app directory
        $result = basename(app_path());

        $path = $this->fs->model_path();

        $this->assertSame($result, $path);
    }

    /** @test */
    public function should_return_correct_custom_model_path()
    {
        // store models in Models directory in app directory
        $result = $this->fs->path_join(app_path(), "Models");

        $path = $this->fs->model_path("Models");

        $this->assertSame($result, $path);
    }

    /** @test */
    public function should_return_correct_seed_path()
    {
        // store models in Models directory in app directory
        $result = $this->fs->path_join(app_path(), "seeds");

        $path = $this->fs->model_path("seeds");

        $this->assertSame($result, $path);
    }

    /** @test */
    public function should_return_correct_view_path()
    {
        // store models in Models directory in app directory
        $result = $this->fs->path_join(app_path(), "views");

        $path = $this->fs->model_path("views");

        $this->assertSame($result, $path);
    }

    /** @test */
    public function should_return_class_template_filename()
    {
        $filename = $this->fs->getTemplateFilename("class");

        $this->assertSame("templates/class.mustache", $filename);
    }

    /** @test */
    public function should_return_controller_template_filename()
    {
        $filename = $this->fs->getTemplateFilename("controller");

        $this->assertSame("templates/controller.mustache", $filename);
    }

    /** @test */
    public function should_return_api_controller_filename()
    {
        $filename = $this->fs->getTemplateFilename("api-controller");

        $this->assertSame("templates/api-controller.mustache", $filename);
    }

    /** @test */
    public function should_return_empty_controller_filename()
    {
        $filename = $this->fs->getTemplateFilename("empty-controller");

        $this->assertSame("templates/empty-controller.mustache", $filename);
    }

    /** @test */
    public function should_return_views_filename()
    {
        $filename = $this->fs->getTemplateFilename("view-create");

        $this->assertSame("templates/view-create.mustache", $filename);
    }

    /** @test */
    public function should_tests_filename()
    {
        $filename = $this->fs->getTemplateFilename("test");

        $this->assertSame("templates/test.mustache", $filename);
    }

    /** @test */
    public function should_return_model_filename()
    {
        $filename = $this->fs->getTemplateFilename("model");

        $this->assertSame("templates/model.mustache", $filename);
    }

    /** @test */
    public function should_return_migration_filename()
    {
        $filename = $this->fs->getTemplateFilename("migration");

        $this->assertSame("templates/migration.mustache", $filename);
    }

    /** @test */
    public function should_return_factories_filename()
    {
        $filename = $this->fs->getTemplateFilename("factory");

        $this->assertSame("templates/factory.mustache", $filename);
    }

    /** @test */
    public function should_return_phar_path()
    {
        $path = $this->fs->getPharPath();

        $this->assertSame("", $path);
    }

    /** @test */
    public function should_return_seeds_filename()
    {
        $filename = $this->fs->getTemplateFilename("seed");

        $this->assertSame("templates/seed.mustache", $filename);

    }

    /** @test */
    public function should_return_user_template_path()
    {
        $path = $this->fs->getUserTemplate("./config.php", "sample");

        $this->assertSame("templates/sample.user.mustache", $path);
    }

    /** @test */
    public function should_return_last_filename()
    {
        // This returns files sorted in descending order
        $filename = $this->fs->getLastFilename("tests", "TestCase.php");

        $this->assertSame("tests/CraftsmanTestCase.php", $filename);
    }

    /** @test */
    public function should_return_last_migration_filename()
    {
        $migrationName = "create_customers_file";
        $data = [
            "model" => "App/Models/Customer",
        ];

        $result = $this->fs->createFile("migration", $migrationName, $data);

        $filename = $this->fs->getLastFilename("database/migrations", $migrationName);

        $this->assertSame($result["filename"], $filename);

        $this->fs->rmdir("database/migrations");
    }

    /** @test */
    public function should_return_views_output_path()
    {
        $path = $this->fs->getOutputPath("views");

        $this->assertSame("resources/views", $path);

        $path = $this->fs->getOutputPath("view");

        $this->assertSame("resources/views", $path);
    }

    /** @test */
    public function should_return_class_output_path()
    {
        $path = $this->fs->getOutputPath("class");

        $this->assertSame("app", $path);
    }

    /** @test */
    public function should_return_controller_output_path()
    {
        $path = $this->fs->getOutputPath("controller");

        $this->assertSame("app/Http/Controllers", $path);
    }

    /** @test */
    public function should_return_migrations_output_path()
    {
        $path = $this->fs->getOutputPath("migrations");

        $this->assertSame("database/migrations", $path);

        $path = $this->fs->getOutputPath("migration");

        $this->assertSame("database/migrations", $path);
    }

    /** @test */
    public function should_return_models_output_path()
    {
        $path = $this->fs->getOutputPath("model");

        $this->assertSame("app", $path);
    }

    /** @test */
    public function should_return_seeds_output_path()
    {
        $path = $this->fs->getOutputPath("seeds");

        $this->assertSame("database/seeds", $path);

        $path = $this->fs->getOutputPath("seed");

        $this->assertSame("database/seeds", $path);
    }

    /** @test */
    public function should_return_factories_output_path()
    {
        $path = $this->fs->getOutputPath("factory");

        $this->assertSame("database/factories", $path);

        $path = $this->fs->getOutputPath("factories");

        $this->assertSame("database/factories", $path);
    }

    /** @test */
    public function should_return_tests_output_path()
    {
        $path = $this->fs->getOutputPath("test");

        $this->assertSame("tests", $path);

        $path = $this->fs->getOutputPath("tests");

        $this->assertSame("tests", $path);
    }

    /** @test */
    public function should_call_path_join()
    {
        $filename = $this->fs->path_join("App", "Models", "Test.php");

        $this->assertSame("App/Models/Test.php", $filename);
    }

    /** @test */
    public function should_call_pathjoin()
    {
        $filename = $this->fs->pathJoin("App", "Models", "Test.php");

        $this->assertSame("App/Models/Test.php", $filename);

    }

    /** @test */
    public function should_call_create_view_create()
    {
        $filename = "resources/views/coverage/create.blade.php";

        $data = $this->getDefaultViewOptions(["noCreate" => false]);

        $filenames = $this->fs->createViewFiles("coverage", $data);

        $this->assertContains("create.blade.php", $filenames);

        unlink($filename);

    }

    /** @test */
    public function should_call_create_view_edit()
    {
        $filename = "resources/views/coverage/edit.blade.php";

        $data = $this->getDefaultViewOptions(["noEdit" => false]);

        $filenames = $this->fs->createViewFiles("coverage", $data);

        $this->assertContains("edit.blade.php", $filenames);

        unlink($filename);

    }

    /** @test */
    public function should_call_create_view_index()
    {
        $filename = "resources/views/coverage/index.blade.php";

        $data = $this->getDefaultViewOptions(["noIndex" => false]);

        $filenames = $this->fs->createViewFiles("coverage", $data);

        $this->assertContains("index.blade.php", $filenames);

        unlink($filename);

    }

    /** @test */
    public function should_call_create_view_show()
    {
        $filename = "resources/views/coverage/show.blade.php";

        $data = $this->getDefaultViewOptions(["noShow" => false]);

        $filenames = $this->fs->createViewFiles("coverage", $data);

        $this->assertContains("show.blade.php", $filenames);

        unlink($filename);
    }

    /** @test */
    public function should_call_create_view_with_extends_show()
    {
        $filename = "resources/views/coverage/show.blade.php";

        $data = $this->getDefaultViewOptions(["noShow" => false, "extends" => "partials.master"]);

        $filenames = $this->fs->createViewFiles("coverage", $data);

        $this->assertContains("show.blade.php", $filenames);

        $this->assertFileContainsString($filename, "@extends");

        unlink($filename);
    }

    /** @test */
    public function should_call_create_view_with_content_show()
    {
        $filename = "resources/views/coverage/show.blade.php";

        $data = $this->getDefaultViewOptions(["noShow" => false, "section" => "content"]);

        $filenames = $this->fs->createViewFiles("coverage", $data);

        $this->assertContains("show.blade.php", $filenames);

        $this->assertFileContainsString($filename, "@section");

        unlink($filename);

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

    /** @test */
    public function should_get_build()
    {
        $result = get_build();

        $this->assertTrue((int) $result > 0);
    }

    /** @test */
    public function should_load_app_config_version_build()
    {
        $result = include "./config/app.php";
        $this->assertArrayHasKey("version", $result);
    }

    /** @test */
    public function should_get_version()
    {
        $result = get_version();

        $parts = explode(".", $result);

        $this->assertTrue(count($parts) === 3);
    }

    /*
     * View Option Factory
     */

    /**
     * @param $overrides
     * @return array
     */
    public function getDefaultViewOptions($overrides)
    {
        return array_merge([
            "noCreate" => true,
            "noEdit" => true,
            "noIndex" => true,
            "noShow" => true,
            "extends" => "",
            "section" => "",
            "overwrite" => true,
        ], $overrides);
    }

}
