<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDomainCommand extends Command
{
    protected $signature = 'make:domain {name}';
    protected $description = 'Create a new DDD Domain structure';

    public function handle()
    {
        $name = $this->argument('name');
        $basePath = app_path("Domains/{$name}");

        $folders = [
            'Models',
            'Repositories',
            'Services',
            'Http/Controllers/Api',
            'Http/Requests',
            'Resources',
            'Database/Migrations',
        ];

        foreach ($folders as $folder) {
            $path = "{$basePath}/{$folder}";
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
                $this->info("Created: {$path}");
            }
        }

        $this->createModel($basePath, $name);
        $this->createRepositoryInterface($basePath, $name);
        $this->createRepositoryImplementation($basePath, $name);
        $this->createService($basePath, $name);
        $this->createController($basePath, $name);
        $this->createMigration($basePath, $name);
        $this->createRequest($basePath, $name);
        $this->createResource($basePath, $name);
        $this->registerRepositoryInProvider($name);

        $this->info("✅ Domain [{$name}] created successfully.");
    }

    protected function createModel($basePath, $name)
    {
        $modelPath = "{$basePath}/Models/{$name}.php";
        if (!file_exists($modelPath)) {
            file_put_contents($modelPath, "<?php

namespace App\\Domains\\{$name}\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class {$name} extends Model
{
    protected \$fillable = [];
}
");
            $this->info("Created: Model {$name}");
        }
    }

    protected function createRepositoryInterface($basePath, $name)
    {
        $path = "{$basePath}/Repositories/{$name}RepositoryInterface.php";
        if (!file_exists($path)) {
            file_put_contents($path, "<?php

namespace App\\Domains\\{$name}\\Repositories;

interface {$name}RepositoryInterface
{
    // Define your methods here
}
");
            $this->info("Created: {$name}RepositoryInterface");
        }
    }

    protected function createRepositoryImplementation($basePath, $name)
    {
        $path = "{$basePath}/Repositories/Eloquent{$name}Repository.php";
        if (!file_exists($path)) {
            file_put_contents($path, "<?php

namespace App\\Domains\\{$name}\\Repositories;

use App\\Domains\\{$name}\\Models\\{$name};

class Eloquent{$name}Repository implements {$name}RepositoryInterface
{
    // Implement repository methods here
}
");
            $this->info("Created: Eloquent{$name}Repository");
        }
    }

    protected function createService($basePath, $name)
    {
        $path = "{$basePath}/Services/{$name}Service.php";
        if (!file_exists($path)) {
            file_put_contents($path, "<?php

namespace App\\Domains\\{$name}\\Services;

use App\\Domains\\{$name}\\Repositories\\{$name}RepositoryInterface;

class {$name}Service
{
    protected \$repository;

    public function __construct({$name}RepositoryInterface \$repository)
    {
        \$this->repository = \$repository;
    }

    // Add your business logic here
}
");
            $this->info("Created: {$name}Service");
        }
    }

    protected function createController($basePath, $name)
    {
        $path = "{$basePath}/Http/Controllers/Api/{$name}Controller.php";
        if (!file_exists($path)) {
            file_put_contents($path, "<?php

namespace App\\Domains\\{$name}\\Http\\Controllers\\Api;

use App\\Http\\Controllers\\Controller;
use Illuminate\\Http\\Request;

class {$name}Controller extends Controller
{
    public function index()
    {
        //
    }
}
");
            $this->info("Created: {$name}Controller");
        }
    }

    protected function createMigration($basePath, $name)
    {
        $timestamp = now()->format('Y_m_d_His');
        $table = strtolower(Str::plural($name));
        $path = "{$basePath}/Database/Migrations/{$timestamp}_create_{$table}_table.php";

        if (!file_exists($path)) {
            file_put_contents($path, "<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{$table}', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$table}');
    }
};
");
            $this->info("Created: Migration for {$table}");
        }
    }

    protected function createRequest($basePath, $name)
    {
        $path = "{$basePath}/Http/Requests/Store{$name}Request.php";
        if (!file_exists($path)) {
            file_put_contents($path, "<?php

namespace App\\Domains\\{$name}\\Http\\Requests;

use Illuminate\\Foundation\\Http\\FormRequest;

class Store{$name}Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Add validation rules
        ];
    }
}
");
            $this->info("Created: Store{$name}Request");
        }
    }

    protected function createResource($basePath, $name)
    {
        $path = "{$basePath}/Resources/{$name}Resource.php";
        if (!file_exists($path)) {
            file_put_contents($path, "<?php

namespace App\\Domains\\{$name}\\Resources;

use Illuminate\\Http\\Resources\\Json\\JsonResource;

class {$name}Resource extends JsonResource
{
    public function toArray(\$request): array
    {
        return [
            'id' => \$this->id,
            // Add other fields here
        ];
    }
}
");
            $this->info("Created: {$name}Resource");
        }
    }

    protected function registerRepositoryInProvider($name)
    {
        $providerPath = app_path('Providers/DomainServiceProvider.php');

        if (!file_exists($providerPath)) {
            $this->warn("DomainServiceProvider.php not found. Skipping binding.");
            return;
        }

        $interface = "App\\Domains\\{$name}\\Repositories\\{$name}RepositoryInterface::class";
        $implementation = "App\\Domains\\{$name}\\Repositories\\Eloquent{$name}Repository::class";

        $bindCode = "\$this->app->bind({$interface}, {$implementation});";

        $providerContent = file_get_contents($providerPath);

        if (str_contains($providerContent, $bindCode)) {
            $this->info("Repository already registered in DomainServiceProvider.");
            return;
        }

        // Inject the bind code inside register()
        $providerContent = preg_replace(
            '/(public function register\(\): void\s*{)/',
            "\$1\n        {$bindCode}",
            $providerContent
        );

        file_put_contents($providerPath, $providerContent);
        $this->info("✅ Registered repository in DomainServiceProvider.");
    }
}
