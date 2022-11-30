<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInite5cd3ea6e182d547590d0cf24f52b039
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInite5cd3ea6e182d547590d0cf24f52b039', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInite5cd3ea6e182d547590d0cf24f52b039', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInite5cd3ea6e182d547590d0cf24f52b039::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}