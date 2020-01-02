<?php


namespace App\GraphQL\Resolver;


use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class Movies implements ResolverInterface, AliasedInterface, IResolver
{
    /**
     * @var MovieRepository
     */
    private $movieRepository;

    /**
     * Movies constructor.
     * @param MovieRepository $movieRepository
     */
    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getAliases(): array
    {
        return [
            'list' => 'get_movies',
            'get' => 'get_movie',
        ];
    }

    public function list()
    {
        return $this->movieRepository->findAll();
    }

    public function get($id)
    {
        return $this->movieRepository->find($id);
    }
}