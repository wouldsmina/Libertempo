<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfd23b7dd905d561816f77d072cde6740
{
    public static $files = array (
        '6bc45d0537e6858fd179bdbc31d62c79' => __DIR__ . '/..' . '/raveren/kint/Kint.class.php',
        '75d4b1647cdbc77a59f72bcb74df0995' => __DIR__ . '/..' . '/spipu/html2pdf/html2pdf.class.php',
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr4 = ComposerStaticInitfd23b7dd905d561816f77d072cde6740::$fallbackDirsPsr4;

        }, null, ClassLoader::class);
    }
}