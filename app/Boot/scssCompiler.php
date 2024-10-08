<?php

if (ENV === 'development' && COMPILE === TRUE)
{
    $compiler = new ScssPhp\ScssPhp\Compiler();
    
    $compiler->setImportPaths(COMPILE_FROM);
    $scss = file_get_contents(COMPILE_FROM . '/' . COMPILATIONS_FILE_FROM);
    $css = $compiler->compileString($scss)->getCss();
    
    if (MINIFY) $css = minify_css($css);
    
    file_put_contents(COMPILE_TO . '/' . COMPILED_FILE_TO, $css);
}