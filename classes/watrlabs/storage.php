<?php

namespace watrlabs;

class storage {
    
    // checks if file exists
    static function doesFileExist(string $fileDir){
        return file_exists(dirname(__DIR__) . '/storage/' . $fileDir); // best line of code ever.
    }

    // gets file from storage
    static function getFile(string $fileDir){
        if(this::doesFileExist($fileDir)){
            return file_get_contents(dirname(__DIR__) . '/storage/' . $fileDir);
        }
    }

    // this stores a file
    static function storeFile(string $fileDir, $data, $flags){
        if(this::doesFileExist($fileDir)){
            return file_put_contents(dirname(__DIR__) . '/storage/' . $fileDir, $data, $flags);
        }
    }

    /*
        TODO: maybe make this a wrapper and detect if S3/R2 is enabled in .env and use that instead of this
        for now since its a wip I'll just do file storage but thats for the future
        
        People really wanted file storage in the old site
    */

}