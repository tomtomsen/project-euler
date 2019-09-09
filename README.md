Project Euler Problems
======================

For details visit [Project Euler Website](https://projecteuler.net/).

Installation
------------

```shell
$ make shell
> ./tools/composer.phar install
> ./tools/phive.phar update
> wget -O ./tools/security-checker.phar https://get.sensiolabs.org/security-checker.phar && ln -s security-checker.phar ./tools/security-checker && chmod +x ./tools/security-checker.phar
```

Usage
-----

Generate a problem
```shell
$ ./bin/project-euler generate <problem-id>
```

Run a problem by selecting it
```shell
$ ./bin/project-euler run
```

Run a problem directly 
```shell
$ ./bin/project-euler run <problem-id>
```
