<?php

namespace App\Console\Commands;

use App\Consumers\SpaceFlightConsumer;
use App\Models\Article;
use Illuminate\Console\Command;

class ArticlesSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:seed
                            {--chunk-size= : Registry amount that will be fetched per iteration}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database using the oficial API resources.';

    /**
     * The oficial API Consumer
     *
     * @var \App\Consumers\SpaceFlightConsumer
     */
    protected $consumer;

    /**
     * Articles from oficial API that were recorded
     *
     * @var int
     */
    protected $total = 0;

    /**
     * Articles from oficial API that were recorded (initial value)
     *
     * @var int
     */
    protected $initial_total = 0;

    /**
     * Total articles from oficial API
     *
     * @var int
     */
    protected $oficial_total = 0;

    /**
     * Chunk size
     *
     * @var int
     */
    protected $chunk_size = 200;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SpaceFlightConsumer $consumer)
    {
        parent::__construct();
        $this->consumer = $consumer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $articles = [];

        if ($this->option('chunk-size')) {
            $this->chunk_size = (int) $this->option('chunk-size');

            if ($this->chunk_size < 1) {
                $this->error('You must specify an integer greater than zero in the --chunk-size option.');
                return false;
            }

            $this->warn("Using custom chunk size of: $this->chunk_size");
        }

        $this->line('Fetching articles already recorded..');
        $this->fetchRecordedArticles();
        $this->info("$this->total articles found");

        $this->line('Fetching oficial articles count..');
        $this->fetchOficialArticlesCount();

        if ($this->oficial_total <= $this->total) {
            $this->warn('Oficial API doesnt have any new resource.');
            $this->line('No action required.');
            return false;
        }

        $this->info('The sync process will begin now.');
        $this->line('You can exit anytime you want, but the process will not be finished.');

        $started_at = microtime(true);

        do {
            $response = $this->consumer->resource('articles')
                ->skip($this->total)
                ->take($this->chunk_size)
                ->get();

            if (!$response['success']) {
                return false;
            }

            $articles = $response['data'];
            $entries = count($articles);

            if (!$entries) {
                break;
            }

            $this->line("Registering $entries articles..");

            $this->saveArticles($articles);
            $this->increaseTotal($entries);
        } while ($entries);

        $elapsed_time = microtime(true) - $started_at;

        $this->line("Exec: $elapsed_time seconds");

        $this->info(($this->total - $this->initial_total) . ' new articles added.');
    }

    public function saveArticles(array $articles)
    {
        foreach ($articles as &$article) {
            $article['origin'] = Article::ORIGIN_EXTERNAL;
            $article['externalId'] = $article['id'];
        }

        Article::insert($articles);
    }

    public function fetchRecordedArticles()
    {
        $this->total = Article::external()->count();
        $this->initial_total = $this->total;
    }

    public function fetchOficialArticlesCount()
    {
        $response = $this->consumer->resource('articles')->count();

        if (!$response['success']) {
            return false;
        }

        $this->oficial_total = $response['data'];
    }

    public function increaseTotal(int $quantity)
    {
        $this->total += $quantity;
    }
}
