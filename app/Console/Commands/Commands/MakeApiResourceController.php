<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeApiResourceController extends Command
{
    protected $signature = 'make:api-resource {name} {modelClass?} {--path=app/Http/Controllers}';
    protected $description = 'Make Api resource controller file';

    public function handle()
    {
        // Get the arguments and options
        $name = $this->argument('name');
        $modelClass = $this->argument('modelClass');
        $path = $this->option('path') == 'app/Http/Controllers'
            ? $this->option('path')
            : 'app/Http/Controllers/' . $this->option('path');

        // Define the base controller path and new controller path
        $baseControllerPath = app_path('Http/Controllers/Command/Api/BaseController.php');
        $newControllerPath = base_path("{$path}/{$name}.php");

        // Check if the base controller exists
        if (!File::exists($baseControllerPath)) {
            $this->error('Base controller not found.');
            return;
        }

        // Copy base controller content and remove its original namespace
        $baseControllerContent = File::get($baseControllerPath);

        // Determine new namespace based on the provided path
        $namespace = Str::replaceFirst(base_path() . '/', '', $path);
        $namespace = str_replace('/', '\\', trim($namespace, '/'));
        $namespace = Str::ucfirst($namespace);

        // $baseControllerContent = str_replace("<?php\n\nnamespace App\Http\Controllers\Command\Api;", "<?php\n\nnamespace " . $namespace, $baseControllerContent);
        // dd($baseControllerContent);

        // Generate model and resource class names
        $modelClassName = $modelClass ? class_basename($modelClass) : str_replace('Controller', '', $name);
        $resourceClassName = $modelClassName . 'Resource';

        // Add `use` statements and namespace at the top
        $useStatements = "namespace $namespace;\n\nuse App\Models\\{$modelClassName};\nuse App\Http\Resources\\{$resourceClassName};";

        // Replace placeholders with dynamic values
        $newControllerContent = str_replace(
            [
                "<?php\n\nnamespace App\Http\Controllers\Command\Api;\n", // Insert namespace and `use` statements after the opening PHP tag
                'class BaseController',
                '$this->modelClass = Model::class;',
                '$this->resourceClass = Resource::class;'
            ],
            [
                "<?php\n\n" . $useStatements, // Insert namespace and `use` statements
                "class $name",
                "\$this->modelClass = {$modelClassName}::class;",
                "\$this->resourceClass = {$resourceClassName}::class;"
            ],
            $baseControllerContent
        );

        // dd($newControllerContent);

        // Ensure directory exists, then save
        if (!File::isDirectory(dirname($newControllerPath))) {
            File::makeDirectory(dirname($newControllerPath), 0755, true);
        }
        File::put($newControllerPath, $newControllerContent);

        // Output message for resource creation
        $this->info("Creating the resource file: {$resourceClassName}");

        // Create the resource file
        Artisan::call("make:resource", ['name' => $resourceClassName]);

        // Output controller's creation message
        $this->info("Controller {$name} created successfully at {$path}");
    }
}
