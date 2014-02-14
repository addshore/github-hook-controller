<?php

namespace GithubHookController;

use Github\Client;

class IrcHookController {

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @param Client $githubClient
	 */
	public function __construct( $githubClient ) {
		$this->client = $githubClient;
	}

	/**
	 * @param array $hook
	 * @param string $user for example addshore
	 * @param string $repo for example github-irchook-controller
	 */
	public function setIrcHook( $hook, $user, $repo ) {
		/** @var \Github\Api\Repo $repos */
		$repos = $this->client->api( 'repo' );

		$hooks = $repos->hooks()->all( $user, $repo );
		$id = $this->findCurrentIrcHookId( $hooks );
		if( !$id ){
			$repos->hooks()->create( $user, $repo, $hook );
		} else {
			$repos->hooks()->update( $user, $repo, $id, $hook );
		}
	}

	/**
	 * @param array $hooks
	 *
	 * @return bool|int false or the id of the hook
	 */
	private function findCurrentIrcHookId( array $hooks ) {
		foreach( $hooks as $hook ) {
			if( $hook['name'] === 'irc' ) {
				return $hook['id'];
			}
		}
		return false;
	}

} 