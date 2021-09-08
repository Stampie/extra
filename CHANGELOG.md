## Unreleased

## 1.2.0

### Added

* Added support for PHP 8

## 1.1.0

### Added

* Added support for Symfony 5

### Changed

* Changed the parent class of the `MessageEvent` to `Symfony\Contracts\EventDispatcher\Event` when using `symfony/event-dispatcher` 4.3+
* Support the new `symfony/event-dispatcher` 4.3+ signature

### Removed

* Removed support for PHP <7.2

## 1.0.0

* Renamed the composer package to `stampie/extra`
* Bumped the Stampie min version to 1.0
* Added support for Symfony 4
* Removed `DecoratorMailer`.
* Made the log level configurable in the LoggerListener

## 0.3.0

* Switch to PSR-3 for the logger listener rather than the deprecated Symfony logger
* Add support for Symfony 3

## 0.2.0 (2014-07-18)

* Bumped the minimal Stampie version to 0.10
* Added the support of MetadataAwareInterface for impersonated messages
* Added the support of AttachmentsAwareInterface for impersonated messages

## 0.1.0 (2013-01-10)

Initial release of the library.
