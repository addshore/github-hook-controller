<?php

namespace GithubHookController;

use Github\Client;

abstract class HookControllerBase {

	/**
	 * @var Client
	 */
	private $client;
	/**
	 * @var \Github\Api\Repo
	 */
	protected $repoApi;

	/**
	 * @param Client $githubClient
	 */
	public function __construct( $githubClient ) {
		$this->client = $githubClient;
		$this->repoApi = $this->client->api( 'repo' );
	}

	/**
	 * @param string $type
	 * @param string $user
	 * @param string $repo
	 *
	 * @return bool|int false or the id of the hook
	 */
	protected function getHookId( $type, $user, $repo ) {
		$hooks = $this->repoApi->hooks()->all( $user, $repo );
		foreach( $hooks as $hook ) {
			if( $hook['name'] === $type ) {
				return $hook['id'];
			}
		}
		return false;
	}

}