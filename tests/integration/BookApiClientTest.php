<?php


namespace App\Tests\integration;


use App\Tests\DbTestCase;

class BookApiClientTest extends DbTestCase
{
    /** @test */
    public function the_book_api_client_returns_the_correct_data()
    {
        $bookApiClient = self::$kernel->getContainer()->get('book-api-client');

        $response = $bookApiClient->fetchBookProfile('', '', '');
        $bookProfile = json_decode($response['content']);
        $this->assertSame('', $bookProfile->title);
        $this->assertSame('', $bookProfile->author);
        $this->assertSame('', $bookProfile->pub_date);
    }
}