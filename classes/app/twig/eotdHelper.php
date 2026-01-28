<?php

namespace app\twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use \watrlabs\emojis;

class eotdHelper extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('eotd', function () {
                return emojis::getEmoji();
            }),
        ];
    }
}
