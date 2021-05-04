<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0a6c25092de34cc38991cc694921f8fd
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DiDom\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DiDom\\' => 
        array (
            0 => __DIR__ . '/..' . '/imangazaliev/didom/src/DiDom',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0a6c25092de34cc38991cc694921f8fd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0a6c25092de34cc38991cc694921f8fd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
