<?php

namespace Fathom;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class ImageToolCommand extends Command
{
    public function configure()
    {
        $this->setName("thumb")
            ->setDescription("This command create thumbnail")
            ->addArgument('service', InputArgument::REQUIRED, 'Service name')
            ->addArgument('file', InputArgument::REQUIRED, 'Source filename')
            ->addArgument('fileoutput', InputArgument::REQUIRED, 'Output filename')
            ->addArgument('width', InputArgument::REQUIRED, 'Width')
            ->addArgument('height', InputArgument::REQUIRED, 'Height');
    }

    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $output->writeln('ImageTool');

        $services = [
            'imagemagick' => ImageTool::SERVICE_IMAGE_MAGICK,
            'tinypng' => ImageTool::SERVICE_TINY_PNG,
            'immaga' => ImageTool::SERVICE_IMMAGA,
        ];

        $services_options = [
            'imagemagick' => [],
            'tinypng' => ['key' => API_KEY_TINYPNG],
            'immaga' => ['key' => API_KEY_IMMAGA, 'secret' => API_SECRET_IMMAGA],
        ];

        $service = $input->getArgument('service');

        if (!isset($services[ $service ]))
        {
            $output->writeln('Wrong service. Use: imagemagick, tinypng, immaga');
        }

        $imagetool = new ImageTool($services[ $service ], $services_options[ $service ]);

        $imagetool->setSource($input->getArgument('file'));

        $fileoutput = $input->getArgument('fileoutput');

        $imagetool->makeThumb($fileoutput, $input->getArgument('width'), $input->getArgument('height'));

        $output->writeln('File "' . $fileoutput . '" created.');
    }
}