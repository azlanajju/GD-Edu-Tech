<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit036b74b89b8f7d2e62b95cc75f281fd3
{
    public static $files = array (
        '3109cb1a231dcd04bee1f9f620d46975' => __DIR__ . '/..' . '/paragonie/sodium_compat/autoload.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit036b74b89b8f7d2e62b95cc75f281fd3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit036b74b89b8f7d2e62b95cc75f281fd3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit036b74b89b8f7d2e62b95cc75f281fd3::$classMap;

        }, null, ClassLoader::class);
    }
}
