<?php

namespace App\Utils;

class View
{
    /**
     * default view vars
     *
     * @var array
     */
    private static $vars = [];

    /**
     * define the initial data of the class
     *
     * @param array $vars
     * @return void
     */
    public static function init(array $vars = []): void
    {
        self::$vars = $vars;
    }

    /**
     * returns the content of a view
     * 
     * @param  string $view
     * @return string
     */
    private static function getContentView(string $view): string
    {
        $file = __DIR__."/../../resources/view/".$view.".html";
        return file_exists($file) ? file_get_contents($file) : "";
    }

    /**
     * returns the rendered content of a view
     * 
     * @param  string $view
     * @param  array $vars (string/numeric)
     * @return string
     */
    public static function render(string $view, array $vars = []): string
    {
        //CONTENT VIEW
        $contentView = self::getContentView($view);

        //MERGE THE LAYOUT VARS
        $vars = array_merge(self::$vars, $vars);

        //VARS ARRAY KEYS
        $keys = array_keys($vars);
        $keys = array_map(function($item) {
            return "{{".$item."}}";
        }, $keys);

        //RETURNS THE RENDERED CONTENT
        return str_replace($keys, array_values($vars), $contentView);
    }
}
