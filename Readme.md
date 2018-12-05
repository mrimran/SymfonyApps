# Commands
## Taking local dev server up
```
php -S 127.0.0.1:8000 -t public
```

## Display routes
```
php bin/console debug:router
```

## Entity and Migrations
```
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Sample requests
### /blog/add
#### Request
```
{
	"title": "A new blog post!",
	"published": "2018-12-05 12:00:00",
	"content": "Just a testing blog...",
	"author": "Imran",
	"slug": "a-new-blog-post"
}
```

#### Response
```
{
    "id": 1,
    "title": "A new blog post!",
    "slug": "a-new-blog-post",
    "published": "2018-12-05T12:00:00+05:00",
    "content": "Just a testing blog...",
    "author": "Imran"
}
```