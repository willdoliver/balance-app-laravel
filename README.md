# Balance App Laravel

Application to manage account transactions built in Laravel

## Getting Started

Instructions on how to get a copy of the project up and running on your local machine.

### Prerequisites

To run this, need to get installed PHP and Composer or Docker to use the Dockerfile

### Installing

-   **With Docker** : <br>
    `docker build -t laravel-balance-app .`<br>
    Redirect Docker port (80) to local machine port (8000)<br>
    `docker run -p 8080:80 laravel-balance-app`
-   **Without Docker** : <br>
    `php artisan serve`<br>

## Usage

Recommended Postman to call the APIs, but also can be called by curl terminal or other app

Endpoints details later

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
