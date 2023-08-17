<?php

namespace App\Infrastructure;

use App\Domain\Country;
use App\Domain\World;
use App\Domain\WorldRepositoryException;
use App\Domain\WorldRepositoryInterface;
use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class HttpMledozeWorldRepository implements WorldRepositoryInterface
{
    public function __construct(
        protected HttpClientInterface $httpClient
    ) {
    }

    /**
     * @throws WorldRepositoryException
     */
    public function load(): World
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                'https://raw.githubusercontent.com/mledoze/countries/master/countries.json'
            );

            if ($response->getStatusCode() !== 200) {
                throw new Exception('Response code is not 200!');
            }

            $data = $response->toArray();
        } catch (Throwable $throwable) {
            throw new WorldRepositoryException('Can\'t download world from mledoze/countries.json!', 0, $throwable);
        }

        $countries = [];

        foreach ($data as $country) {
            $countries[] = new Country(
                $country['cca3'],
                $country['name']['official'],
                $country['borders'],
            );
        }

        return new World($countries);
    }
}
