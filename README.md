## Requirements
> Composer 

> php 8+

> mySQL 5.7+


## To Run Locally

> clone from: https://github.com/thearmandov/teaching-api-2024

> cd teaching-api-2024

> in cli: cp .env.example .env 

> add your mySQL credentials (after creating a local database)

> composer install

> php artisan migrate

> php artisan serve


### End Points

GET /posts -- lists all posts

POST /posts -- creates a new post.
    payload: { 
        title: <string>
        body: <string>
        tags: [array]
     }

GET /posts/{post_id} -- gets specific post by id

GET /tags -- lists all tags

POST /posts/{post_id}/setComment -- add comment to existing post.