<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony' => array(__DIR__.'/../vendor/symfony/src', __DIR__.'/../vendor/bundles'),
    'Sensio' => __DIR__.'/../vendor/bundles',
    'Doctrine\\Common' => __DIR__.'/../vendor/doctrine-common/lib',
    'Doctrine\\DBAL\\Migrations' => __DIR__.'/../vendor/doctrine-migrations/lib',
    'Doctrine\\DBAL' => __DIR__.'/../vendor/doctrine-dbal/lib',
    'Doctrine' => array(__DIR__.'/../vendor/doctrine/lib', __DIR__.'/../vendor/bundles'),
    'Monolog' => __DIR__.'/../vendor/monolog/src',
    'Assetic' => __DIR__.'/../vendor/assetic/src',
    'FOS' => __DIR__.'/../vendor/bundles',
    'Pheanstalk' => __DIR__.'/../vendor/pheanstalk/classes',
    'Leezy' => __DIR__.'/../vendor/bundles',
    'Buzz' => __DIR__.'/../vendor/buzz/lib',
    'Sensio' => __DIR__.'/../vendor/bundles',
    'JMS'              => __DIR__.'/../vendor/bundles',
    'Metadata'         => __DIR__.'/../vendor/metadata/src',
    'CG'               => __DIR__.'/../vendor/cg-library/src',
    'FOS\\Rest' => __DIR__.'/../vendor/fos',
));

$loader->registerPrefixes(array(
    'Twig_Extensions_' => __DIR__.'/../vendor/twig-extensions/lib',
    'Twig_' => __DIR__.'/../vendor/twig/lib',
    'Socket_' => __DIR__.'/../vendor/beanstalk/src',
    'GELF' => __DIR__.'/../vendor/gelf-php',
));

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $loader->registerPrefixFallbacks(array(__DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs'));
}

$loader->registerNamespaceFallbacks(array(
    __DIR__.'/../src',
));
$loader->register();

AnnotationRegistry::registerLoader(function($class) use ($loader) {
    $loader->loadClass($class);
    return class_exists($class, false);
});
AnnotationRegistry::registerFile(__DIR__.'/../vendor/doctrine/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

require __DIR__.'/../vendor/swiftmailer/lib/swift_required.php';

// AWS SDK needs a special autoloader
require_once __DIR__.'/../vendor/aws-sdk/sdk.class.php';
