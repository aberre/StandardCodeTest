<?php
namespace VG\StandardCodeTestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
class InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('vg:install')
            ->setDescription('Install the app');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $varnishLogService = $container->get('standard_code_test.varnishlog');
        $varnishLogService->truncateLog();

        $varnishRawLog = $container->get('standard_code_test.dataservice')->call( $container->getParameter('varnish_log_url') );
        $varnishLogService->importDataFromLogFile($varnishRawLog);

        $output->writeln('<info>Temporary Varnish Log written to database</info>');

    }
}