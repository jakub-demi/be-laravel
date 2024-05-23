<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakePhpUnitTest extends Command
{
    private Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:phpunit {name} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new PHPUnit test class with correct TestCase import';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (!$name) {
            $this->error("Class name for PHPUnit test cannot be empty!");
            return 1;
        }

        if (!strpos(strtolower($name), "test")) {
            $name .= "Test";
        }

        $pathOption = $this->option('path') ?? '';

        $path = base_path("tests/Unit") . '/' . str_replace(["\\", "/"], DIRECTORY_SEPARATOR, trim($pathOption, "/"));
        $filePath = "{$path}/{$name}.php";

        $this->makeDirectory($filePath);
        $this->files->put($filePath, $this->getStub($name));

        $this->info("PHPUnit Test class '{$name}' was created successfully in '{$path}'.");
    }

    protected function makeDirectory($path): void
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true, true);
        }
    }

    protected function getStub($name): string
    {
        $namespace = 'Tests\\Unit';
        if ($this->option('path')) {
            $namespace .= '\\' . str_replace('/', '\\', trim($this->option('path'), '/'));
        }

        return <<<EOT
<?php

namespace {$namespace};

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class {$name} extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        \$this->assertTrue(true);
    }
}

EOT;
    }
}
