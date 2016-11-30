<?php

require_once 'vendor/autoload.php';
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["uploadedfile"]["name"]);
$uploadOk = 1; //this is used if the other if statements are used
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
//if ($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "ppsx" && $imageFileType != "ppt" && $imageFileType != "pptx" && $imageFileType != "tif" && $imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "xls" && $imageFileType != "xlsx" && $imageFileType != "txt" && $imageFileType != "html" && $imageFileType != "gif") {
//    echo "Sorry, only doc, docx, pdf, ppsx, ppt, pptx, tif, jpg, jpeg, png, xls, <br />"
//    . "xlsx, txt, html, and gif are allowed at this point <br />";
//    $uploadOk = 0;
//}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    goto skip;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["uploadedfile"]["name"]) . " has been uploaded. <br />";
    } else {
        echo "Sorry, there was an error uploading your file. <br />";
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
$request->setTitle("Testing");
$request->setSubject('My First embedded signature request');
$request->setMessage('Awesome, right?');
$request->addSigner('testing@testing.com', 'Something');
$request->addFile("$target_file");

rename($target_file, "$target_file.embSigReq");
// Turn it into an embedded request
$embedded_request = new HelloSign\EmbeddedSignatureRequest($request, $client_id);

// Send it to HelloSign
$response = $client->createEmbeddedSignatureRequest($embedded_request);

// Grab the signature ID for the signature page that will be embedded in the page
$signatures = $response->getSignatures();
$signature_id = $signatures[0]->getId();

// Retrieve the URL to sign the document
$response = $client->getEmbeddedSignUrl($signature_id);

// Store it to use with the embedded.js HelloSign.open() call
$sign_url = $response->getSignUrl();

include('signtest2.php');
skip:
// skip loop so this doesn't run when skip isn't used
if ($uploadOk === 0) {
    echo '<br />';
    echo '<a href="display.php?admin=1">GO HOME YOU ARE DRUNK</a>';
}
?>
