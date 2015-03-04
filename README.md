TalanDynamicFormBundle
======================
[![Build Status](https://travis-ci.org/TalanTunisie/DynamicFormBundle.svg?branch=master)](https://travis-ci.org/NightFox7/DynamicFormBundle)
[![Code Climate](https://codeclimate.com/github/NightFox7/DynamicFormBundle/badges/gpa.svg)](https://codeclimate.com/github/NightFox7/DynamicFormBundle)

A Dynamic Form Builder for Symfony2 using [kelp404/angular-form-builder](https://github.com/kelp404/angular-form-builder).

##Frameworks
1. [AngularJS 1.2](http://angularjs.org/)
2. [jQuery](http://jquery.com/)
3. [Bootstrap 3](http://getbootstrap.com/)
4. [Angular-validator](https://github.com/kelp404/angular-validator)
5. [jQuery Datatable](https://www.datatables.net)
6. [Angular Datatable](http://l-lin.github.io/angular-datatables)
7. [Angular Form Builder](https://github.com/kelp404/angular-form-builder)

## Installation

### Get the bundle


Add the following lines in your composer.json:
``` json
// composer.json
{
    "require": {
        "talan/dynamic-form" : "dev-master"
    }
}
```

### Initialize the bundle

To start using the bundle, register the bundle in your application's kernel class:

``` php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Talan\Bundle\DynamicFormBundle\TalanDynamicFormBundle(),
    );
)
```
### Create the bundle's tables
Execute the following commands under the project's main folder:
```
$ php app/console doctrine:schema:update --force
$ php app/console doctrine:fixture:load --fixtures=vendor/talan/dynamic-form/Talan/Bundle/DynamicFormBundle/DataFixtures/ORM --append
```
This will create 8 tables prefixed with "*talan_*" in your database schema:

- **talan_form**: Stores the forms created by the Back-Office.
- **talan_field_type**: Contains the different field types supported by the bundle.
- **talan_field**: Stores the fields associated to every created form.
- **talan_value**: Stores the common information related to the values inserted by the form users
- **talan_string_value**: Stores the values of the input text fields.
- **talan_text_value**: Stores the values of the textarea fields.
- **talan_integer_value**: Stores the values of the select and radio fields.
- **talan_array_value**: Stores the values of the checkbox fields.

### Import TalanDynamicFormBundle routing files
TalanDynamicFormBundle comes with default controllers and views that uses the developed services to offer the Back and Front Office functionnalities.
To activate the required pages you simply need to import the bundle's routing file:

``` yml
# app/config/routing.yml
talan_dynamic_form:
    resource: "@TalanDynamicFormBundle/Resources/config/routing.yml"
    prefix:   /
```

You may of course add a prefix of your choice.

If you like to add specific behaviors to the controllers or change the displayed pages,
you simply extends this bundle and make your own implementations of the controllers or the twigs of this bundle.

#### Override the default layout.html.twig
The layout file of this bundle imports the javascript dependencies from various links.
Therefore, we highly recommande that you download the required frameworks mentioned above,
override the layout file and use the assetics to include the downloaded frameworks.

The easiest way to override a bundle's template is to simply place a new one in your app/Resources folder.
To override the layout template located at Resources/views/layout.html.twig in the TalanDynamicFormBundle directory,
you would place your new layout template at app/Resources/TalanDynamicFormBundle/views/layout.html.twig

The following Twig template file is an example of a layout file that might be used to override the one provided by the bundle.

``` html+jinja
{% extends 'AcmeDemoBundle::layout.html.twig' %}

{% block title %}Acme Demo Application{% endblock %}

{% block content %}
    {% block talan_dynamic_form_content %}{% endblock %}
{% endblock %}
```

The main thing to note in this template is the block named talan_dynamic_form_content.
This is the block where the content from each of the different bundle's actions will be displayed,
so you must make sure to include this block in the layout file you will use to override the default one.

### Add Value Owner Providers
When a user of the application submit the values of a certain form created by this bundle, these values should be attached somehow to that specific user.
However, this link between the submitted values and the user depends on the nature of the application.
Therefore, it should be up to the developer and the Back-office to specify the way to attach these elements.

This bundle provides the above feature by introducing the *ValueOwnerProviderInterface* and abstract implementation *AbstractOwnerProvider*. 

The *ValueOwnerProviderInterface* requires the implementation of 3 methods which are *getValueOwner()* , *getOwnerListTemplate()* and *getValueOwnerList($formId)*. And we added the *AbstractOwnerProvider* Class to provide a default owner template.

So by implementing th interface or extending the abstract class then injecting the service with the required tag,
the developer should be able to specify how the submitted values and the user could be linked to each other.

TalanDynamicFormBundle comes with 2 pre-implemented classes of the *ValueOwnerProviderInterface*.
They are *AbstractUserValueProvider* and *SessionValueProvider* which is declared as a service.

Here is the *AbstractUserValueProvider* Class:
``` php
class AbstractUserValueProvider extends AbstractValueOwnerProvider
{
    protected $security;
    protected $em;

    public function __construct(EntityManager $em, SecurityContext $security)
    {
        $this->security = $security;
        $this->em = $em;
    }

    /**
     * (non-PHPdoc)
     * @see \Talan\Bundle\DynamicFormBundle\Service\ValueOwnerProviderInterface::getValueOwner()
     */
    public function getValueOwner()
    {
        if (!$this->security) {
            throw new \LogicException(
              'The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->security->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }

    public function getOwnerListTemplate()
    {
        return 'TalanDynamicFormBundle:OwnerList:connectedUser.html.twig';
    }
}
```
As you can see, here we implemented the *getValueOwner()* and we injected the *entity manager* and the *security* service in order to get the connected user.

To activate the user value provider, you need to add the configuration below to your services.yml.

``` yml
# src/Demo/Bundle/DemoBundle/Resources/config/services.yml
services:
    talan_dynamic_form.user_value_provider:
        class: "Talan\Bundle\DynamicFormBundle\Service\Impl\UserValueProvider"
        arguments: ["@doctrine.orm.entity_manager","@security.context"]
        tags:
            - {name: talan_dynamic_form.value_owner_provider, alias: "Connected User Provider"}
```

Note that we injected the *@doctrine.orm.entity_manager* and *@security* as arguments of the *UserValueProvider* and we tagged the service with **talan_dynamic_form.value_owner_provider** tag.
Tagging this service is very important as it allows the bundle to recognize this class as a ValueOwnerProvider.
As for the alias, it is the label that will be shown to the back-office to choose from when creating a Form.
You should implement the *getValueOwnerList()* and *getOwnerListTemplate()* methods in the *UserValueProvider* service so that you can have your list and your view according to your needs.
