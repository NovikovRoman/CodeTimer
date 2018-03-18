<?php

namespace CodeTimer;

class Block
{
    private $memory;
    private $time;
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
        $this->run();
    }

    public function getName()
    {
        return $this->name;
    }

    public function stop()
    {
        return $this->elapsedTime()->elapsedMemory();
    }

    public function asArrayShort()
    {
        return [
            'name' => $this->name,
            'time' => $this->time['durationFormat'],
            'memory' => $this->memory['durationFormat'],
        ];
    }

    public function asArray()
    {
        return [
            'name' => $this->name,
            'time' => $this->time,
            'memory' => $this->memory,
        ];
    }

    public function __toString()
    {
        $str = $this->name . ' - ';
        return $str . 'time: ' . $this->time['durationFormat'] . ', memory: ' . $this->memory['durationFormat'];
    }

    private function run()
    {
        $this->time = [
            'start' => gettimeofday(),
            'end' => null,
            'duration' => null,
            'durationFormat' => null,
        ];
        $this->memory = [
            'start' => memory_get_usage(true),
            'end' => null,
            'duration' => null,
            'durationFormat' => null,
        ];
        return $this;
    }

    private function elapsedMemory()
    {
        $this->memory['end'] = memory_get_usage(true);
        $this->memory['duration'] = $this->memory['end'] - $this->memory['start'];
        $this->memory['durationFormat'] = $this->humanBytes($this->memory['duration']);
        return $this;
    }

    private function elapsedTime()
    {
        $this->time['end'] = gettimeofday();
        $sec = ($this->time['end']['sec'] - $this->time['start']['sec']);
        $usec = ($this->time['end']['usec'] - $this->time['start']['usec']) / 1000000;
        $this->time['duration'] = $sec + $usec;
        $this->time['durationFormat'] = number_format($this->time['duration'], 12, '.', '') . ' sec';
        return $this;
    }

    public function humanBytes($size)
    {
        $filesizename = [
            ' B', ' KiB', ' MiB', ' GiB', ' TiB', ' PiB', ' EiB', ' ZiB', ' YiB'
        ];
        return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[(int)$i] : '0 B';
    }
}