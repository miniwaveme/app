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
            ->setName('app:import-track')
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

        $mediainfo = new MediaInfo();
        $foundedFiles = 0;
        $addedFiles = 0;
        foreach ($finder as $file) {
            /** @var General $information */
            $information = $mediainfo->getInfo($file->getRealPath())->getGeneral();

            ++$foundedFiles;
            $artistSlug = $information->get('performer'); // FIXME make this as slug
            $artist = $artistRepository->findArtistBySlug($artistSlug);
            if (null === $artist) {
                $artist = (new Artist())
                    ->setName($information->get('performer'))
                ;
                $artistRepository->update($artist);
            }

            $albumSlug = $information->get('album'); // FIXME transform this to slug
            $album = $albumRepository->findAlbumBySlug($albumSlug, $artistSlug);
            if (null === $album) {
                $album = (new Album())
                    ->setName($information->get('album'))
                    ->setYear($information->get('recorded_date'))
                    ->setArtist($artist)
                ;
                $albumRepository->update($album);
            }

            $trackArtistSlug = $information->get('performer'); // FIXME transform this to slug
            $trackArtist = $artistRepository->findArtistBySlug($trackArtistSlug);
            if (null === $trackArtist) {
                $trackArtist = (new Artist())
                    ->setName($information->get('performer'))
                ;
                $artistRepository->update($trackArtist);
            }

            $trackSlug = $information->get('track_name'); // FIXME transform this to slug
            $track = $trackRepository->findTrackBySlug($trackSlug, $trackArtistSlug, $albumSlug);
            if (null === $track) {
                $track = (new Track())
                    ->setNumber($information->get('track_name_position'))
                    ->setName($information->get('track_name'))
                    ->setDuration($information->get('duration')->getDuration())
                    ->setArtist($trackArtist)
                    ->setAlbum($album)
                ;
                $trackRepository->update($track);
                ++$addedFiles;
            }
        }

        $output->writeln('Added files'.$addedFiles);
        $output->writeln('Founded files'.$foundedFiles);
        $output->writeln('Ignored files'.$foundedFiles-$addedFiles);
    }
}