<?php

namespace Database\Seeders\ImdbScraper;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class ImdbScraper extends Seeder
{
    private array $movies = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // take pages from 0 to 9 ( 1 - 901 )
        for ($i = 0; $i < 10; $i++) {
            $sourceBody = $this->source($i);
            $crawler = new Crawler($sourceBody);

            $crawler->filter('.lister-item')->each(function (Crawler $node) {
                $itemDiv = $node->filter('div.lister-item');
                $itemHeader = $itemDiv->filter('h3.lister-item-header');

                $personalsText = $itemDiv->filter('div.lister-item-content > p')->eq(2)->children()->each(function ($node) {
                    return $node->text();
                });
                $personals = $this->personals($personalsText);

                $imdbId = $itemDiv->filter('div.ribbonize')->attr('data-tconst');
                $movieName = $itemHeader->filter('h3 > a')->text();

                $parsedMovie = [
                    'imdb_id' => $imdbId,

                    'name' => $movieName,
                    'url' => $imdbId . '-' . Str::slug($movieName),
                    'image' => Str::beforeLast($itemDiv->filter('div.lister-item-image > a > img')
                        ->attr('loadlate'), '@') . '@._V1_FMjpg_UY720_.jpg',

                    'rating' => $itemDiv->filter('div.inline-block')->attr('data-value'),
                    'metascore' => ($itemDiv->filter('span.metascore')->count() > 0)
                        ? $itemDiv->filter('span.metascore')->text()
                        : null,

                    'synopsis' => $itemDiv->filter('p.text-muted')->eq(1)->text(),

                    'genre' => $itemDiv->filter('span.genre')->text(),
                    'lenght' => Str::before($itemDiv->filter('span.runtime')->text(), ' min'),

                    'release_year' => Str::match('/\(([^)]*)\)[^(]*$/', $itemDiv->filter('span.lister-item-year')->text()),

                    'directors' => implode(',', $personals['directors']),
                    'stars' => implode(',', $personals['stars']),
                ];

                $this->movies[] = $parsedMovie;
            });
        }

        Movie::insert($this->movies);
    }

    /**
     * Get related body from targer page on IMDb
     * the remove the script tags because its breaks the crawler
     *
     * @param integer $page
     * @return string
     */
    private function source(int $page)
    {
        $page = $page * 100 + 1;

        $source = Http::get('https://www.imdb.com/search/title/?groups=top_1000&count=100&start=' . $page);
        $body = $source->body();

        $body = preg_replace('/<script(.*?)<\/script>/s', '', $body);
        $body = preg_replace('/[ ]{2, }/', ' ', $body);

        return $body;
    }

    private function personals($data)
    {
        $separator = array_search('|', $data, true);

        if ($separator === false) {
            return;
        }

        return [
            'directors' => array_slice($data, 0, $separator, true),
            'stars' => array_slice($data, $separator + 1, null, true),
        ];
    }
}
