<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class MakeSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a sitemap.xml file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting making the sitemap...');

        SitemapGenerator::create(env('APP_URL'))->getSitemap()->writeToDisk('liara', 'sitemap.xml');
        
        $this->info('Your sitemap file has been created.');
    }
}
