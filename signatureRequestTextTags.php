<?php
// when I'm ready to start handling checkboxes on the form:
// http://www.html-form-guide.com/php-form/php-form-checkbox.html
require_once 'vendor/autoload.php';
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["uploadedTextTags"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if ($imageFileType != "pdf") {
    echo "Sorry, only pdfs are allowed at this point";
    echo '<br />';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    echo '<br />';
    // $uploadOk = 0;
    goto skip;
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadedTextTags"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["uploadedTextTags"]["name"]) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        $uploadOk = 0;
        goto skip;
    }
}
// Get your credentials from environment variables
$api_key = getenv('HS_APIKEY_PROD') ? getenv('HS_APIKEY_PROD') : '';
$client_id = getenv('HS_CLIENT_ID_PROD') ? getenv('HS_CLIENT_ID_PROD') : '';

// Instance of a client for you to use for calls
$client = new HelloSign\Client($api_key);
// Example call with logging for embedded requests
$request = new HelloSign\SignatureRequest;
$request->enableTestMode();
$request->setUseTextTags(TRUE);
$request->setTitle("Testing");
$request->setSubject('My First embedded signature request');
$request->setMessage('Awesome, right?');
$request->addSigner('testing@testing.com', 'Something');
$request->addFile("$target_file");

// Turn it into an embedded request
$embedded_request = new HelloSign\EmbeddedSignatureRequest($request, $client_id);

// Send it to HelloSign
$response = $client->createEmbeddedSignatureRequest($embedded_request);

// wait for callback with signature_request_sent
// 
// Grab the signature ID for the signature page that will be embedded in the page
$signatures = $response->getSignatures();
$signature_id = $signatures[0]->getId();

// Retrieve the URL to sign the document
$response = $client->getEmbeddedSignUrl($signature_id);

// Store it to use with the embedded.js HelloSign.open() call
$sign_url = $response->getSignUrl();

// call the html page with the embedded.js lib and HelloSign.open()
include('signtest2.php');

skip:
if ($uploadOk == 0) {
    echo '<br />';
    echo '<a href="display.php?admin=1">GO HOME YOU ARE DRUNK</a>';
}
?>
