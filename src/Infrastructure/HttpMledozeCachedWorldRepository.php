<?php

namespace App\Infrastructure;

use App\Domain\World;
use App\Domain\WorldRepositoryInterface;
use DateInterval;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpMledozeCachedWorldRepository extends HttpMledozeWorldRepository implements WorldRepositoryInterface
{
    public function __construct(
        protected HttpClientInterface $httpClient,
        private readonly CacheInterface $cache,
    ) {
        parent::__construct($httpClient);
    }

    public function load(): World
    {
        return $this->cache->get('mledoze_country_list_cache', function (ItemInterface $item) {
            $item->expiresAfter(new DateInterval('P30D'));

            return parent::load();
        });
    }
}
