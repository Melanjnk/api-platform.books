<?php


namespace App\Controller\Tests;


use App\Tests\DbTestCase;
use DateTime;
use App\Entity\Book;

class BookControllerTest extends DbTestCase
{
    /** @test */
    public function canBookBeCreated()
    {
        $book = new Book();
        $book->setAuthor('Brandon Sanderson');
        $book->setTitle('Mistborn');
        $book->setPublicationDate(new DateTime('2006-06-17'));
        $this->entityManager->persist($book);

        $this->entityManager->flush();

        $bookRepository = $this->entityManager->getRepository(Book::class);
        /** @var Book $bookRecord */
        $bookRecord = $bookRepository->findOneBy(['title' => 'Mistborn']);

        $this->assertEquals('Brandon Sanderson', $bookRecord->getAuthor());
        $this->assertEquals('2006', $bookRecord->getPublicationDate()->format('Y'));
        $this->assertEquals('Mistborn', $bookRecord->getTitle());
    }
}