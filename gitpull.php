<?php
$agent = $_SERVER['HTTP_USER_AGENT'];

$commands = array(
	'git pull origin master'
);

if (strpos($agent,'GitHub-Hookshot') !== false) {
	foreach($commands AS $command) {
		$tmp = shell_exec($command);
	}
	echo "complete";
} else {
	header('HTTP/1.0 403 Forbidden');
}
?>