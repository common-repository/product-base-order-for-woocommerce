<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita925fbb9d23b0a81a96ff5da023efe08
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPRealizer\\ProductBaseOrderWC\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPRealizer\\ProductBaseOrderWC\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'WPRealizer\\ProductBaseOrderWC\\Admin\\Admin' => __DIR__ . '/../..' . '/includes/Admin/Admin.php',
        'WPRealizer\\ProductBaseOrderWC\\Admin\\Menus' => __DIR__ . '/../..' . '/includes/Admin/Menus.php',
        'WPRealizer\\ProductBaseOrderWC\\Admin\\Settings' => __DIR__ . '/../..' . '/includes/Admin/Settings.php',
        'WPRealizer\\ProductBaseOrderWC\\Admin\\SettingsFields' => __DIR__ . '/../..' . '/includes/Admin/SettingsFields.php',
        'WPRealizer\\ProductBaseOrderWC\\Assets' => __DIR__ . '/../..' . '/includes/Assets.php',
        'WPRealizer\\ProductBaseOrderWC\\Install\\Installer' => __DIR__ . '/../..' . '/includes/Install/Installer.php',
        'WPRealizer\\ProductBaseOrderWC\\ProductBaseOrder' => __DIR__ . '/../..' . '/includes/ProductBaseOrder.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita925fbb9d23b0a81a96ff5da023efe08::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita925fbb9d23b0a81a96ff5da023efe08::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita925fbb9d23b0a81a96ff5da023efe08::$classMap;

        }, null, ClassLoader::class);
    }
}
