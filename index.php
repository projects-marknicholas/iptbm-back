<?php
// Security Headers
function cors() {
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
  }

  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);
  }
}

cors();

require 'config.php';
require 'router.php';
require 'controllers/auth.php';
require 'controllers/admin.php';

// Initialize Router
$router = new Router();

// Post Requests
$router->post('/api/auth/register', 'AuthController@register');
$router->post('/api/auth/login', 'AuthController@login');

// Admin
$router->post('/api/admin/records', 'AdminController@insert_records');
$router->get('/api/admin/records', 'AdminController@get_records');

// Dispatch the request
$router->dispatch();
?>
