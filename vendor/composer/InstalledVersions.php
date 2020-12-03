<?php

namespace Composer;

use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-main',
    'version' => 'dev-main',
    'aliases' => 
    array (
    ),
    'reference' => '2a675783fbdec82496c8d0a67f791fff5b36ac95',
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => 'dev-main',
      'version' => 'dev-main',
      'aliases' => 
      array (
      ),
      'reference' => '2a675783fbdec82496c8d0a67f791fff5b36ac95',
    ),
    'heroku/heroku-buildpack-php' => 
    array (
      'pretty_version' => 'v185',
      'version' => '185.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f9f96a05c4b5bd552594bb789413d8665ba77c64',
    ),
    'monolog/monolog' => 
    array (
      'pretty_version' => '1.25.5',
      'version' => '1.25.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '1817faadd1846cd08be9a49e905dc68823bc38c0',
    ),
    'pimple/pimple' => 
    array (
      'pretty_version' => 'v3.3.1',
      'version' => '3.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '21e45061c3429b1e06233475cc0e1f6fc774d5b0',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
    ),
    'psr/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0.0',
        1 => '1.0',
      ),
    ),
    'silex/api' => 
    array (
      'replaced' => 
      array (
        0 => 'v2.3.0',
      ),
    ),
    'silex/providers' => 
    array (
      'replaced' => 
      array (
        0 => 'v2.3.0',
      ),
    ),
    'silex/silex' => 
    array (
      'pretty_version' => 'v2.3.0',
      'version' => '2.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6bc31c1b8c4ef614a7115320fd2d3b958032f131',
    ),
    'symfony/debug' => 
    array (
      'pretty_version' => 'v4.4.17',
      'version' => '4.4.17.0',
      'aliases' => 
      array (
      ),
      'reference' => '65fe7b49868378319b82da3035fb30801b931c47',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '5fa56b4074d1ae755beb55617ddafe6f5d78f665',
    ),
    'symfony/error-handler' => 
    array (
      'pretty_version' => 'v4.4.17',
      'version' => '4.4.17.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b0887cf8fc692eef2a4cf11cee3c5f5eb93fcfdf',
    ),
    'symfony/event-dispatcher' => 
    array (
      'pretty_version' => 'v4.4.17',
      'version' => '4.4.17.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f029d6f21eac61ab23198e7aca40e7638e8c8924',
    ),
    'symfony/event-dispatcher-contracts' => 
    array (
      'pretty_version' => 'v1.1.9',
      'version' => '1.1.9.0',
      'aliases' => 
      array (
      ),
      'reference' => '84e23fdcd2517bf37aecbd16967e83f0caee25a7',
    ),
    'symfony/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.1',
      ),
    ),
    'symfony/http-client-contracts' => 
    array (
      'pretty_version' => 'v2.3.1',
      'version' => '2.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '41db680a15018f9c1d4b23516059633ce280ca33',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v4.4.17',
      'version' => '4.4.17.0',
      'aliases' => 
      array (
      ),
      'reference' => '9eeb37ec0ff3049c782ca67041648e28ddd75a94',
    ),
    'symfony/http-kernel' => 
    array (
      'pretty_version' => 'v4.4.17',
      'version' => '4.4.17.0',
      'aliases' => 
      array (
      ),
      'reference' => '9f5605ee05406d8afa40dc4f2954c6a61de3a984',
    ),
    'symfony/mime' => 
    array (
      'pretty_version' => 'v5.2.0',
      'version' => '5.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '05f667e8fa029568964fd3bec6bc17765b853cc5',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.20.0',
      'version' => '1.20.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f4ba089a5b6366e453971d3aad5fe8e897b37f41',
    ),
    'symfony/polyfill-intl-idn' => 
    array (
      'pretty_version' => 'v1.20.0',
      'version' => '1.20.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '3b75acd829741c768bc8b1f84eb33265e7cc5117',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.20.0',
      'version' => '1.20.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '727d1096295d807c309fb01a851577302394c897',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.20.0',
      'version' => '1.20.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '39d483bdf39be819deabf04ec872eb0b2410b531',
    ),
    'symfony/polyfill-php72' => 
    array (
      'pretty_version' => 'v1.20.0',
      'version' => '1.20.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cede45fcdfabdd6043b3592e83678e42ec69e930',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.20.0',
      'version' => '1.20.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8ff431c517be11c78c48a39a66d37431e26a6bed',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.20.0',
      'version' => '1.20.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e70aa8b064c5b72d3df2abd5ab1e90464ad009de',
    ),
    'symfony/routing' => 
    array (
      'pretty_version' => 'v4.4.17',
      'version' => '4.4.17.0',
      'aliases' => 
      array (
      ),
      'reference' => '08712c5dd5041c03e997e13892f45884faccd868',
    ),
    'symfony/twig-bridge' => 
    array (
      'pretty_version' => 'v3.4.47',
      'version' => '3.4.47.0',
      'aliases' => 
      array (
      ),
      'reference' => '090d19d6f1ea5b9e1d79f372785aa5e5c9cd4042',
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v5.2.0',
      'version' => '5.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '173a79c462b1c81e1fa26129f71e41333d846b26',
    ),
    'twig/twig' => 
    array (
      'pretty_version' => 'v2.14.1',
      'version' => '2.14.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '5eb9ac5dfdd20c3f59495c22841adc5da980d312',
    ),
  ),
);







public static function getInstalledPackages()
{
return array_keys(self::$installed['versions']);
}









public static function isInstalled($packageName)
{
return isset(self::$installed['versions'][$packageName]);
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

$ranges = array();
if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}





public static function getVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['version'])) {
return null;
}

return self::$installed['versions'][$packageName]['version'];
}





public static function getPrettyVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return self::$installed['versions'][$packageName]['pretty_version'];
}





public static function getReference($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['reference'])) {
return null;
}

return self::$installed['versions'][$packageName]['reference'];
}





public static function getRootPackage()
{
return self::$installed['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
}
}
