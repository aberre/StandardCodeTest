<?php
/**
 * Created by PhpStorm.
 * User: andersberre
 * Date: 10.02.2016
 * Time: 00.07
 */

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

    }
}