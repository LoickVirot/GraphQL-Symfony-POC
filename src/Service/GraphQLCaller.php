<?php


namespace App\Service;


use GraphQL\Server\RequestError;

class GraphQLCaller
{
    private const URL = 'https://testgraphql.local/api/graphql/';

    private $query;

    public function setQuery(string $query) : GraphQLCaller {
        $this->query = [ "query" => $query];
        return $this;
    }

    public function send() {
        $ch = curl_init(self::URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->query));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        // DEVELOP ONLY
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // END DEVELOP ONLY
        $result = json_decode(curl_exec($ch));

        if (curl_errno($ch)) {
            throw new RequestError(curl_error($ch));
        }

        return $result;
    }

}