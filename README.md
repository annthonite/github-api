## Package Used
- Laravel Passport
- Predis

Note: 
- Run composer install first. 
- Setup .env file from .env.example.

## PHP Artisan Commands
- artisan key:generate 
- artisan migrate
- artisan passport:install
- artisan passport:keys - (Check for passport key first before running this command.)
- artisan serve 

## Run API
### Login API
- Endpoint: POST /api/login
- Parameters: email, password 

### Register API
- Endpoint: POST /api/register
- Parameters: email, password

### Github Users API
- Endpoint: GET /api/user/github
- Parameters: users
- Note: Github Usernames is comma seperated.