<?php
class AuthController {
  public function register() {
    $name = $_POST['name'];
    if($name){
      $response['status'] = 'success';
      $response['message'] = 'Merong laman yung name';
      $response['data'] = $name;
      echo json_encode($response);
      return;
    }
    else {
      $response['status'] = 'error';
      $response['message'] = 'Walang laman yung name';
      echo json_encode($response);
      return;
    }
  }

  public function login() {
    echo 'login';
  }
}
?>