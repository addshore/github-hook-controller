<?php

/**
 * Repositories to add / alter the irc hook for
 */
$hookTargets = array(
	'addshore' => array(
		'wikitext-to-markdown',
		'DisableSpecialPages',
		'GoogleSiteVerification',
		'bin',
		'apc-gui',
		'random',
		'LabsDumpScanner',
		'github-hook-controller',
		'phergie-irc-plugin-react-wikidata',
	),
	'addwiki' => array(
		'mediawiki-datamodel',
		'mediawiki-api',
		'mediawiki-api-base',
		'wikibase-api',
		'addwiki.github.io',
	),
);

/**
 * Params for the irc hook
 */
$hook = array(
	'name' => 'irc',
	'active' => true,
	'config' => array(
		'server' => 'chat.freenode.org',
		'port' => '7000',
		'room' => '##add',
		'nick' => 'addGit',
		'ssl' => '1',
	),
	'events' => array(
		'push', 'pull_request', 'commit_comment', 'pull_request_review_comment'
	),
);

require_once __DIR__ . '/../vendor/autoload.php';

echo "Please generate a personal access token at https://github.com/settings/applications\n";
echo "Github Token:";
$token = stream_get_line(STDIN, 1024, "\n");

$client = new \Github\Client();
$client->authenticate( $token, null, \Github\Client::AUTH_HTTP_TOKEN );

$controller = new \GithubHookController\IrcHookController( $client );


foreach( $hookTargets as $user => $repos ) {
	foreach( $repos as $repo ) {
		$controller->setIrcHook( $hook, $user, $repo );
	}
}
