<?php

namespace Structure\Provider;

use Illuminate\Translation\TranslationServiceProvider as LaravelServiceProvider;

class TranslationServiceProvider extends LaravelServiceProvider
{
    protected $defer = false;
}
