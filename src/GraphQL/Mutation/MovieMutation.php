<?php


namespace App\GraphQL\Mutation;


use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class MovieMutation implements MutationInterface, AliasedInterface
{
    /**
     * @var MovieRepository
     */
    private $movieRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * MovieMutation constructor.
     * @param MovieRepository $movieRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $entityManager)
    {
        $this->movieRepository = $movieRepository;
        $this->entityManager = $entityManager;
    }


    public function createMovie(string $title, string $resume) : array {
        $movie = new Movie();
        $movie
            ->setTitle($title)
            ->setResume($resume)
        ;
        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        $savedMovie = $this->movieRepository->findOneBy(['title' => $title]);
        return [
            'id' => $savedMovie->getId(),
        ];
    }

    public function deleteMovie(string $id) : array {
        $movie = $this->movieRepository->find($id);
        if (empty($movie)) {
            return ['affectedRows' => 0];
        }
        $this->entityManager->remove($movie);
        $this->entityManager->flush();
        return ['affectedRows' => 1];
    }

    /**
     * @inheritDoc
     */
    public static function getAliases(): array
    {
        return [
            'createMovie' => 'create_movie',
            'deleteMovie' => 'delete_movie',
        ];
    }
}