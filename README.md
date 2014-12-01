TalanDynamicFormBundle
======================
[![Build Status](https://travis-ci.org/NightFox7/DynamicFormBundle.svg?branch=master)](https://travis-ci.org/NightFox7/DynamicFormBundle)

A Dynamic Form Builder for Symfony2 using [kelp404/angular-form-builder](https://github.com/kelp404/angular-form-builder).

##Frameworks
1. [AngularJS 1.2](http://angularjs.org/) 
2. [jQuery](http://jquery.com/) 
3. [Bootstrap 3](http://getbootstrap.com/)
4. [Angular-validator](https://github.com/kelp404/angular-validator)
5. [jQuery Datatable](https://www.datatables.net)
6. [Angular Datatable](http://l-lin.github.io/angular-datatables)

## Installation

### Get the bundle
 

Add the following lines in your composer.json:

    {
        "require": {
            "iphp/filestore-bundle" : "dev-master" 
        }
    }


### Initialize the bundle

To start using the bundle, register the bundle in your application's kernel class:

``` php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
         new Talan\Bundle\AcmeBundle\TalanAcmeBundle(),
    );
)
```
### Create the bundle's tables
Execute the following commands under the project's main folder:
```
php app/console doctrine:schema:update --force
php app/console doctrine:fixture:load --fixtures=vendor/talan/dynamic-form/Talan/Bundle/DynamicFormBundle/DataFixtures/ORM --append
```
This will create 10 tables prefixed with 'talan_' in your database schema:

-
