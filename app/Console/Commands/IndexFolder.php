<?php

namespace App\Console\Commands;

use App\Services\DocsSearchApi;
use Illuminate\Console\Command;

class IndexFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Search:indexfolder {folder} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a record for all topics in algoria';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DocsSearchApi $search)
    {
        parent::__construct();
        $this->search = $search;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $folder = $this->argument('folder');
        $domain = $this->argument('domain');


        // $this->search->clearObjects();

        $this->search->indexfolder($year, $version, $product, $lang);

        echo "Index updated.";

    }
}
