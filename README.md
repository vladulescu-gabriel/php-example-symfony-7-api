### php-example-symfony-7-api

> [!CAUTION]
> 1. Use installation guide in order to got the project working
> 2. Keep in mind that this is a test-project of symfony 7, structure may not be the best
------
> [!NOTE]
> Installation guide

* MacOS: [brew](https://brew.sh/)
* Windows: [chocolatey](https://chocolatey.org/install)

Required Software:
* docker + docker-compose (`brew install docker` / `choco install docker-desktop`)
* make (Windows: `choco install make`, it is readily available on MacOS after installing XCode)

Steps after software install:
1. Run command: make composer/install
2. Add to hosts: local.api.symfony7.com (Windows: C:\Windows\System32\drivers\etc\hosts)
3. Run command: make project/start
------