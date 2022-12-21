<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit04f564d588c9a0cab6ad5107dcc66187
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit04f564d588c9a0cab6ad5107dcc66187::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit04f564d588c9a0cab6ad5107dcc66187::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit04f564d588c9a0cab6ad5107dcc66187::$classMap;

        }, null, ClassLoader::class);
    }
}
