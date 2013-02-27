LazyPDO
=======

LazyPDO is a wrapper over PHP's standard PDO class. It postpones instantiating
original PDO class until one is really needed. Also it can be (un)serialized.

The main goal of this class is to allow you to mock PDO instances in your unit tests.
