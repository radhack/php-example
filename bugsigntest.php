<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
<!--        <meta name="viewport" content="width=device-width, initial-scale=1.0" />-->
        <meta name="viewport" content="width=device-width" />
        <!--I can't get my page to break like the Acurian one, so can't tell if this fixes their issue or not-->
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
            <!--this one below is the one they were using - I now think it's not related to the issue-->
        <!--<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=2.0,user-scalable=1" />--> 
        <title>Signing Test</title>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="//s3.amazonaws.com/cdn.hellosign.com/public/js/hellosign-embedded.LATEST.min.js"></script>
        <link rel="stylesheet" type="text/css" href="newcss.css" />
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/manifest.json">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <div class="object">
            <script>
                HelloSign.init("<?php echo $client_id ?>");
                HelloSign.open({
                    url: "<?php echo $sign_url ?>",
                    uxVersion: 2,
                    allowCancel: true,
                    <!-- skipDomainVerification: true, -->
                    debug: true,
                    container: document.getElementById('object'),
                    messageListener: function (eventData) {
                        ("Got message data: " + JSON.stringify(eventData));

                        if (eventData.event == HelloSign.EVENT_SIGNED) {
                            alert("Signature Request Signed And Stuff!");
                            console.log(eventData);
                            window.location = "display.php?admin=1";
                        } else if (eventData.event == HelloSign.EVENT_CANCELED) {
                            alert("Signature Request Canceled And Stuff!");
                            console.log(eventData);
                            window.location = "display.php?admin=1";
                        } else if (eventData.event == HelloSign.EVENT_ERROR) {
                            alert("There Was An Error And Stuff!");
                            console.log(eventData);
                            window.location = "display.php?admin=1";
                        } else if (eventData.event == HelloSign.EVENT_SENT) {
                            alert("Signature Request Sent And Stuff!");
                            console.log(eventData);
                            window.location = "display.php?admin=1";
                        } else if (eventData.event == HelloSign.EVENT_TEMPLATE_CREATED) {
                            alert("Template Created And Stuff!");
                            console.log(eventData);
                            window.location = "display.php?admin=1";
                        }
                    }
                });
            </script>
        </div>
    </body>
</html>
