# Backend API Documentation

### Introduction
The Router class provides a simple and efficient way to handle routing and dispatching HTTP requests in PHP applications. It allows you to define routes for different HTTP methods (GET, POST, PUT, DELETE) and map them to corresponding handlers.

---

### Usage

1. Initializing Router:
    To use the Router, you first need to instantiate the Router class.
    ```
    $router = new Router();
    ```
2. Defining Routes:
    You can define routes using the following methods:
    - `get($path, $handler)`: Define a route for GET requests.
    - `post($path, $handler)`: Define a route for POST requests.
    - `put($path, $handler)`: Define a route for PUT requests.
    - `delete($path, $handler)`: Define a route for DELETE requests.
   
    Example:
    ```
    $router->get('/api/auth/login', 'AuthController@login');
    ```
    
3. Dispatching Requests:
    After defining routes, you need to dispatch the incoming request to the appropriate handler using the `dispatch()` method.

---
### Route Handlers
Route handlers are callback functions responsible for processing incoming requests. Handlers are specified as strings in the format `Controller@method.` The Router resolves these strings to instantiate the corresponding controller class and call the specified method.
    
Example:
```
$router->get('/api/auth/login', 'AuthController@login');
```
In this example, when a GET request is made to `/api/auth/login`, the `login` method of `AuthController` is called.

---
### Example: AuthController
The AuthController class provides methods for user authentication such as registering and logging in users.

- `register()`: Handles user registration by validating input data and inserting the user into the database.
- `login()`: Handles user login by retrieving the user from the database and verifying the password.

---
### API Endpoints and API
API (Application Programming Interface) endpoints are specific URLs that the API exposes for interacting with the application. These endpoints represent different functionalities or resources provided by the API.

In this documentation, the API endpoints are:

- `/api/auth/register`: Endpoint for user registration.
- `/api/auth/login`: Endpoint for user login.

These endpoints are prefixed with `/api` to denote that they are part of an API. APIs typically expose endpoints for performing CRUD (Create, Read, Update, Delete) operations on resources like users, products, etc.

---
### Response Format
All endpoints return responses in JSON format. This format ensures consistency and ease of parsing for client applications consuming the API. Responses contain relevant data or error messages, making it easy for client applications to handle success and failure cases.

Example of JSON Response:
```
{
  "status": "success",
  "message": "User registered successfully."
}
```
And here's an example of a JSON format response for a failed user registration due to missing email:
```
{
  "status": "error",
  "message": "Email is required."
}
```
These responses follow a consistent structure where status indicates the success or failure of the operation, and message provides additional details about the result. Depending on the context, you can include more fields in the response to convey relevant information to the client application.

Here's an example of a JSON format response for a successful user login, including the user's data:
```
{
  "status": "success",
  "message": "Login successful.",
  "user": {
    "user_id": "123456",
    "full_name": "John Doe",
    "email": "johndoe@example.com",
    "created_at": "2024-06-04 12:30:45",
    "image": "profile_picture.jpg"
  }
}
```

---
### .htaccess
The `.htaccess` file is a configuration file used in Apache web servers to customize settings on a per-directory basis. It allows webmasters to override server configurations, manage URL rewriting for clean URLs, control access to directories or files, and define custom error pages. It's a powerful tool for enhancing website functionality and security. By understanding its capabilities and best practices, webmasters can effectively manage server configuration, improve SEO, and enhance website security.

---
### Security
The Router includes a `cors()` function to handle Cross-Origin Resource Sharing (CORS) headers. It ensures that requests from allowed origins are processed and appropriate headers are set.

---


