<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit79e2c271acf48ffb67e9aafd1d0f8762
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Explorin\\Tebot\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Explorin\\Tebot\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit79e2c271acf48ffb67e9aafd1d0f8762::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit79e2c271acf48ffb67e9aafd1d0f8762::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit79e2c271acf48ffb67e9aafd1d0f8762::$classMap;

        }, null, ClassLoader::class);
    }
}