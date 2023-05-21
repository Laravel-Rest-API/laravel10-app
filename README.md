
# Laravel 10 - Response Code & Message Config

Make API with laravel 10 need to make response with json format. This package will help you to make response with json format.





[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

## Configuration

### 1. Make List Response Code & Message
make file `app/Responses/UserResponse.php` and add the following code

```php
class UserResponse
{
    public const SUCCESS = [
        'code' => 200,
        'message' => 'User Get Successfully',
    ];

    public const CREATED = [
        'code' => 201,
        'message' => 'User Created Successfully',
    ];

    public const UPDATED = [
        'code' => 200,
        'message' => 'User Updated Successfully',
    ];

    public const DELETED = [
        'code' => 200,
        'message' => 'User Deleted Successfully',
    ];
}
```

### 2. Edit UserCollection

edit file `app/Resources/UserCollection.php` and add the following code

```php
    use PaginationTrait;

    public function __construct($collection, $response) //new this
    {
        parent::__construct($collection);
        $this->response = $response; //new this
    }
    public function toArray(Request $request): array
    {
        return array_merge($this->response,[  //new this
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                ];
            }),
        ]);
    }
```

### 3. Edit UserResource
edit file `app/Resources/UserResource.php` and add the following code

```php
    public function __construct($resource, $response) //new this
    {
        parent::__construct($resource);
        $this->response = $response; //new this
    }
    public function toArray(Request $request): array
    {
        return array_merge($this->response,[ //new this
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email
            ]
        ]);
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
        $userTransform = (new UserCollection($user,UserResponse::SUCCESS))->response()->setStatusCode(Response::HTTP_OK);
        return $userTransform;
    }
```
access url in `localhost:8000/api/v1/users`
### Result
```json
{
    "code": 200,
    "message": "User Get Successfully",
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
        return (new UserResource($user,UserResponse::SUCCESS))->response()->setStatusCode(Response::HTTP_OK);
    }
```
access url `localhost:8000/api/v1/users/1`
### Result
```json
{
    "code": 200,
    "message": "User Get Successfully",
    "data": {
        "id": 1,
        "name": "Joannie Ziemann",
        "email": "winston49@example.net"
    }
}
```
## License

[MIT](https://choosealicense.com/licenses/mit/)

