<?php

declare(strict_types=1);

/**
 * @copyright   Copyright (c) 2017 gameeapp.com <hello@gameeapp.com>
 * @author      Pavel Janda <pavel@gameeapp.com>
 * @package     Gamee
 */

namespace Gamee\RabbitMQ\Console\Command;

use Gamee\RabbitMQ\Consumer\ConsumerFactory;
use Gamee\RabbitMQ\Consumer\ConsumersDataBag;
use Gamee\RabbitMQ\Consumer\Exception\ConsumerFactoryException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class StaticConsumerCommand extends AbstractConsumerCommand
{

	const COMMAND_NAME = 'rabbitmq:staticConsumer';


	protected function configure(): void
	{
		$this->setName(self::COMMAND_NAME);
		$this->setDescription('Run a RabbitMQ consumer but consume just particular amount of messages');

		$this->addArgument('consumerName', InputArgument::REQUIRED, 'Name of the consumer');
		$this->addArgument('amountOfMessages', InputArgument::REQUIRED, 'Amount of messages to consume');
	}


	/**
	 * @throws \InvalidArgumentException
	 */
	protected function execute(InputInterface $input, OutputInterface $output): void
	{
		$consumerName = (string) $input->getArgument('consumerName');
		$amountOfMessages = (int) $input->getArgument('amountOfMessages');

		$this->validateConsumerName($consumerName);
		$this->validateAmountOfMessages($amountOfMessages);

		$consumer = $this->consumerFactory->getConsumer($consumerName);
		$consumer->consumeSpecifiedAmountOfMessages($amountOfMessages);
	}


	/**
	 * @throws \InvalidArgumentException
	 */
	private function validateAmountOfMessages(int $amountOfMessages): void
	{
		if (!$amountOfMessages) {
			throw new \InvalidArgumentException(
				'Parameter [amountOfMessages] has to be greater then 0'
			);
		}
	}

}
