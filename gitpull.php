<?php
    /**
     * GIT DEPLOYMENT SCRIPT
     *
     * Used for automatically deploying websites via github securely, more deets here:
     *
     *      https://gist.github.com/limzykenneth/baef1b190c68970d50e1
     */

    // The header information which will be verified
    $agent=$_SERVER['HTTP_USER_AGENT'];
    $signature=$_SERVER['HTTP_X_HUB_SIGNATURE'];
    $body=@file_get_contents('php://input');

    // The commands
    $commands = array(
        'git pull origin master'
    );

    base64_encode($agent);
    base64_encode($signature);

    if (strpos($agent,'GitHub-Hookshot') !== false){
		echo $GLOBALS['body'];
		echo "------------";
		echo $signature . '\n\n';
		echo verify_request();
		
        if (hash_equals($signature, verify_request())){
            // Run the commands
            foreach($commands AS $command){
                // Run it
                $tmp = shell_exec($command);
            }
            echo "Deploy successful.";
        }else{
            header('HTTP/1.1 403 Forbidden');
            echo "Invalid request 1.";
        }
    }else{
        header('HTTP/1.1 403 Forbidden');
        echo "Invalid request 2.";
    }

    // Generate the hash verification with the request body and the key stored in your .htaccess file
    function verify_request(){
        $message = $GLOBALS['body'];
        $key     = getSecretKey();
		$hash    = hash_hmac("sha1", $message, $key);
		$hash 	 = "sha1=".$hash;
		return $hash;
    } 
	
	function getSecretKey() {
		$secretFile = __DIR__ . '/../../.gitpullsecretkey';
		$fh = fopen($secretFile, 'r');
		$secretKey = fread($fh, filesize($secretFile));
		fclose($fh);
		return $secretKey;
	}

?>