# ZF2 & ExtJS5 example

This is an example application showing how to create a RESTful JSON API using PHP (Zend Framework 2) and ExtJS 5 as a frontend.

## Requirements

* PHP 5.3+
* Mysql 5.1+
* Vagrant 1.6+
* [Composer](http://getcomposer.org/) (manage dependencies)

## Deployment
1. Download VM using Vagrant:

    ```
    vagrant up
    ```

2. Create mysql database "userapi" (user/password - root) and deploy it from dump:

    ```
    /modeling/schema.sql
    ```

3. Install the dependencies:

    ```
    composer install
    ```

4. Use this address to access the result page:

    ```
    http://192.168.33.10/
    ``