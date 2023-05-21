
# Laravel 10 - Transform Data

Make API with laravel 10 need to make response with json format. This package will help you to make response with json format.





[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

## Requirements

To make this response, you can need to make file:
1. UserCollection

note: you can make this file with command `php artisan make:resource UserCollection`
2. UserResource

note: you can make this file with command `php artisan make:resource UserResource`
3. PaginationTrait

note: you can make this file manually in `app/Traits/PaginationTrait`

## Configuration

### 1. UserCollection

edit file `app/Resources/UserCollection.php` and add the following code

```php
use PaginationTrait;

public function __construct($resource, $message = 'Successfully')
    {
        parent::__construct($resource);
        $this->message = $message;
    }
    public function toArray(Request $request): array
    {
        return [
            'message' => $this->message,
            'data' => $this->resource->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                ];
            }),
        ];
    }
```
### 2. PaginationTrait
make file `app/Traits/PaginationTrait.php` and add the following code

```php
<?php

namespace App\Traits;

trait PaginationTrait
{
    public function paginationInformation($request, $paginated, $default)
    {
        return [
            'meta' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'links' => [
                    'previous' => $this->previousPageUrl(),
                    'next' => $this->nextPageUrl(),
                ],
            ]
        ];
    }
}

```
this function will call in `UserCollection` file when you make pagination. You can focus in `use PaginationTrait` in UserCollection file.

### 3. UserResource
edit file `app/Resources/UserResource.php` and add the following code

```php
public function __construct($resource,$message='Successfully')
    {
        parent::__construct($resource);
        $this->message = $message;
    }
    public function toArray(Request $request): array
    {
        return [
            'message'=>$this->message,
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email
            ]
        ];
    }
```

## Usage
For know how use resource & collection and show displayed data, you can follow this step:
### 1. UserCollection
edit file `app/Http/Controllers/UserController.php` and add the following code

```php
public function index()
    {
        $user = User::orderByDesc('id')->paginate(10);
        $userTransform = (new UserCollection($user,'Show List User'))->response()->setStatusCode(Response::HTTP_OK);
        return $userTransform;
    }
```
access url in `localhost:8000/api/v1/users`
### Result
```json
{
    "message": "Show List User",
    "data": [
        {
            "id": 100,
            "name": "Dr. Maeve Hartmann",
            "email": "elisa72@example.net"
        },
        {
            "id": 99,
            "name": "Mr. Vincent Gerlach Sr.",
            "email": "sawayn.gaston@example.com"
        },
        {
            "id": 98,
            "name": "Hiram D'Amore PhD",
            "email": "damion.watsica@example.com"
        },
        {
            "id": 97,
            "name": "Frederik Cole",
            "email": "mac.green@example.org"
        },
        {
            "id": 96,
            "name": "Derrick Hauck",
            "email": "veum.samara@example.com"
        },
        {
            "id": 95,
            "name": "Ena Cartwright II",
            "email": "alysha.bartell@example.org"
        },
        {
            "id": 94,
            "name": "Alberta Turcotte",
            "email": "howard35@example.net"
        },
        {
            "id": 93,
            "name": "Mackenzie Kuhic",
            "email": "rosie.koss@example.org"
        },
        {
            "id": 92,
            "name": "Trey Vandervort",
            "email": "danial62@example.org"
        },
        {
            "id": 91,
            "name": "Dean Lakin",
            "email": "sdubuque@example.org"
        }
    ],
    "meta": {
        "total": 100,
        "count": 10,
        "per_page": 10,
        "current_page": 1,
        "total_pages": 10,
        "links": {
            "previous": null,
            "next": "http://localhost:8000/api/v1/users?page=2"
        }
    }
}
```
### 2. UserResource
edit file `app/Http/Controllers/UserController.php` and add the following code

```php
public function show(User $user)
    {
        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_OK);
    }
```
access url `localhost:8000/api/v1/users/1`
### Result
```json
{
    "message": "Details User Successfully",
    "data": {
        "id": 1,
        "name": "Joannie Ziemann",
        "email": "winston49@example.net"
    }
}
```
## License

[MIT](https://choosealicense.com/licenses/mit/)

