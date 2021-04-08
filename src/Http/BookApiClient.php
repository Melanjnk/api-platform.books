<?php


namespace App\Http;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class BookApiClient
{
    private const URL = 'https://www.googleapis.com/books/v1/volumes?q=title=mistborn';
//    private const URL = 'https://book.api.com/book/v2/get-profile';
    private const X_RAPID_API_HOST = 'book.api.com';

    public function __construct(private HttpClientInterface $httpClient, private $rapidApiKey)
    {
    }

    public function fetchBookProfile(array|string|null $author, string $title, string|null $pubDate)
    {
        $response = $this->httpClient->request('GET', self::URL, [
            'query' => [
                'author' => $author,
                'title' => $title,
                'pub_date' => $pubDate,
            ],
            'headers' => [
                'x-rapidapi-host' => self::X_RAPID_API_HOST,
                'x-rapidapi-key' => $this->rapidApiKey
            ],
        ]);

        return [
            'statusCode' => 200,
            'content' => json_encode([
                'author' => '',
                'title' => '',
                'pub_date' => '',
            ])
        ];
    }
}