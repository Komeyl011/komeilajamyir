<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeEnum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name} {--path=app/Enum}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an enum';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->option('path') == 'app/Enum'
            ? $this->option('path')
            : 'app/Enum/' . $this->option('path');

        $new_enum_path = "{$path}/{$name}.php";
        $stub = <<<PHP
<?php

namespace App\\Enum;

enum Name: int
{
    case DEFAULT = 1;

    /**
     * Return the corresponding translated label for the case to be shown to the user
     *
     * @return string
     */
    public function label(): string
    {
        return match (\$this) {
            self::DEFAULT => __('Default'),
        };
    }

    /**
     * Return the color for the case to be shown to the user
     *
     * @return string
     */
    public function color(): string
    {
        return match (\$this) {
            self::DEFAULT => 'primary',
        };
    }

    /**
     * Return the colors for the cases to be shown to the user
     *
     * @return array
     */
    public static function colors(): array
    {
        return [
            self::DEFAULT->value => 'primary',
        ];
    }
}
PHP;

        $new_enum_content = str_replace('Name', $name, $stub);

        // Output message for resource creation
        $this->info("Creating the resource file: {$name}");

        File::put($new_enum_path, $new_enum_content);
    }
}
