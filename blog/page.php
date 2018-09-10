<?php
session_start();
function fetchTokenByUserName($user){
    $conn = new mysqli('localhost','root','root','blog');
    $result = $conn->query("SELECT users.email, tokens.token FROM `users` RIGHT JOIN tokens ON users.id=tokens.user_id
        WHERE users.email='$user'");
    $results = array();
    while($row = $result->fetch_assoc()){
        $results[] = $row['token'];
    }
    print_r($results);
    return $results;
}

function rememberMe() {
    $secret_key = "SECRET";
$cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : '';
if ($cookie) {
    list ($user, $token, $mac) = explode(':', $cookie);
    if (!hash_equals(hash_hmac('sha256', $user . ':' . $token, $secret_key), $mac)) {
        return false;
    }
    $usertokens = fetchTokenByUserName($user);
            foreach($usertokens as $usertoken){
                if (hash_equals($usertoken, $token)) {
        $_SESSION['username'] = $user;
        }
            }
}
}
if(!isset($_SESSION['username'])){
rememberMe();
}
print $_SESSION['username'];
?>