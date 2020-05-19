<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @Command
 */
class testCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('demo:command');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf Demo Command');
        //1.
        //$this->addArgument('name',InputArgument::REQUIRED,'名字');
        //$this->addArgument('age',InputArgument::OPTIONAL,'年龄',22);
        //$this->addOption('gender','gender', InputOption::VALUE_OPTIONAL,'性别');

	    //2.
        //$this->addOption('words','words', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,'数组');

	    //3.
    }

    public function handle()
    {
    	//1.
	    //## php bin/hyperf.php demo:command '看看' 11
    	//$name = $this->input->getArgument('name');
    	//$age = $this->input->getArgument('age');
    	//$gender = $this->input->getOption('gender');
        //$this->line(sprintf("你好： %s 先生",$name), 'info');
        //$this->line(sprintf("   年龄是： %s ",$age), 'info');
        //$this->line(sprintf("   性别是： %s ",$gender), 'info');

	    //2.
	    //## php bin/hyperf.php demo:command --words=dds --words=uus
        //$this->line(sprintf("   数组： %s ", implode('，', $this->input->getOption('words'))), 'info');

	    //3.
	    //$value = $this->output->ask('你选择哪个呢？','yes/no');
	    //$this->output->writeln($value);
	    //4.
	    //$val = $this->output->choice('你选择哪个ya？',[0=>'hehe','1'=>'xixi',2=>'haha']);
	    //$this->output->writeln($val);
	    //5.
	    //$val = $this->output->confirm('确定继续？',false);
	    //$this->output->writeln($val ? 'true' : 'false');

	    //6.
	    $this->output->progressStart(100);
	    for ($i=0; $i<20; $i++){
		    sleep(1);
	    	$this->output->progressAdvance(5);
	    }
	    $this->output->progressFinish();
	    $this->output->writeln('finish...');
    }
}
