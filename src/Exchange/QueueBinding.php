<?php

declare(strict_types=1);

/**
 * @copyright   Copyright (c) 2017 gameeapp.com <hello@gameeapp.com>
 * @author      Pavel Janda <pavel@gameeapp.com>
 * @package     Gamee
 */

namespace Gamee\RabbitMQ\Exchange;

use Gamee\RabbitMQ\Queue\Queue;

final class QueueBinding
{

	/**
	 * @var Queue
	 */
	private $queue;

	/**
	 * @var string
	 */
	private $routingKey;

	/**
	 * @var bool
	 */
	private $noWait;

	/**
	 * @var array
	 */
	private $arguments;


	public function __construct(
		Queue $queue,
		string $routingKey,
		bool $noWait,
		array $arguments
	) {
		$this->queue = $queue;
		$this->routingKey = $routingKey;
		$this->noWait = $noWait;
		$this->arguments = $arguments;
	}


	public function getQueue(): Queue
	{
		return $this->queue;
	}


	public function getRoutingKey(): string
	{
		return $this->routingKey;
	}

}
