<?php

namespace app\twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use \localization\localization;

class twigLocalization extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('t', function ($key) {
                localization::init("en_US");
                return localization::get($key);
            }),
        ];
    }
}
