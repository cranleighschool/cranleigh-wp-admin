<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita618eaaf1eef7cbf72223e0b043e1312
{
    public static $files = array (
        '89ff252b349d4d088742a09c25f5dd74' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/plugin-update-checker.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FredBradley\\CranleighWPAdmin\\' => 29,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FredBradley\\CranleighWPAdmin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita618eaaf1eef7cbf72223e0b043e1312::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita618eaaf1eef7cbf72223e0b043e1312::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
