<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}

// Auto-detect environment: localhost vs hosting
$is_local = (strpos($_SERVER['HTTP_HOST'],'localhost')!==false || strpos($_SERVER['HTTP_HOST'],'127.0.0.1')!==false);

if($is_local){
  $host = 'localhost';
  $db   = 'mimieats';
  $user = 'root';
  $pass = 'shil1234';
} else {
  $host = 'sql104.infinityfree.com';
  $db   = 'if0_41811433_mimieats';
  $user = 'if0_41811433';
  $pass = 'rYmQGUCfK16';
}

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
  echo json_encode(['error'=>'DB failed: '.$conn->connect_error]);
  exit;
}
$conn->set_charset('utf8mb4');

// Create tables
$conn->query("CREATE TABLE IF NOT EXISTS chats (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  shop_id VARCHAR(100) DEFAULT 'general',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
$conn->query("CREATE TABLE IF NOT EXISTS shop_settings (
  shop_id VARCHAR(100) PRIMARY KEY,
  min_price INT DEFAULT 0
)");
$conn->query("CREATE TABLE IF NOT EXISTS ratings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  shop_id VARCHAR(100) NOT NULL,
  buyer_uid VARCHAR(50) DEFAULT '',
  buyer_name VARCHAR(100) DEFAULT '',
  rating TINYINT NOT NULL,
  review TEXT DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$method = $_SERVER['REQUEST_METHOD'];
$shop_id = isset($_GET['shop']) ? $conn->real_escape_string(trim($_GET['shop'])) : 'general';

// GET
if($method === 'GET'){
  $action = isset($_GET['action']) ? $_GET['action'] : '';

  if($action === 'settings'){
    $r = $conn->query("SELECT * FROM shop_settings WHERE shop_id='$shop_id'");
    $row = $r ? $r->fetch_assoc() : null;
    echo json_encode($row ?: ['shop_id'=>$shop_id,'min_price'=>0]);
    exit;
  }

  if($action === 'ratings'){
    $r = $conn->query("SELECT * FROM ratings WHERE shop_id='$shop_id' ORDER BY created_at DESC LIMIT 20");
    $rows = [];
    if($r) while($row=$r->fetch_assoc()) $rows[]=$row;
    echo json_encode($rows);
    exit;
  }

  if($shop_id && $shop_id !== 'all'){
    $r = $conn->query("SELECT * FROM chats WHERE shop_id='$shop_id' ORDER BY created_at ASC");
  } else {
    $r = $conn->query("SELECT * FROM chats ORDER BY created_at ASC");
  }
  $rows = [];
  if($r) while($row=$r->fetch_assoc()) $rows[]=$row;
  echo json_encode($rows);
  exit;
}

// POST
if($method === 'POST'){
  $body = json_decode(file_get_contents('php://input'), true) ?: [];
  if(empty($body)) $body = $_POST;
  $action = isset($body['action']) ? $body['action'] : '';
  $sid = isset($body['shop_id']) ? $conn->real_escape_string(trim($body['shop_id'])) : $shop_id;

  if($action === 'clear_chat'){
    if($sid && $sid !== 'all') $conn->query("DELETE FROM chats WHERE shop_id='$sid'");
    else $conn->query("TRUNCATE TABLE chats");
    echo json_encode(['ok'=>true]); exit;
  }

  if($action === 'clear_orders'){
    if($sid && $sid !== 'all') $conn->query("DELETE FROM chats WHERE shop_id='$sid'");
    else $conn->query("TRUNCATE TABLE chats");
    echo json_encode(['ok'=>true]); exit;
  }

  if($action === 'save_settings'){
    $min = intval(isset($body['min_price']) ? $body['min_price'] : 0);
    $conn->query("INSERT INTO shop_settings (shop_id,min_price) VALUES ('$sid',$min) ON DUPLICATE KEY UPDATE min_price=$min");
    echo json_encode(['ok'=>true,'min_price'=>$min]); exit;
  }

  if($action === 'submit_rating'){
    $rating = intval(isset($body['rating']) ? $body['rating'] : 0);
    $review = $conn->real_escape_string(isset($body['review']) ? $body['review'] : '');
    $buid   = $conn->real_escape_string(isset($body['buyer_uid']) ? $body['buyer_uid'] : '');
    $bname  = $conn->real_escape_string(isset($body['buyer_name']) ? $body['buyer_name'] : '');
    if($rating<1||$rating>5){ echo json_encode(['error'=>'invalid rating']); exit; }
    $conn->query("INSERT INTO ratings (shop_id,buyer_uid,buyer_name,rating,review) VALUES ('$sid','$buid','$bname',$rating,'$review')");
    echo json_encode(['ok'=>true,'id'=>$conn->insert_id]); exit;
  }

  // Insert message
  $sender  = $conn->real_escape_string(trim(isset($body['sender']) ? $body['sender'] : ''));
  $message = $conn->real_escape_string(trim(isset($body['message']) ? $body['message'] : ''));
  if(!$sender || !$message){ echo json_encode(['error'=>'missing fields']); exit; }

  // Min price check for nego
  if($sender === 'Buyer' && strpos($message,'[Price Negotiation]') !== false){
    $r = $conn->query("SELECT min_price FROM shop_settings WHERE shop_id='$sid'");
    if($r && $row=$r->fetch_assoc()){
      $min_price = intval($row['min_price']);
      if($min_price > 0){
        preg_match("/Buyer's Offer: Rp ([0-9.,]+)/", $message, $m);
        if($m){
          $offer = intval(str_replace([',','.'],'',$m[1]));
          if($offer < $min_price){
            echo json_encode(['ok'=>false,'blocked'=>true,'min_price'=>$min_price]);
            exit;
          }
        }
      }
    }
  }

  $conn->query("INSERT INTO chats (sender,message,shop_id) VALUES ('$sender','$message','$sid')");
  echo json_encode(['ok'=>true,'id'=>$conn->insert_id]);
  exit;
}

http_response_code(405);
echo json_encode(['error'=>'method not allowed']);