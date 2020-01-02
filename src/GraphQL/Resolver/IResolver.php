<?php


namespace App\GraphQL\Resolver;


interface IResolver
{
    public function list();

    public function get($id);
}