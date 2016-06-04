LazyPDO
=======
[![Total Downloads](https://img.shields.io/packagist/dt/f3ath/lazypdo.svg)](https://packagist.org/packages/f3ath/lazypdo)
[![Latest Stable Version](https://img.shields.io/packagist/v/f3ath/lazypdo.svg)](https://packagist.org/packages/f3ath/lazypdo)
[![Travis Build](https://travis-ci.org/f3ath/lazypdo.svg?branch=master)](https://travis-ci.org/f3ath/lazypdo)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/460a1668-b1bb-418d-ba5e-0f359b7f5a29.svg)](https://insight.sensiolabs.com/projects/460a1668-b1bb-418d-ba5e-0f359b7f5a29)

LazyPDO is a wrapper over PHP's standard PDO class. It postpones the instantiation
of the original PDO class until one is really needed. Also it can be (un)serialized.

The main goal of this class is to allow mocking of PDO instances in unit tests.

#Install
Via [composer](https://getcomposer.org):
`$ composer require "f3ath/lazypdo"`
