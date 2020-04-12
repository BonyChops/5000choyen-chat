<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab5b17c4060cb4e3f210b7654632d1fc
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Abraham\\TwitterOAuth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Abraham\\TwitterOAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/abraham/twitteroauth/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab5b17c4060cb4e3f210b7654632d1fc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab5b17c4060cb4e3f210b7654632d1fc::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
