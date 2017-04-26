<?php
/**
 * Created by PhpStorm.
 * User: harrisonchow
 * Date: 6/8/16
 * Time: 1:17 AM
 */
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    header("HTTP/1.1 403 Forbidden");
    exit;
}
require '../../vendor/autoload.php'; // MAKE SURE THIS POINTS TO YOUR COMPOSER VENDOR FOLDER
$getPost = (array)json_decode(file_get_contents('php://input'));
$from = new SendGrid\Email($getPost['fromName'], $getPost['sendFrom']);
$subject = $getPost['subject'];
$to = new SendGrid\Email($getPost['toName'], $getPost['sendTo']);
$content = new SendGrid\Content("text/plain", $getPost['msgHTML']);
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$apiKey = getenv('SENDGRID_API');
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);

ob_start();
var_dump($response);
$result = ob_get_clean();


echo json_encode(array('success' => true, 'message' => $response->statusCode() . " : " . $result));
