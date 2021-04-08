<?php

namespace App\Command;

use App\Entity\Book;
use App\Http\BookApiClient;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class RefreshBookProfileCommand extends Command
{

    protected static $defaultName = 'app:refresh-book-profile';
    protected static $defaultDescription = 'Update book author and title from some Api';

    public function __construct(protected EntityManagerInterface $entityManager, private BookApiClient $bookApiClient, private SerializerInterface $serializer)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('author', InputArgument::REQUIRED, 'Book author')
            ->addArgument('title', InputArgument::REQUIRED, 'Book title')
            ->addArgument('pub_date', InputArgument::REQUIRED, 'Book publication date');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $author = $input->getArgument('author');
        $title = $input->getArgument('title');
        $pubDate = $input->getArgument('pub_date');

        if ($author) {
            $io->note(sprintf('You passed an argument: %s', $author));
        }

        if ($title) {
            $io->note(sprintf('You passed an argument: %s', $title));
        }

        if ($pubDate) {
            $io->note(sprintf('You passed an argument: %s', $pubDate));
        }

        if ((gettype($author) === 'string' || gettype($author) === 'array')
            && gettype($title) === 'string') {
            $bookProfile = $this->bookApiClient->fetchBookProfile($author, $title, $pubDate);
        }

        if ($bookProfile['statusCode'] !== Response::HTTP_OK) {
            $book = json_decode($bookProfile['content'], true);
        }

//        $book = $this->serializer->deserialize($bookProfile['content'], Book::class, 'json');
        /*        $book = new Book();
                $book->setAuthor($author);
                $book->setTitle($title);
                $book->setPublicationDate(new DateTime($pubDate));*/

        $this->entityManager->persist($book);

        $this->entityManager->flush();


        $io->success('Book refresh-book-profile Command executed');
        //You have a new command! Now make it your own! Pass --help to see your options.

        return Command::SUCCESS;
    }
}
