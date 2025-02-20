<?php
class AdminController{
  // Records
  public function insert_records() {
    global $conn;
    date_default_timezone_set('Asia/Manila');
    $response = array();

    $record_id = bin2hex(random_bytes(16));
    $technology = htmlspecialchars($_POST['technology'] ?? '');
    $ip_type = htmlspecialchars($_POST['ip_type'] ?? '');
    $year = htmlspecialchars($_POST['year'] ?? '');
    $date_of_filing = htmlspecialchars($_POST['date_of_filing'] ?? '');
    $application_no = htmlspecialchars($_POST['application_no'] ?? '');
    $abstract = htmlspecialchars($_POST['abstract'] ?? '');
    $inventors = htmlspecialchars($_POST['inventors'] ?? '');
    $status = htmlspecialchars($_POST['status'] ?? '');
    $created_at = date('Y-m-d H:i:s');

    // API Key Validation
    // $security_key = new SecurityKey($conn);
    // $security_response = $security_key->validateBearerToken();

    // if ($security_response['status'] === 'error') {
    //   echo json_encode($security_response);
    //   return;
    // }

    // if ($security_response['role'] !== 'admin') {
    //   echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    //   return;
    // }   

    // Input Validations
    if(empty($technology)){
      $response['status'] = 'error';
      $response['message'] = 'Technology cannot be empty';
      echo json_encode($response);
      return;
    }
    
    if(empty($ip_type)){
      $response['status'] = 'error';
      $response['message'] = 'IP type cannot be empty';
      echo json_encode($response);
      return;
    }
    
    if(empty($year)){
      $response['status'] = 'error';
      $response['message'] = 'Year cannot be empty';
      echo json_encode($response);
      return;
    } elseif (!preg_match('/^[0-9]{4}$/', $year)) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid year format. Please enter a valid 4-digit year.';
      echo json_encode($response);
      return;
    }    
    
    if(empty($date_of_filing)){
      $response['status'] = 'error';
      $response['message'] = 'Date of filing cannot be empty';
      echo json_encode($response);
      return;
    } elseif (!strtotime($date_of_filing)) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid date format. Please enter a valid date.';
      echo json_encode($response);
      return;
    }    
    
    if(empty($application_no)){
      $response['status'] = 'error';
      $response['message'] = 'Application no. cannot be empty';
      echo json_encode($response);
      return;
    }
    
    if(empty($abstract)){
      $response['status'] = 'error';
      $response['message'] = 'Abstract cannot be empty';
      echo json_encode($response);
      return;
    }
    
    if(empty($inventors)){
      $response['status'] = 'error';
      $response['message'] = 'Inventors cannot be empty';
      echo json_encode($response);
      return;
    }
    
    if(empty($status)){
      $response['status'] = 'error';
      $response['message'] = 'Status cannot be empty';
      echo json_encode($response);
      return;
    }

    // File upload handling
    if (isset($_FILES['banner_image'])) {
      $target_dir = "uploads/";
      $imageFileType = strtolower(pathinfo($_FILES["banner_image"]["name"], PATHINFO_EXTENSION));
    
      // Generate a unique file name using timestamp and uniqid
      $new_file_name = time() . '_' . uniqid() . '.' . $imageFileType;
      $target_file = $target_dir . $new_file_name;
    
      // Validate image file type
      $valid_types = array("jpg", "png", "jpeg", "gif");
      if (!in_array($imageFileType, $valid_types)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid image type';
        echo json_encode($response);
        return;
      }
    
      if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) {
        // Only save the image file name (not the full path)
        $banner_image = $new_file_name;
      } else {
        $response['status'] = 'error';
        $response['message'] = 'Error uploading image';
        echo json_encode($response);
        return;
      }
    }    

    // Check if the record already exists
    $lowered_st = strtolower($record_id);
    $stmt = $conn->prepare("SELECT record_id FROM records WHERE record_id = ?");
    $stmt->bind_param("s", $lowered_st);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
      $stmt->close();
      $response['status'] = 'error';
      $response['message'] = 'This record already exists';
      echo json_encode($response);
      return;
    }

    $stmt->close();

    // Insert data
    $stmt = $conn->prepare('INSERT INTO records (
      record_id, 
      banner_image, 
      technology,
      ip_type,
      year,
      date_of_filing,
      application_no,
      abstract,
      inventors,
      status,
      created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sssssssssss', 
        $record_id, 
        $banner_image, 
        $technology,
        $ip_type,
        $year,
        $date_of_filing,
        $application_no,
        $abstract,
        $inventors,
        $status,
        $created_at
    );

    if ($stmt->execute()){
      $response['status'] = 'success';
      $response['message'] = 'Record inserted successfully';
      echo json_encode($response);
      return;
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Error inserting record: ' . $conn->error;
      echo json_encode($response);
      return;
    }
  }

  public function get_records() {
    global $conn;
    date_default_timezone_set('Asia/Manila');
    $response = array();

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $records_per_page = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
    $offset = ($page - 1) * $records_per_page;

    $search = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';

    $stmt = $conn->prepare("SELECT * FROM records WHERE 
                            technology LIKE ? 
                            OR ip_type LIKE ? 
                            OR year LIKE ?
                            OR date_of_filing LIKE ?
                            OR application_no LIKE ?
                            OR abstract LIKE ?
                            OR inventors LIKE ?
                            OR status LIKE ?
                            ORDER BY created_at DESC LIMIT ?, ?");

    if (!$stmt) {
      $response['status'] = 'error';
      $response['message'] = 'SQL error: ' . $conn->error;
      echo json_encode($response);
      return;
    }

    $stmt->bind_param("ssssssssii", $search, $search, $search, $search, $search, $search, $search, $search, $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_stmt = $conn->prepare("SELECT COUNT(*) as total FROM records WHERE 
                                   technology LIKE ? 
                                   OR ip_type LIKE ? 
                                   OR year LIKE ?
                                   OR date_of_filing LIKE ?
                                   OR application_no LIKE ?
                                   OR abstract LIKE ?
                                   OR inventors LIKE ?
                                   OR status LIKE ?");

    if (!$total_stmt) {
      $response['status'] = 'error';
      $response['message'] = 'SQL error: ' . $conn->error;
      echo json_encode($response);
      return;
    }

    $total_stmt->bind_param("ssssssss", $search, $search, $search, $search, $search, $search, $search, $search);
    $total_stmt->execute();
    $total_result = $total_stmt->get_result();
    $total_records = $total_result->fetch_assoc()['total'];

    if ($result->num_rows > 0) {
      $data = [];
      $response['status'] = 'success';
      while ($row = $result->fetch_assoc()) {
        $data[] = [
          "record_id" => $row['record_id'],
          "banner_image" => $row['banner_image'],
          "technology" => $row['technology'],
          "ip_type" => $row['ip_type'],
          "year" => $row['year'],
          "date_of_filing" => $row['date_of_filing'],
          "application_no" => $row['application_no'],
          "abstract" => $row['abstract'],
          "inventors" => $row['inventors'],
          "status" => $row['status'],
          "created_at" => $row['created_at']
        ];
      }
      $response['data'] = $data;
      $response['pagination'] = [
        'current_page' => $page,
        'records_per_page' => $records_per_page,
        'total_records' => $total_records,
        'total_pages' => ceil($total_records / $records_per_page)
      ];
      echo json_encode($response);
      return;
    } else {
      $response['status'] = 'error';
      $response['message'] = 'No records found';
      echo json_encode($response);
      return;
    }

    $stmt->close();
    $total_stmt->close();
  }
}

?>