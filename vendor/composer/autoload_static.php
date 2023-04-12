<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4a1b75d9305e5a6b8e8dc7c2dbc4f210
{
    public static $files = array (
        '486addd35896dc785c8725895ea6c4c9' => __DIR__ . '/../..' . '/config.php',
    );

    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Endroid\\QrCode\\' => 15,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'B' => 
        array (
            'BaconQrCode\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Endroid\\QrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/endroid/qr-code/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Group' => __DIR__ . '/../..' . '/Classes/Group.php',
        'MYSQLHandler' => __DIR__ . '/../..' . '/Classes/MYSQLHandler.php',
        'User' => __DIR__ . '/../..' . '/Classes/User.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4a1b75d9305e5a6b8e8dc7c2dbc4f210::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4a1b75d9305e5a6b8e8dc7c2dbc4f210::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4a1b75d9305e5a6b8e8dc7c2dbc4f210::$classMap;

        }, null, ClassLoader::class);
    }
}
