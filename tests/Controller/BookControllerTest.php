<?php


namespace App\Controller\Tests;


use App\Tests\DatabasePrimer;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Book;

class BookControllerTest extends KernelTestCase
{
    protected ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        DatabasePrimer::prime($kernel);

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

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