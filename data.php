<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Auto-detect environment
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
  echo json_encode(getFallbackData());
  exit;
}
$conn->set_charset('utf8mb4');

$conn->query("CREATE TABLE IF NOT EXISTS foods (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  shop VARCHAR(200) NOT NULL,
  img TEXT DEFAULT '',
  base INT NOT NULL DEFAULT 0,
  fee INT NOT NULL DEFAULT 0,
  time_est VARCHAR(50) DEFAULT '20 min',
  rating DECIMAL(3,1) DEFAULT 4.5,
  category VARCHAR(50) DEFAULT 'savory',
  tags VARCHAR(200) DEFAULT '',
  promo TINYINT(1) DEFAULT 0,
  discount INT DEFAULT 0,
  lat DECIMAL(10,7) DEFAULT -6.2000,
  lng DECIMAL(10,7) DEFAULT 106.8166,
  active TINYINT(1) DEFAULT 1
)");

$r = $conn->query("SELECT COUNT(*) as c FROM foods");
$cnt = $r ? $r->fetch_assoc()['c'] : 0;
if($cnt == 0){
  foreach(getFallbackData() as $f){
    $n=$conn->real_escape_string($f['name']);
    $sh=$conn->real_escape_string($f['shop']);
    $im=$conn->real_escape_string($f['img']);
    $tg=$conn->real_escape_string(implode(',',$f['tags']));
    $ti=$conn->real_escape_string($f['time']);
    $pr=$f['promo']?1:0;
    $conn->query("INSERT INTO foods (id,name,shop,img,base,fee,time_est,rating,category,tags,promo,discount,lat,lng) VALUES ({$f['id']},'$n','$sh','$im',{$f['base']},{$f['fee']},'$ti',{$f['rating']},'{$f['category']}','$tg',$pr,{$f['discount']},{$f['lat']},{$f['lng']})");
  }
}

$r = $conn->query("SELECT * FROM foods WHERE active=1 ORDER BY id ASC");
$rows = [];
if($r){
  while($row=$r->fetch_assoc()){
    $rows[] = [
      'id'=>(int)$row['id'],'name'=>$row['name'],'shop'=>$row['shop'],'img'=>$row['img'],
      'base'=>(int)$row['base'],'fee'=>(int)$row['fee'],'time'=>$row['time_est'],
      'rating'=>(float)$row['rating'],'category'=>$row['category'],
      'tags'=>array_values(array_filter(array_map('trim',explode(',',$row['tags'])))),
      'promo'=>(bool)$row['promo'],'discount'=>(int)$row['discount'],
      'lat'=>(float)$row['lat'],'lng'=>(float)$row['lng'],
    ];
  }
}
echo json_encode(count($rows)>0 ? $rows : getFallbackData());

function getFallbackData(){
  return [
    ['id'=>1,'name'=>"Nasi Goreng",'shop'=>"Mimi Kitchen",'img'=>"https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400&h=300&fit=crop",'base'=>24000,'fee'=>6000,'time'=>"30 min",'rating'=>4.9,'category'=>"rice",'tags'=>["savory","bestseller"],'promo'=>true,'discount'=>10,'lat'=>-6.1988,'lng'=>106.8230],
    ['id'=>2,'name'=>"Nasi Goreng",'shop'=>"Kedai Rasa Sayang",'img'=>"https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400&h=300&fit=crop",'base'=>25000,'fee'=>12000,'time'=>"20 min",'rating'=>4.8,'category'=>"rice",'tags'=>["savory"],'promo'=>false,'discount'=>0,'lat'=>-6.2010,'lng'=>106.8160],
    ['id'=>3,'name'=>"Nasi Goreng Pedas",'shop'=>"Seblak Enjoy",'img'=>"https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400&h=300&fit=crop",'base'=>20000,'fee'=>6000,'time'=>"25 min",'rating'=>4.8,'category'=>"rice",'tags'=>["spicy","bestseller"],'promo'=>false,'discount'=>0,'lat'=>-6.2020,'lng'=>106.8250],
    ['id'=>4,'name'=>"Nasi Padang",'shop'=>"RM Sinar Minang",'img'=>"https://images.unsplash.com/photo-1604329760661-e71dc83f8f26?w=400&h=300&fit=crop",'base'=>22000,'fee'=>5000,'time'=>"15 min",'rating'=>4.9,'category'=>"rice",'tags'=>["savory","spicy","bestseller"],'promo'=>true,'discount'=>20,'lat'=>-6.1990,'lng'=>106.8170],
    ['id'=>5,'name'=>"Ayam Bakar",'shop'=>"Ayam Bakar Madu Solo",'img'=>"https://images.unsplash.com/photo-1527477396000-e27163b481c2?w=400&h=300&fit=crop",'base'=>35000,'fee'=>10000,'time'=>"15 min",'rating'=>4.7,'category'=>"savory",'tags'=>["savory","bestseller"],'promo'=>true,'discount'=>15,'lat'=>-6.1975,'lng'=>106.8155],
    ['id'=>6,'name'=>"Ayam Bakar Pedas",'shop'=>"Penyetan Mas Jago",'img'=>"https://images.unsplash.com/photo-1611599537845-1c7aca0091c0?w=400&h=300&fit=crop",'base'=>30000,'fee'=>9000,'time'=>"25 min",'rating'=>4.6,'category'=>"savory",'tags'=>["savory","spicy"],'promo'=>false,'discount'=>0,'lat'=>-6.2055,'lng'=>106.8210],
    ['id'=>7,'name'=>"Mie Ayam",'shop'=>"Mie Ayam Wonogiri",'img'=>"https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=400&h=300&fit=crop",'base'=>15000,'fee'=>12000,'time'=>"10 min",'rating'=>4.4,'category'=>"noodles",'tags'=>["savory"],'promo'=>false,'discount'=>0,'lat'=>-6.2000,'lng'=>106.8140],
    ['id'=>8,'name'=>"Mie Ayam Spesial",'shop'=>"Bakso Idola",'img'=>"https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=400&h=300&fit=crop",'base'=>18000,'fee'=>5000,'time'=>"15 min",'rating'=>4.8,'category'=>"noodles",'tags'=>["savory","bestseller"],'promo'=>true,'discount'=>5,'lat'=>-6.1965,'lng'=>106.8200],
    ['id'=>9,'name'=>"Mie Goreng",'shop'=>"Mimi Kitchen",'img'=>"https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400&h=300&fit=crop",'base'=>16000,'fee'=>6000,'time'=>"20 min",'rating'=>4.6,'category'=>"noodles",'tags'=>["savory"],'promo'=>false,'discount'=>0,'lat'=>-6.1988,'lng'=>106.8230],
    ['id'=>10,'name'=>"Seblak",'shop'=>"Seblak Enjoy",'img'=>"https://images.unsplash.com/photo-1626804475297-41608ea09aeb?w=400&h=300&fit=crop",'base'=>17500,'fee'=>6000,'time'=>"30 min",'rating'=>4.7,'category'=>"spicy",'tags'=>["spicy","bestseller"],'promo'=>false,'discount'=>0,'lat'=>-6.2020,'lng'=>106.8250],
    ['id'=>11,'name'=>"Sate Ayam",'shop'=>"Sate Madura Cak Edi",'img'=>"https://images.unsplash.com/photo-1529042410759-befb1204b468?w=400&h=300&fit=crop",'base'=>20000,'fee'=>7000,'time'=>"20 min",'rating'=>4.7,'category'=>"snacks",'tags'=>["savory","bestseller"],'promo'=>false,'discount'=>0,'lat'=>-6.2045,'lng'=>106.8175],
    ['id'=>12,'name'=>"Bakso Sapi",'shop'=>"Bakso Solo Baru",'img'=>"https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400&h=300&fit=crop",'base'=>18000,'fee'=>5000,'time'=>"12 min",'rating'=>4.6,'category'=>"savory",'tags'=>["savory"],'promo'=>false,'discount'=>0,'lat'=>-6.2015,'lng'=>106.8135],
    ['id'=>13,'name'=>"Martabak Manis",'shop'=>"Martabak Bintang",'img'=>"https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=400&h=300&fit=crop",'base'=>30000,'fee'=>8000,'time'=>"20 min",'rating'=>4.7,'category'=>"sweet",'tags'=>["sweet","bestseller"],'promo'=>false,'discount'=>0,'lat'=>-6.2030,'lng'=>106.8220],
    ['id'=>14,'name'=>"Pisang Goreng",'shop'=>"Kedai Rasa Sayang",'img'=>"https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=400&h=300&fit=crop",'base'=>10000,'fee'=>5000,'time'=>"15 min",'rating'=>4.5,'category'=>"sweet",'tags'=>["sweet"],'promo'=>true,'discount'=>10,'lat'=>-6.2010,'lng'=>106.8160],
    ['id'=>15,'name'=>"Es Teler",'shop'=>"Mimi Kitchen",'img'=>"https://images.unsplash.com/photo-1488477181946-6428a0291777?w=400&h=300&fit=crop",'base'=>12000,'fee'=>4000,'time'=>"10 min",'rating'=>4.8,'category'=>"drinks",'tags'=>["sweet"],'promo'=>true,'discount'=>25,'lat'=>-6.1988,'lng'=>106.8230],
    ['id'=>16,'name'=>"Es Jeruk Segar",'shop'=>"Kedai Rasa Sayang",'img'=>"https://images.unsplash.com/photo-1546173159-315724a31696?w=400&h=300&fit=crop",'base'=>8000,'fee'=>4000,'time'=>"10 min",'rating'=>4.5,'category'=>"drinks",'tags'=>["sweet"],'promo'=>false,'discount'=>0,'lat'=>-6.2010,'lng'=>106.8160],
  ];
}