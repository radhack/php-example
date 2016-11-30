<?php

class simpleCMS {

    var $host;
    var $username;
    var $password;
    var $table;

    public function display_public() {
        $q = "SELECT * FROM sigantureRequestDB ORDER BY created DESC LIMIT 3";
        $r = mysql_query($q);

        if ($r !== false && mysql_num_rows($r) > 0) {
            while ($a = mysql_fetch_assoc($r)) {
                $client_id = stripslashes($a['client_id']);
                $sign_url = stripslashes($a['sign_url']);

                $entry_display .= <<<ENTRY_DISPLAY

    <div class="html">
    	<h2>
            $client_id
    	</h2>
            <p>
                $sign_url
            </p>
	</div>

ENTRY_DISPLAY;
            }
        } else {
            $entry_display = <<<ENTRY_DISPLAY

    <h2> No DB connected yet </h2>
    <p>
    ...but you can still submit signature requests - 
    you just won't be able to track them easily on the back end.
    <p>
 
    Enjoy!
    </p>

ENTRY_DISPLAY;
        }
        $entry_display .= <<<ADMIN_OPTION
    <p class="admin_link">
      <a href="{$_SERVER['PHP_SELF']}?admin=1">START DAS PROCESS</a>
    </p>
      
ADMIN_OPTION;

        return $entry_display;
    }

    public function display_admin() {
        return <<<ADMIN_FORM
        <style type="text/css">
            body {
            background-color: #f0f0f2;
            margin: 0;
            padding: 0;

            }
            div {
                width: 815px;
                margin: 5em auto;
                padding: 10px;
                background-color: #fff;
                border-radius: 1em;
            }
            @media (max-width: 800px) {
                body {
                    background-color: #fff;
                }
                div {
                    width: auto;
                    margin: 0 auto;
                    border-radius: 0;
                    padding: 0px;
                }
            }
        </style>
        <h3>Have a look at these <i>crazy</i> embedded examples!</h3>
        <br />
        <!-- this is an embedded template page -->
        <form action="/embeddedTemplate.php" method="post" enctype="multipart/form-data">        
        <input type="submit" value="Template Creation"/><br />
        <input type="file" name="uploadedTemplateFile" id="uploadedTemplateFile"/>
        <p>Create a template</p>
        </form>
        <br />
        <!-- this is creating an embedded signature request using text tags -->
        <form action="/signatureRequestTextTags.php" method="post" enctype="multipart/form-data">
        <input type="submit" value="Text Tags are cool"/><br />
        <input type="file" name="uploadedTextTags" id="uploadedTextTags"/>
        <p>Sign a signature request that uses text tags</p>
        <p>NOTE - use a text tags pdf with only one signer!</p>
        </form>
        <br />
        <!-- this is a standard sig request with an appended signature page -->
        <form action="/AppendedSignaturePage.php" method="post" enctype="multipart/form-data">       
        <input type="submit" value="Easy as easy gets"/><br />
        <input type="file" name="uploadedfile" id="uploadedfile"/>
        <p>Sign a signature request that uses an appended signature page</p>
        </form>
        <br />
        <!-- this is an embedded requesting page -->
        <form action="/embeddedRequesting.php" method="post" enctype="multipart/form-data">        
        <input type="submit" value="Requesting"/><br />
        <input type="file" name="requestingFile" id="requestingFile"/>
        <p>Create a signature request that'll send a HelloSign email to the signer(s)</p>
        </form>
        <br />
        <!-- this is an embedded requesting page with embedded signing -->
        <form action="/embeddedRequestingEmbeddedSigning.php" method="post" enctype="multipart/form-data">         
        <input type="submit" value="Requesting for Embedded Signing"/><br />
        <input type="file" name="requestingFileEmbSig" id="requestingFileEmbSig"/>
        <p>Create a signature request that'll be used for embedded signing</p>
        </form>
        <br />
        <br />
        <!-- this for testing bugs -->
        <form action="/bugstesting.php" method="post" enctype="multipart/form-data">        
        <input type="submit" value="Bug Testing Only"/><br />
        <input type="file" name="BugTestingOnly" id="BugTestingOnly"/>
        <p>Use For Bug Testing Only - setup for bug </p>
        </form>
        <br />
        <!-- this is for custom fields response -->
        <a href="responseobject.php">See the response object</a>
        <br />
        <br />
        <a href="display.php">Back to Home</a>
        <br />
        <br />
        <br><p><small>No signature requests were harmed in the making of this example</small></p>
        
        <!-- these aren't used just yet - they'll maybe be used
        when I start using the db -->
        <!-- <form action="/someFileHere.php" method="post">  
        <form action="{$_SERVER['PHP_SELF']}" method="post">
        <label for="client_id">client_id:</label><br />
        <input name="client_id" id="client_id" type="text" maxlength="200" />
        <div class="clear"></div>
     
        <label for="sign_url">sign_url:</label><br />
        <input name="sign_url" id="client_id" type="text" maxlength="800" />
        <div class="clear"></div>
        <input type="submit" value="sign_url"/> 
        </form> -->
    
    

ADMIN_FORM;
    }

    public function write($p) {
        if ($_POST['client_id'])
            $client_id = mysql_real_escape_string($_POST['client_id']);
        if ($_POST['sign_url'])
            $sign_url = mysql_real_escape_string($_POST['sign_url']);
        if ($client_id && $sign_url) {
            $created = time();
            $sql = "INSERT INTO sigantureRequestDB VALUES('$client_id','$sign_url','$created')";
            return mysql_query($sql);
        } else {
            return false;
        }
    }

    public function connect() {
        mysql_connect($this->host, $this->username, $this->password) or die("Could not connect. " . mysql_error());
        mysql_select_db($this->table) or die("Could not select database. " . mysql_error());

        return $this->buildDB();
    }

    private function buildDB() {
        $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS sigantureRequestDB (
client_id	VARCHAR(200),
sign_url	VARCHAR(800),
created		VARCHAR(100)
)
MySQL_QUERY;

        return mysql_query($sql);
    }

}

?>