LazyPDO
=======
[![Total Downloads](https://img.shields.io/packagist/dt/f3ath/lazypdo.svg)](https://packagist.org/packages/f3ath/lazypdo)
[![Latest Stable Version](https://img.shields.io/packagist/v/f3ath/lazypdo.svg)](https://packagist.org/packages/f3ath/lazypdo)
[![Travis Build](https://travis-ci.org/f3ath/lazypdo.svg?branch=master)](https://travis-ci.org/f3ath/lazypdo)


LazyPDO is a wrapper over PHP's standard PDO class. It postpones instantiating
original PDO class until one is really needed. Also it can be (un)serialized.

The main goal of this class is to allow mocking of PDO instances in unit tests.
