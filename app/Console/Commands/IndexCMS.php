<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DocsCmsApi;
use App\Services\DocsSearchApi;


class IndexCMS extends Command
{
    public $cms;
    public $search;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Search:indexCms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DocsCmsApi $cms, DocsSearchApi $search)
    {
        $this->search = $search;
        $this->cms = $cms;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $landingPages = $this->cms->get_custom_post_by_type('level2')->get('results');
        foreach($landingPages as $page){
            $title = $page->title->rendered;
            $content =  strip_tags($page->acf->modular_template_builder[0]->text_area);
            $url = "/".$page->slug;
            $this->search->addRecord($title, $content, $url);
        }
        

        // dd($landingPages->get('results')[3]->title);
        // dd(gettype($landingPages->get('results')[0]->acf));
        // dd($landingPages->get('results'));
    }
}
