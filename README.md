## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### Authentication
TODO: pls summarize how to check "Authentication" bahavior
Users undergo authentication via tokens, with their login credentials being transmitted in JSON format. 
Below is a scenario depicting a user attempting to login.

![image](https://github.com/sumstudent/coding-test-php/assets/61895002/a5c8f96d-5cc5-4ca2-8bca-2cea2deddc14)
Unauthorized Attempt
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/ea936f7a-bdc8-4a3f-b11e-19c4357db21b)


### Article Management

TODO: pls summarize how to check "Article Management" bahavior

### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
