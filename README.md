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
Users undergo authentication via tokens, with their login credentials being transmitted in JSON format. 
Below is a scenario depicting a user attempting to login.

![image](https://github.com/sumstudent/coding-test-php/assets/61895002/a5c8f96d-5cc5-4ca2-8bca-2cea2deddc14)
Unauthorized Attempt
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/ea936f7a-bdc8-4a3f-b11e-19c4357db21b)


### Article Management
Users have the ability to access and read articles without the necessity of logging in.
Retrive All Articles
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/8859cc8f-a918-4b68-bbc1-9d8ba85552d1)
Retrive via Article Id
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/9c6fdfff-ed69-4af8-a640-2901c19749d2)
Users logged-in have the ability to add an article
Add an Article
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/4f66176a-eb56-4493-937f-6a84c3d646dc)
After;
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/cc1f4fdc-2977-4a0f-b1e2-bc35c02f9153)
Users logged-in have the ability to update an article
Update an Article
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/6fb70b90-cf26-4d77-bd56-cfb7d29fdf1c)
After;
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/ca2b8f84-3dcc-4229-84c4-fc9a74b7e765)
Users logged-in have the ability to delete an article
Deleting an Article
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/a0dbae3a-f915-4ab0-968c-22a0a943cdff)
After;
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/3afc3de6-03dd-41b6-935d-4a8a2145b506)



### Like Feature
Users can express their appreciation for a post by specifying the article ID to like it.
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/a844f9f9-2ffe-48c0-9709-4ec612265286)
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/3fead8f4-922d-4e19-a0da-9e892083ab91)
Users can also see the amount of likes in a post
![image](https://github.com/sumstudent/coding-test-php/assets/61895002/77364069-658d-4be7-b1ac-5b807273348f)




