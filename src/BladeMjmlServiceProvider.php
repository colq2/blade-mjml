<?php

namespace colq2\BladeMjml;

use colq2\BladeMjml\Components\MjAccordion;
use colq2\BladeMjml\Components\MjAccordionElement;
use colq2\BladeMjml\Components\MjAccordionText;
use colq2\BladeMjml\Components\MjAccordionTitle;
use colq2\BladeMjml\Components\MjBody;
use colq2\BladeMjml\Components\MjButton;
use colq2\BladeMjml\Components\MjCarousel;
use colq2\BladeMjml\Components\MjCarouselImage;
use colq2\BladeMjml\Components\MjColumn;
use colq2\BladeMjml\Components\MjDivider;
use colq2\BladeMjml\Components\MjGroup;
use colq2\BladeMjml\Components\MjHead;
use colq2\BladeMjml\Components\MjHeadAttributes;
use colq2\BladeMjml\Components\MjHeadBreakpoint;
use colq2\BladeMjml\Components\MjHeadFont;
use colq2\BladeMjml\Components\MjHeadPreview;
use colq2\BladeMjml\Components\MjHeadStyle;
use colq2\BladeMjml\Components\MjHeadTitle;
use colq2\BladeMjml\Components\MjHero;
use colq2\BladeMjml\Components\MjImage;
use colq2\BladeMjml\Components\Mjml;
use colq2\BladeMjml\Components\MjNavbar;
use colq2\BladeMjml\Components\MjNavbarLink;
use colq2\BladeMjml\Components\MjRaw;
use colq2\BladeMjml\Components\MjSection;
use colq2\BladeMjml\Components\MjSocial;
use colq2\BladeMjml\Components\MjSocialElement;
use colq2\BladeMjml\Components\MjSpacer;
use colq2\BladeMjml\Components\MjTable;
use colq2\BladeMjml\Components\MjText;
use colq2\BladeMjml\Components\MjWrapper;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BladeMjmlServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('blade-mjml')
            ->hasConfigFile();
        //            ->hasViewComponents('blade-mjml', [
        //                Mjml::class
        //            ]);
    }

    public function registeringPackage()
    {
        parent::registeringPackage();

        View::addExtension('mjml.blade.php', 'blade-mjml');

        $this->app->extend('view.engine.resolver', function ($resolver, $app) {
            $resolver->register('blade-mjml', function () use ($app) {
                $app = Container::getInstance();

                $compiler = new BladeMjmlCompilerEngine(
                    $app->make('blade.compiler'),
                    $app->make('files'),
                );

                // @phpstan-ignore-next-line
                $app->terminating(static function () use ($compiler) {
                    $compiler->forgetCompiledOrNotExpired();
                });

                return $compiler;
            });

            return $resolver;
        });
    }

    public function boot()
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blade-mjml');

        Blade::componentNamespace('colq2\\BladeMjml\\Views\\Components', 'blade-mjml');

        Blade::component(Mjml::class);
        // head components
        Blade::component(MjHead::class, 'mj-head');
        Blade::component(MjHeadAttributes::class, 'mj-attributes');
        Blade::component(MjHeadBreakpoint::class, 'mj-breakpoint');
        Blade::component(MjHeadFont::class, 'mj-font');
        Blade::component(MjHeadPreview::class, 'mj-preview');
        Blade::component(MjHeadStyle::class, 'mj-style');
        Blade::component(MjHeadTitle::class, 'mj-title');

        // body components
        Blade::component(MjBody::class, 'mj-body');
        Blade::component(MjSection::class, 'mj-section');
        Blade::component(MjColumn::class, 'mj-column');
        Blade::component(MjText::class, 'mj-text');
        Blade::component(MjRaw::class, 'mj-raw');
        Blade::component(MjDivider::class, 'mj-divider');
        Blade::component(MjButton::class, 'mj-button');
        Blade::component(MjHero::class, 'mj-hero');
        Blade::component(MjSpacer::class, 'mj-spacer');
        Blade::component(MjWrapper::class, 'mj-wrapper');
        Blade::component(MjImage::class, 'mj-image');
        Blade::component(MjSocial::class, 'mj-social');
        Blade::component(MjSocialElement::class, 'mj-social-element');
        Blade::component(MjTable::class, 'mj-table');
        Blade::component(MjCarousel::class, 'mj-carousel');
        Blade::component(MjCarouselImage::class, 'mj-carousel-image');
        Blade::component(MjNavbar::class, 'mj-navbar');
        Blade::component(MjNavbarLink::class, 'mj-navbar-link');
        Blade::component(MjGroup::class, 'mj-group');
        Blade::component(MjAccordion::class, 'mj-accordion');
        Blade::component(MjAccordionElement::class, 'mj-accordion-element');
        Blade::component(MjAccordionTitle::class, 'mj-accordion-title');
        Blade::component(MjAccordionText::class, 'mj-accordion-text');
    }
}
