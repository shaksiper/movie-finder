<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class ScraperController extends Controller
{
    //
    private function pager($count): Crawler
    {
        $page = $count*100 +1;

        $source = Http::get('https://www.imdb.com/search/title/?groups=top_1000&count=100&start='.$page);
        $body = $source->body();

        $body = preg_replace('/<script(.*?)<\/script>/s', '', $body);
        $body = preg_replace('/[ ]{2, }/', ' ', $body);

        $crawler = new Crawler($body);

        /* dd($crawler); */
        return $crawler;
    }

    public function scraper()
    {
        $movies = [];
        $personals = function ($data, $director = true) {
            $separator = array_search('|', $data, true);
            if ($separator !== false) {
                if ($director) {
                    return array_slice($data, 0, $separator, true);
                } else {
                    return array_slice($data, $separator + 1, null, true);
                }
            }
        };

        for ($i=0; $i<10; $i++) {
            $crawler = $this->pager($i);
            $movies = array_merge($movies, $crawler->filter('.lister-item')
            ->each(function (Crawler $node) use ($personals) {
                $itemDiv = $node->filter('div.lister-item');
                $itemImageDiv = $itemDiv->filter('div.lister-item-image');
                $itemHeader = $itemDiv->filter('h3.lister-item-header');
                $personal = $itemDiv->filter('div.lister-item-content > p')->eq(2)->children()->each(function ($node) {
                    return $node->text();
                });

                return [
                    'imdb_id' => $itemDiv->filter('div.ribbonize')->attr('data-tconst'),
                    'name' => $itemHeader->filter('h3 > a')->text(),
                    'image' => Str::beforeLast($itemDiv->filter('div.lister-item-image > a > img')
                        ->attr('loadlate'), '@').'@._V1_FMjpg_UY720_.jpg',
                    'rating' => $itemDiv->filter('div.inline-block')->attr('data-value'),
                    'metascore' => $itemDiv->filter('span.metascore')->count()>0 ?
                        $itemDiv->filter('span.metascore')->text() : null,
                    'synopsis' => $itemDiv->filter('p.text-muted')->eq(1)->text(),
                    'genre' => $itemDiv->filter('span.genre')->text(),
                    'lenght' => Str::before($itemDiv->filter('span.runtime')->text(), ' min'),
                    'release_year' => Str::match('/\(([^)]*)\)[^(]*$/', $itemDiv->filter('span.lister-item-year')->text()),

                    'directors' => implode(',', $personals($personal, true)),
                    'stars' => implode(',', $personals($personal, false)),
                ];
            }));
            dump($movies);
            /* dd($movies); */
        }
        Movie::insert($movies);
    }
}
