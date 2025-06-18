# PHP Payment Traffic Split

The Payment Traffic Split System is a simple PHP application written in pure PHP (without any PHP framework), offering the ability to route transactions between several payment gateways and change the traffic split algorithm easily.

The application focuses on remaining easy to maintain and test, using the fundamentals of DDD (Domain-Driven Design), TDD (Test-Driven Development), design patterns, and principles of good programming and clean code.

The traffic distribution (split) algorithm is retrieved using a simple Dependency Injection Container, allowing implementations to be easily swapped. Currently, 2 algorithms have been implemented:
* **Weighted Strategy** - Algorithm that distributes traffic according to weights assigned to specific gateways.
  <img width="1681" alt="weighted_equal" src="https://github.com/user-attachments/assets/40f11763-ef20-41bc-bc85-258d7e83d253" />

* **Least Loaded Strategy** - Algorithm that distributes traffic according to the current load of the gateways, so that traffic is routed to gateways that currently do not have a high load.
  <img width="1681" alt="least_loaded" src="https://github.com/user-attachments/assets/15938743-ec6c-4118-96c5-16cb58a0a0e8" />

## Architecture and Project Structure

The application has a simple architecture based on DDD fundamentals. I didn't want to “over-develop" the architecture, so I tried to keep everything as simple as possible. The outline of the application architecture is presented in the following diagram:

![architecture_diagram](https://github.com/user-attachments/assets/b164acf6-a6d4-4448-bd7f-178a50cb0c4f)

The application has a rather typical structure:
* `/public` folder is the entry point for the application via web (HTTP).
* `/src` folder contains all the logic, including the domain, application, infrastructure, and UI layers.
* `/tests` folder contains unit and integration tests.

## Project Setup
Prerequisites:
* PHP and Composer are installed.

Running the Application:
1. Copy project files (e.g. `git clone`) and navigate to the main (root) project directory.
2. Run `composer install` to install dependencies and generate autoload files.
3. Use a web server like Apache or Nginx to serve the application, the main entry point is `/public/index.php` file. For local usage PHP built-in server might be enough. Navigate to `public` folder and run:
```
   php -S localhost:8000
```
4. Navigate to the application URL (e.g. `localhost:8000`).

## Tests

To run tests:
* Navigate to root project directory.
* Run in command line: `./vendor/bin/phpunit tests/unit` to execute unit tests.
* Run in command line: `./vendor/bin/phpunit tests/integration` to execute integration tests.
* Or run in command line: `./vendor/bin/phpunit tests` to execute all tests.




