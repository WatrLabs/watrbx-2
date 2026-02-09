<?php

namespace app;

use PHPUnit\Framework\TestCase;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Logger\QuietLogger;
use ScssPhp\ScssPhp\OutputStyle;

class cssHelper {

    // compiles and returns compiled scss
    static function serveCSS(string $fileDir) {

        if(file_exists($fileDir)){
            $compiler = new Compiler();
            $compiler->setLogger(new QuietLogger());
            $compiler->setOutputStyle(OutputStyle::COMPRESSED);
            $compiler->setSourceMap(Compiler::SOURCE_MAP_NONE);
            $result = $compiler->compileFile($fileDir);

            return $result->getCss();
        } else {
            throw(new \ErrorException("Failed to find scss file!"));
        } 
    }

}