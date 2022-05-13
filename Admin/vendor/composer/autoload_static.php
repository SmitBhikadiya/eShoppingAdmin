<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita2463dfbff51595f5e6381e261c48796
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita2463dfbff51595f5e6381e261c48796::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita2463dfbff51595f5e6381e261c48796::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita2463dfbff51595f5e6381e261c48796::$classMap;

        }, null, ClassLoader::class);
    }
}
