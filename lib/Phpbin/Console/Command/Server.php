<?php

namespace Phpbin\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class Server extends Command
{
    const DEFAULT_ADDRESS = '127.0.0.1';
    const DEFAULT_PORT = 8000;

    protected function configure()
    {
        $this
            ->setName('server:start')
            ->setDescription('Starts a local web server')
            ->addArgument(
                'address',
                InputArgument::OPTIONAL,
                sprintf('What ip address should the server listen on? (defaults to %s)', self::DEFAULT_ADDRESS)
            )
            ->addArgument(
                'port',
                InputArgument::OPTIONAL,
                sprintf('What TCP port should the server listen on? (defaults to %d)', self::DEFAULT_PORT)
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $address = $input->getArgument('address');
        if (empty($address)) {
            $address = self::DEFAULT_ADDRESS;
        }

        $port = intval($input->getArgument('port'));
        if (empty($port)) {
            $port = self::DEFAULT_PORT;
        }

        $container = $this->getApplication()->getContainer();
        $web_root = $container->getParameter('www_root_dir');

        $output->writeln("<fg=green>" . str_repeat('-', 50));
        $output->writeln(sprintf("  Starting HTTP Server on %s:%d", $address, $port));
        $output->writeln(str_repeat('-', 50) . "</fg=green>");
        $output->writeln("");

        $cmd = sprintf('DEBUG=1 php -S %s:%d -t "%s"', $address, $port, $web_root);

        $process = new Process($cmd);
        $process->setTimeout(0);

        $process->run(function ($type, $buffer) use($output) {
            $output->writeln(trim($buffer));
        });
    }
}