<?php

namespace colq2\BladeMjml;

use colq2\BladeMjml\Components\MjBody;
use colq2\BladeMjml\Components\MjColumn;
use colq2\BladeMjml\Components\MjDivider;
use colq2\BladeMjml\Components\MjHead;
use colq2\BladeMjml\Components\MjHeadAttributes;
use colq2\BladeMjml\Components\MjHeadBreakpoint;
use colq2\BladeMjml\Components\MjHeadFont;
use colq2\BladeMjml\Components\MjHeadPreview;
use colq2\BladeMjml\Components\MjHeadStyle;
use colq2\BladeMjml\Components\MjHeadTitle;
use colq2\BladeMjml\Components\Mjml;
use colq2\BladeMjml\Components\MjRaw;
use colq2\BladeMjml\Components\MjSection;
use colq2\BladeMjml\Components\MjText;
use colq2\BladeMjml\Helpers\OutlookConditionals;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
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

        $this->app->extend('view.engine.resolver', function ($resolver, $app) {
            $resolver->register('blade', function () use ($app) {
                $compiler = $app['blade.compiler'];

                return new PostProcessingCompilerEngine($compiler, $app['files']);
            });

            return $resolver;
        });
    }

    public function boot()
    {
        parent::boot();

        // Get all mjml components and get their names
        Blade::prepareStringsForCompilationUsing(function ($string) {
            // only preprocess if the string starts with <mjml
            if (! Str::startsWith($string, '<mjml')) {
                return $string;
            }

            $preprocessor = new BladeMjmlPreprocessor;

            $prepared = $preprocessor->preprocess($string);

            return $prepared;
        });

        PostProcessingCompilerEngine::postProcess('example', function ($content) {
            // Example: Remove HTML comments
            return OutlookConditionals::process($content);
        });

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
    }
}
