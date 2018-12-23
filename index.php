<?php

// Reads the variables sent via POST from our gateway

$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = "09065798971";//$_POST["phoneNumber"];
$text = $_POST["text"];
$message = "Happy people";
$password = "";
$username = "root";
$host = "localhost";
$db = "akwa_ibom";


$conn = mysqli_connect($host, $username, $password,$db);

if(!conn){
    die("Connection failed:" . mysqli_connect_error());
}
$ph = checkNumber($phoneNumber);
if(!empty($ph) || $ph ="" || $ph = null){
    $card_pin = getCard($ph);
}else{

   $id =  insertPhone($phoneNumber);
   updateUser($id);
   $card_pin = getCard($id);
}
// $sql = "INSERT INTO UserTable(id, CardId, PhoneNumber)
// VALUES('1', '1', '08146500887')";

// if(mysqli_query($conn, $sql)){
//     echo "New Record Created successfully"; 
// }else{
//     echo "Error :" .$sql . "<br>" .mysqli_connect_error($conn);
// }

// $sql = "SELECT id, id, cardId FROM MyGuests";
// $result = mysqli_query($conn, $sql);

// if(mysqli_num_rows($result) > 0){
//     //output data of each row
//     while ($row = mysqli_fetch_assoc($result)) {
//         echo "id: ". $row["id"]. "- Name: " . $row["id"]cardId$row["lastname"]."<br>";
//         # code...
//     }
// }else {
//     echo "0 results";
// }



if ($text == ""){
    $response = "CON Please input thy code\n";
    $response .= $card_pin;
}
elseif($text == "030901002"){
    $response = "END You are correct.\n";
    $response .= $message;
    $response .= $card_pin;
}
elseif($text == "030901003"){
    $response = "END You are NOT serios.";
    $response .= $message;
    $response .= $card_pin;
}
elseif($text == "030901003"){
    $response = "END Its a test.";
    $response .= $message;
    $response .= $card_pin;
}

header('Content-type: text/plain');

echo $response;

// DONE!


function checkNumber($phone){
global $conn;
    $query = "SELECT * FROM users where phone_number='$phone'";

    $result = mysqli_query($conn, $query) or die("Unable to fr connect ".mysqli_connect_error($conn));
    $count = mysqli_num_rows($result);
  

    if($count > 0){
        while($row = mysqli_fetch_assoc($result)){
          
            return $row['card_id'];
        }
    }
    return '';
}

function checkPin($id){
    global $conn;
    $query = "SELECT * FROM voucher where id='$id'";

    $result = mysqli_query($conn, $query) or die("Unable to connect");
    $count = mysqli_num_rows($result);
    if($count > 0){
        return true;
    }
    return '';
}

function insertPhone($phone){
    global $conn;
    $query = "INSERT INTO users (phone_number) VALUES ('".$phone."')";   

    $result = mysqli_query($conn, $query) or die("Unable to connect");
    return mysqli_insert_id($conn);
    // return $result;
}

function updateUser($id){
    global $conn;
  if(checkPin($id)){
    $query = "UPDATE  users SET card_id='$id' where id='$id'";
    $result = mysqli_query($conn, $query) or die("Unable to connect");
    return $result;
  }
}
function getCard($card_id){
    global $conn;
    $query = "SELECT card_pin FROM voucher where id='$card_id'";

    $result = mysqli_query($conn, $query) or die("Unable to connect");
    if(mysqli_num_rows($result) >0){
        while($row = mysqli_fetch_assoc($result)){

            return $row['card_pin'];
        }
    }
}
mysqli_close($conn);
?>
