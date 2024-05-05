<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Spatie\Browsershot\Browsershot;

class GeneratePdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-pdf {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pdf = app(Browsershot::class)
            ->setUrl(route('home'))
            ->format('A4')
            ->waitForSelector('.pdf-demo')
            ->pdf();

        Cache::put($this->argument('key'), $pdf);
    }
}
