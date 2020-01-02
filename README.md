# GraphQL Symfony POC
Proof of concept of GraphQL for Symfony 5, created to understand how GraphQL work for a PHP project.

## Project
This GraphQL API is used to store and retrieve movies. They can be associated with many categories.

### URLs
- `/` => Retrieve a list of movies stored in database. Those movies are retrieved using GraphQL request.
- `/graphiql` => User Interface to call GraphQL requests
- `/api/graphql` => URL to call for GraphQL requests

## Notes about GraphQL
### Types
All entities exposed to the API needs to have a GraphQL type. In this projects, these types are defined in `config/graphql/types`.
YAML is used, but it is possible to use real graphql type. Requires further research.

There is different categories of Types, listed [here](https://github.com/overblog/GraphQLBundle/blob/master/docs/definitions/type-system/index.md).

**Warning** : Object != Input Object

There is two "Special types" :
- `Query` type 
- `Mutation` type 

### Query
Defined in `config/graphql/types/Query.yaml`.

This file define which entities can be call """at the first entity""".

For example, for this request : 
```graphql
{
    movies {
        id
        title
        categories {
            id
            title
        }
    }
}
```
if `movies` were not in `Query`, this request will not work. 

All entities defined in Query needs to be connected with a `Resolver`. Those are defined in `src/GraphQL/Resolver`.

This looks like to all read-only endpoints in REST APIs.

### Mutations
Defined in `config/graphql/types/Query.yaml`.

This file will contains all function used to write or update data. All of these functions are linked to a Mutation file in `src/GraphQL/Mutation`.

Here is a example of mutation call
```graphql
mutation {
  CreateMovie(input: {
    title: "Deadpool 3"
    resume: "Wait it does not exists"
  }) {
    id
    title
  }
}

# OR, with external $input variable 

mutation CreateMovie($input: CreateMovieInput!) {
  CreateMovie(input: $input) {
    id
    title
  }
}
```

## Problems encountered
### Change GraphQL API Endpoint
1. Go to config/routes/graphql.yaml
2. Replace content with the following: 
```yaml
overblog_graphql_endpoint:
    resource: "@OverblogGraphQLBundle/Resources/config/routing/single.yaml"
    prefix: /api/graphql
```

