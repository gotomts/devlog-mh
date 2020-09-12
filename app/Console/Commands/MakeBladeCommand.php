<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeBladeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:blade {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new blade file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // スタブファイルの内容を読み込む
        $stub = \File::get(app_path() . '/Console/Commands/stubs/blade.stub');

        $name = $this->argument('name');

        $array = explode('/', $name);

        $viewPath = resource_path() . '/views/';

        $count = count($array);

        $directory = [];

        if (0 < count($array)) {
            for ($i=0; $i < $count - 1; $i++) {
                array_push($directory, $array[$i]);
            }
            $directory = implode('/', $directory);
            \Storage::disk('views')->makeDirectory($directory);
        }

        // bladeファイルのパスを作成
        $blade = $viewPath . $this->argument('name') . '.blade.php';

        // bladeファイルを作成
        \File::put($blade, $stub);
    }
}
