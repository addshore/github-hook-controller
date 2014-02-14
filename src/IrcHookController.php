<?php

namespace GithubHookController;

use Github\Exception\ExceptionInterface;

class IrcHookController extends HookControllerBase {

	/**
	 * @param array $hook
	 * @param string $user for example addshore
	 * @param string $repo for example github-irchook-controller
	 */
	public function setIrcHook( $hook, $user, $repo ) {
		$id = $this->getHookId( 'irc', $user, $repo );
		try{
			if( !$id ) {
				$this->repoApi->hooks()->create( $user, $repo, $hook );
				echo "Created new IRC hook for " . $user . '/' . $repo . "\n";
			} else {
				$this->repoApi->hooks()->update( $user, $repo, $id, $hook );
				echo "Updated IRC hook for " . $user . '/' . $repo . "\n";
			}
		}
		catch( ExceptionInterface $e ) {
			echo "Failed to update IRC hook: " . $e->getMessage() . "\n";
		}
	}

}