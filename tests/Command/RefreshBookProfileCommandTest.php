<?php


namespace App\Tests;


use App\Entity\Book;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class RefreshBookProfileCommandTest extends DbTestCase
{
    /** @test */
    public function the_refresh_book_profile_command_behaves_correctly()
    {
        $app = new Application(self::$kernel);

        $command = $app->find('app:refresh-book-profile');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
           'author' => 'Brandon Sanderson',
           'title' => 'Mistborn: The Final Empire',
           'pub_date' => '2006-06-17'
        ]);

        $bookRepo = $this->entityManager->getRepository(Book::class);
        /** @var Book $book */
        $book = $bookRepo->findOneBy(['title'=>'Mistborn: The Final Empire']);

        $this->assertEquals('Brandon Sanderson', $book->getAuthor());
        $this->assertEquals('2006', $book->getPublicationDate()->format('Y'));
        $this->assertEquals('Mistborn: The Final Empire', $book->getTitle());
    }
}