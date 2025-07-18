# Blade Mjml

[![Latest Version on Packagist](https://img.shields.io/packagist/v/colq2/blade-mjml.svg?style=flat-square)](https://packagist.org/packages/colq2/blade-mjml)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/colq2/blade-mjml/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/colq2/blade-mjml/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/colq2/blade-mjml/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/colq2/blade-mjml/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/colq2/blade-mjml.svg?style=flat-square)](https://packagist.org/packages/colq2/blade-mjml)

This package is a port of [mjml](https://mjml.io/) to laravel blade. The goal is to have a running mjml version purely in php and blade, without the need for node.

You can just use the original mjml xml as blade view.

```bladehtml
<!-- resources/views/mail/mjml-example.blade.php -->
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

You can now use this view in your mails:

```php
public function content(): Content
{
    return new Content(
        view: 'mail.mjml-example',
    );
}
```


## Limitations

* mj-include is not supported. Use `@include` instead.

* mj-html-attributes not supported yet.

* mj-raw attribute `position="file-start"` is not supported yet.

* Inline mj-style not working yet.

* mj-accordion does not handle missing children. You need to always provide mj-accordion-text and mj-accordion-title.

## Component overview

Head Components:
* [x] mj-attributes
* [x] mj-breakpoint
* [x] mj-font
* [ ] mj-html-attributes
* [x] mj-preview
* [x] mj-style
* [x] mj-title

Body Components:
* [x] mj-accordion
* [x] mj-button
* [x] mj-carousel
* [x] mj-column
* [x] mj-divider
* [x] mj-group
* [x] mj-hero
* [x] mj-image
* [x] mj-navbar
* [x] mj-raw
* [x] mj-section
* [x] mj-social
* [x] mj-spacer
* [x] mj-table
* [x] mj-text
* [x] mj-wrapper

## Good to know

The original mjml implementation works differently than the blade compiler. MJML renders recursively, which means that a parent component calls the render function of all its childern and can provide a context or wrap them.
The blade compiler works differently. First it compiles the blade view into a php file, then it "just" runs the php file. We cannot provide a context programmatically, because the blade compiler does not know about the context of the parent component.

(Blade do not really know that it is working with html. It does not care, it does not do any html analysis or anything like that. It is just string manipulation.)

This is the biggest challenge of this package. This is why we keep a context stack and a global context.

For example, we need to wrap the child components of a column into a table, which in mjml is done in the mj-column component.

Another challenge was to find out how many siblings a colum has. In the component we don't have any access to the parent html or whatsoever.
Now this package "precompiles" the mjml and sets the siblings as an attribute. 

The precompilation also changes <mj-*> tp <x-mj-*> so that the blade compiler can handle it correctly.

## Installation

Install the package via composer:

```bash
composer require colq2/blade-mjml
```

## Usage

Just put mjml template into your blade files and use the view for sending emails.

Relevant documentation for laravel and mjml:
* [Sending Emails in Laravel](https://laravel.com/docs/12.x/mail#configuring-the-view)
* [MJML Documentation](https://mjml.io/documentation/)

```bladehtml
// resources/views/mail/mjml-example.blade.php
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

And use the view in your mail class:

```php
public function content(): Content
{
    return new Content(
        view: 'mail.mjml-example',
    );
}
```

Or render it directly as a view:

```php
Route::get('/mjml-example', function () {
    return view('mail.mjml-example');
});
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [colq2](https://github.com/colq2)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
