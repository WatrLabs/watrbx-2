<?php

namespace app;

use PHPUnit\Framework\TestCase;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Logger\QuietLogger;

class cssHelper {
    static function compileCss($fileDir) {

        if(file_exists($fileDir)){
            $compiler = new Compiler();
            $compiler->setLogger(new QuietLogger());
            $compiler->setSourceMap(Compiler::SOURCE_MAP_INLINE);
            $result = $compiler->compileFile($fileDir);

            return $result->getCss();
        } else {
            throw(new ErrorException("Failed to find scss file!"));
        }

        
    }
}