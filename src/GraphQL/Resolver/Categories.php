<?php


namespace App\GraphQL\Resolver;


use App\Repository\CategoryRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class Categories implements ResolverInterface, AliasedInterface, IResolver
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * Categories constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @inheritDoc
     */
    public static function getAliases(): array
    {
        return [
            "list" => "get_categories",
            "get" => "get_category",
        ];
    }

    public function list()
    {
        return $this->categoryRepository->findAll();
    }

    public function get($id)
    {
        return $this->categoryRepository->find($id);
    }
}