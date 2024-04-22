<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically Generate an XML Sitemap';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        Log::info('sitemap:generate start');
        $sitemap = Sitemap::create();
        $sitemap->add(
            Url::create("/")
                ->setPriority(1)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );
        $sitemap->add(
            Url::create("/store")
                ->setPriority(0.5)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );
        Category::query()->where(['general_category_id' => 126,'level' => '2'])->get()->each(function (Category $cat) use ($sitemap) {
            $sitemap->add(
                Url::create($cat->url)
                    ->setPriority(0.5)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        });
        Product::query()->get()->each(function (Product $product) use ($sitemap) {
            $sitemap->add(
                Url::create($product->url)
                    ->setPriority(0.5)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        });
        Content::query()->page()->get()->each(function (Content $page) use ($sitemap) {
            $sitemap->add(
                Url::create($page->url)
                    ->setPriority(0.5)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        });
        $sitemap->add(
            Url::create("/blog")
                ->setPriority(0.5)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );
        Content::query()->blog()->get()->each(function (Content $blog) use ($sitemap) {
            $sitemap->add(
                Url::create($blog->url)
                    ->setPriority(0.5)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        });
        $sitemap->writeToFile(public_path('sitemap.xml'));
        Log::info('sitemap:generate end');
    }
}
