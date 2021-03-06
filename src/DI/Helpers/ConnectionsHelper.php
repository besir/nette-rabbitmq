<?php

declare(strict_types=1);

/**
 * @copyright   Copyright (c) 2017 gameeapp.com <hello@gameeapp.com>
 * @author      Pavel Janda <pavel@gameeapp.com>
 * @package     Gamee
 */

namespace Gamee\RabbitMQ\DI\Helpers;

use Gamee\RabbitMQ\Connection\ConnectionFactory;
use Gamee\RabbitMQ\Connection\ConnectionsDataBag;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;

final class ConnectionsHelper extends AbstractHelper
{

	/**
	 * @var array
	 */
	protected $defaults = [
		'host' => '127.0.0.1',
		'port' => '5672',
		'user' => 'guest',
		'password' => 'guest',
		'vhost' => '/'
	];


	public function setup(ContainerBuilder $builder, array $config = []): ServiceDefinition
	{
		$connectionsConfig = [];

		foreach ($config as $connectionName => $connectionData) {
			$connectionsConfig[$connectionName] = $this->extension->validateConfig(
				$this->getDefaults(),
				$connectionData
			);
		}

		$connectionsDataBag = $builder->addDefinition($this->extension->prefix('connectionsDataBag'))
			->setClass(ConnectionsDataBag::class)
			->setArguments([$connectionsConfig]);

		return $builder->addDefinition($this->extension->prefix('connectionFactory'))
			->setClass(ConnectionFactory::class)
			->setArguments([$connectionsDataBag]);
	}

}
