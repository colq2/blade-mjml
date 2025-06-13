# Blade Mjml

[![Latest Version on Packagist](https://img.shields.io/packagist/v/:vendor_slug/:package_slug.svg?style=flat-square)](https://packagist.org/packages/:vendor_slug/:package_slug)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/:vendor_slug/:package_slug/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/:vendor_slug/:package_slug/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/:vendor_slug/:package_slug.svg?style=flat-square)](https://packagist.org/packages/:vendor_slug/:package_slug)
<!--delete-->
---
This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use this template" button at the top of this repo to create a new repo with the contents of this skeleton.
2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files.
3. Have fun creating your package.
4. If you need help creating a package, consider picking up our <a href="https://laravelpackage.training">Laravel Package Training</a> video course.
---
<!--/delete-->

This package is a port of [mjml](https://mjml.io/) to laravel blade. The goal is to have a running mjml version purely in php and blade, without the need for node.

You can just use the original mjml xml as blade view.

```bladehtml
<!-- mjml-example.blade.php -->
<mjml>
    <mj-body>
        <mj-section>
            <mj-column>
                <mj-image width="100px" src="https://mjml.io/assets/img/logo-small.png"></mj-image>
                <mj-divider border-color="#F45E43"></mj-divider>
                <mj-text font-size="20px" color="#F45E43" font-family="helvetica">Hello World</mj-text>
            </mj-column>
        </mj-section>
    </mj-body>
</mjml>
```

Use this package to render the mjml:

```php
return view('mjml-example.blade.php');
```


## Limitations

* No support for raw components yet -> Dont know how to implement this yet, because we do not control the childs and cannot check if they are raw or not.
* Cannot extract font families, must use mj-font for this.
* mj-html-attributes not supported yet.

* mj-raw attribute `position="file-start"` is not supported yet.

## Open Issues

* [] Support for mj-attributes

## Good to know

The original mjml implementation works differently than the blade compiler. MJML renders recursively, which means that a parent component calls the render function of all its childern and can provide a context or wrap them.
The blade compiler works differently. First it compiles the blade view into a php file, then it "just" runs the php file. We cannot provide a context programmatically, because the blade compiler does not know about the context of the parent component.

(Blade do not really know that it is working with html. It does not care, it does not do any html analysis or anything like that)

This is the biggest challenge of this package. This is why we keep a context stack and a global context.

For example we need to wrap the child components of a column into a table, which in mjml is done in the mj-column component.
Also calculating the current width and providing it to the child components was a challenge.

Another challenge was to find out how many siblings a colum has. In the component we don't have any access to the parent html or whatsoever.
Now this package "precompiles" the mjml and sets the siblings as an attribute. 

The precompilation also changes <mj-*> tp <x-mj-*> so that the blade compiler can handle it correctly.


## Installation

You can install the package via composer:

```bash
composer require :vendor_slug/:package_slug
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag=":package_slug-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag=":package_slug-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag=":package_slug-views"
```

## Usage

```php
$variable = new VendorName\Skeleton();
echo $variable->echoPhrase('Hello, VendorName!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:author_name](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
