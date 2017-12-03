<?php
$agent = $_SERVER['HTTP_USER_AGENT'];

$secretFile = __DIR__ . '/../../.gitpullsecretkey';
$fh = fopen($secretFile, 'r');
$secretKey = fread($fh, filesize($secretFile));
fclose($fh);

$commands = array(
	'git pull origin master'
);

if (strpos($agent,'GitHub-Hookshot') !== false) {
	foreach($commands AS $command) {
		$tmp = shell_exec($command);
	}
	echo "complete";
	echo $secretKey;
} else {
	header('HTTP/1.0 403 Forbidden');
}
?>