<?php

interface Volume {
    public function increaseVolume();

    public function decreaseVolume();
}

interface Playable {
    public function play();

    public function stop();
}

class MusicPlayer implements Volume, Playable {
    private $volume;
    private $isPlaying;

    public function __construct() {}

    public function increaseVolume() {
        $this->volume++;
    }

    public function decreaseVolume() {
        $this->volume--;
    }

    public function play() {
        $this->isPlaying = true;
    }

    public function stop() {
        $this->isPlaying = false;
    }

    public function getStatus() {
        return $this->isPlaying ? "playing" : "stopped";
    }

    public function getVolume() {
        return $this->volume;
    }
}

$musicPlayer = new MusicPlayer();
$musicPlayer->play();
$musicPlayer->increaseVolume();
$musicPlayer->increaseVolume();
$musicPlayer->increaseVolume();
echo $musicPlayer->getVolume();
echo "\n";
echo $musicPlayer->getStatus();