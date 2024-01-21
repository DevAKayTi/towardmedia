<?php

namespace App\Console\Commands;

use App\Models\Type;
use Illuminate\Console\Command;

class AddDefaultArticleTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add default article types for this project.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Type::create([
            'name' => 'News',
        ]);
        Type::create([
            'name' => 'Article',
        ]);
        Type::create([
            'name' => 'Podcast',
        ]);
        return 'Successfully created the types.';
    }
}
