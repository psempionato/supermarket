<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6226570cc1e840330f30b6f388a759ba
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6226570cc1e840330f30b6f388a759ba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6226570cc1e840330f30b6f388a759ba::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6226570cc1e840330f30b6f388a759ba::$classMap;

        }, null, ClassLoader::class);
    }
}
