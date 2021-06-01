<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9a7926040b9a68ad743f44d567413b70
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Wamania\\Snowball\\' => 17,
        ),
        'S' => 
        array (
            'Skyeng\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Wamania\\Snowball\\' => 
        array (
            0 => __DIR__ . '/..' . '/wamania/php-stemmer/src',
        ),
        'Skyeng\\' => 
        array (
            0 => __DIR__ . '/..' . '/skyeng/php-lemmatizer/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'N' => 
        array (
            'NlpTools\\' => 
            array (
                0 => __DIR__ . '/..' . '/nlp-tools/nlp-tools/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9a7926040b9a68ad743f44d567413b70::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9a7926040b9a68ad743f44d567413b70::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9a7926040b9a68ad743f44d567413b70::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}