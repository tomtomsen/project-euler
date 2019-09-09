<?php

declare(strict_types=1);

namespace tomtomsen\ProjectEuler\ProblemImporter;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

final class ProjectEulerSiteProblemImporter implements ProblemImporter
{
    /** @var ClientInterface */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function import(int $number) : \tomtomsen\ProjectEuler\Problem
    {
        $psr17Factory = new Psr17Factory();
        $request = $psr17Factory->createRequest('GET', $this->url($number));

        try {
            $response = $this->client->sendRequest($request);

            if (200 !== $response->getStatusCode()) {
                throw new Exception\ProblemNotFound($number);
            }

            $crawler = new Crawler((string) $response->getBody());
            $title = $crawler->filter('body h2')->first()->text();
            $description = $crawler->filter('body .problem_content')->first()->text();
        } catch (ClientExceptionInterface $e) {
            throw $e;
        }

        return new Problem($number, $title, $description);
    }

    private function url(int $problem) : string
    {
        /** @phan-suppress-next-line PhanParamSuspiciousOrder */
        return \strtr(
            'https://projecteuler.net/problem={problem}',
            [
                '{problem}' => $problem,
            ]
        );
    }
}
