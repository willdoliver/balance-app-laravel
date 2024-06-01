# Balance App

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)

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

Added `/api` as prefix endpoints

-   **Reset state before starting tests** <br>
![Generic badge](https://img.shields.io/badge/POST-f5e942.svg)<br>
Endpoint: `/api/reset`<br>
Response Code: `200 OK`<br>
Response Body: `OK`
<hr>

-   **Get balance for non-existing account**<br>
![Generic badge](https://img.shields.io/badge/GET-1dab45.svg)<br>
Endpoint: `/api/balance?account_id=1234`<br>
Response Code: `404 Not Found`<br>
Response Body: `0`
<hr>

-   **Create account with initial balance**<br>
    ![Generic badge](https://img.shields.io/badge/POST-f5e942.svg)<br>
    Endpoint: `/api/event`<br>
    Body:
    `javascript
    {
        "type":"deposit",
        "destination":"100",
        "amount":10
    }
    `

        Response Code: `201 Created`<br>
        Response Body:
        ```javascript
        {
            "destination": {
                "id":"100",
                "balance":10
            }
        }
        ```

    <hr>

-   **Deposit into existing account**<br>
![Generic badge](https://img.shields.io/badge/POST-f5e942.svg)<br>
Endpoint: `/api/event`<br>
Body:
`javascript
    {
        "type":"deposit",
        "destination":"100",
        "amount":10
    }
    `
Response Code: `201 Created`<br>
Response Body:
`javascript
    {
        "destination": {
            "id":"100",
            "balance":20
        }
    }
    `
<hr>

-   **Get balance for existing account**<br>
[![Generic badge](https://img.shields.io/badge/GET-1dab45.svg)](https://shields.io/)<br>
Endpoint: `/api/balance?account_id=100`<br>
Response Code: `200 OK`<br>
Response Body: `20`
<hr>

-   **Withdraw from non-existing account**<br>
![Generic badge](https://img.shields.io/badge/POST-f5e942.svg)<br>
Endpoint: `/api/event`<br>
Body:
`javascript
    {
        "type":"withdraw",
        "origin":"200",
        "amount":10
    }
    `
Response Code: `404 Not Found`<br>
Response Body: `0`
<hr>

-   **Withdraw from existing account**<br>
![Generic badge](https://img.shields.io/badge/POST-f5e942.svg)<br>
Endpoint: `/api/event`<br>
`javascript
    {
        "type":"withdraw",
        "origin":"100",
        "amount":5
    }
    `
Response Code: `201 Created`<br>
Response Body:
`javascript
    {
        "origin": {
            "id":"100",
            "balance":15
        }
    }
    `
<hr>

-   **Transfer from existing account**<br>
![Generic badge](https://img.shields.io/badge/POST-f5e942.svg)<br>
Endpoint: `/api/event`<br>
Body:
`javascript
    {
        "type":"transfer",
        "origin":"100",
        "amount":15,
        "destination":"300"
    }
    `
Response Code: `201 Created`<br>
Response Body:
`javascript
    {
        "origin":{
            "id":"100",
            "balance":0
        },
        "destination":{
            "id":"300",
            "balance":15
        }
    }
    `
<hr>

-   **Transfer from non-existing account**<br>
    ![Generic badge](https://img.shields.io/badge/POST-f5e942.svg)<br>
    Endpoint: `/api/event`<br>
    Body:
    ```javascript
    {
        "type":"transfer",
        "origin":"200",
        "amount":15,
        "destination":"300"
    }
    ```
    Response Code: `404 Not Found`<br>
    Response Body: `0`

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
