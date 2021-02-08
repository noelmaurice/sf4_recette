<?php


namespace App\Object;


use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Yaml\Yaml;

class YamlEncoder implements EncoderInterface, DecoderInterface
{
    public function encode($data, $format, array $context = [])
    {
        return Yaml::dump($data);
    }

    public function supportsEncoding($format)
    {
        return 'yaml' === $format;
    }

    public function decode($data, $format, array $context = [])
    {
        return Yaml::parse($data);
    }

    public function supportsDecoding($format)
    {
        return 'yaml' === $format;
    }
}