<?php

namespace App\Console\Commands;

use App\Services\DocsSearchApi;
use Illuminate\Console\Command;

class DeleteDocsBy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Search:deleteDocsBy {product?} {version?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a record for all topics /public/documentation_files in algoria';

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
        $product = $this->argument('product');
        $version = $this->argument('version');

        $this->search->deleteDocsBy($product, $version);

        echo "Deleting topics for ".$product.":".$version."\n";

    }
}
