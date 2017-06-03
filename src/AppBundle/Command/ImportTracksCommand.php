<?php

namespace AppBundle\Command;

use AppBundle\Entity\Album;
use AppBundle\Entity\Artist;
use AppBundle\Entity\Track;
use Mhor\MediaInfo\MediaInfo;
use Mhor\MediaInfo\Type\General;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ImportTracksCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:import-tracks')
            ->setDescription('Imports tracks.')
            ->addArgument('dir', InputArgument::REQUIRED, 'Directory where file will be imported')
            ->addOption('formats', null, InputOption::VALUE_REQUIRED + InputOption::VALUE_IS_ARRAY, 'Accepted formats', ['flac', 'mp3', 'wav', 'ogg'])
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');

        $fs = new Filesystem();
        if (!$fs->exists($dir)) {
            throw new \Exception('Directory doesn\'t exist');
        }

        $finder = new Finder();
        $finder->files()->in($dir);
        $formats = $input->getOption('formats');
        foreach ($formats as $format) {
            $finder->name('*.'.$format);
        }

        $artistRepository = $this->getContainer()->get('app.repository.artist');
        $albumRepository = $this->getContainer()->get('app.repository.album');
        $trackRepository = $this->getContainer()->get('app.repository.track');

        $slugify = $this->getContainer()->get('cocur_slugify');
        $mediainfo = new MediaInfo();
        $foundedFiles = 0;
        $addedFiles = 0;
        foreach ($finder as $file) {
            /** @var General $information */
            $information = $mediainfo->getInfo($file->getRealPath())->getGeneral();

            ++$foundedFiles;
            $artistSlug = $slugify->slugify($information->get('performer'));
            $artist = $artistRepository->findArtistBySlug($artistSlug);
            if (null === $artist) {
                $artist = (new Artist())
                    ->setName($information->get('performer'))
                    ->setSlug($artistSlug)
                ;

                $artistRepository->update($artist);
            }

            $albumSlug = $slugify->slugify($information->get('album'));
            $album = $albumRepository->findAlbumBySlug($albumSlug, $artistSlug);
            if (null === $album) {
                $album = (new Album())
                    ->setName($information->get('album'))
                    ->setYear($information->get('recorded_date'))
                    ->setArtist($artist)
                    ->setSlug($albumSlug)
                ;
                $albumRepository->update($album);
            }

            $trackArtistSlug = $slugify->slugify($information->get('performer'));
            $trackArtist = $artistRepository->findArtistBySlug($trackArtistSlug);
            if (null === $trackArtist) {
                $trackArtist = (new Artist())
                    ->setName($information->get('performer'))
                    ->setSlug($trackArtistSlug)
                ;
                $artistRepository->update($trackArtist);
            }

            $trackSlug = $slugify->slugify($information->get('track_name'));
            $track = $trackRepository->findTrackBySlug($trackSlug, $trackArtistSlug, $albumSlug);
            if (null === $track) {
                $track = (new Track())
                    ->setNumber($information->get('track_name_position'))
                    ->setName($information->get('track_name'))
                    ->setDuration($information->get('duration')->getMilliseconds())
                    ->setArtist($trackArtist)
                    ->setAlbum($album)
                    ->setSlug($trackSlug)
                ;
                $trackRepository->update($track);
                ++$addedFiles;
            }
        }

        $output->writeln('Added files: '.$addedFiles);
        $output->writeln('Founded files: '.$foundedFiles);
        $output->writeln('Ignored files: '.($foundedFiles-$addedFiles));
    }
}