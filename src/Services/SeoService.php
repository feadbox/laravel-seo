<?php

namespace Feadbox\Seo\Services;

use Error;
use Feadbox\Seo\Exceptions\MissingPackageException;
use Illuminate\Support\HtmlString;
use ReflectionObject;
use ReflectionProperty;

class SeoService
{
    public $siteName;

    public $withSiteName = true;

    public $separator = '—';

    public $title;

    public $description;

    public $canonical;

    public $page;

    protected $langs = [];

    protected $images = [];

    public function __construct()
    {
        $this->siteName = config('seo.app.name');
    }

    public function __call($name, $arguments): self
    {
        if (array_key_exists($name, $this->publicProperties())) {
            $this->{$name} = $arguments[0];

            return $this;
        }

        throw new Error("Call to undefined method {$name}()");
    }

    public function lang(string $iso, string $url): self
    {
        $this->langs[$iso] = $url;

        return $this;
    }

    public function image(string $url): self
    {
        $this->images[] = $url;

        return $this;
    }

    public function useLang(): self
    {
        if (!function_exists('localize')) {
            throw new MissingPackageException('Please install "feadbox/laravel-localization" package for this method.');
        }

        foreach (localize()->supportedLocales() as $locale) {
            seo()->lang($locale, localize()->url($this->canonical, $locale));
        }

        return $this;
    }

    public function generate(): HtmlString
    {
        $this->prepare();

        $view = view('seo::layout', $this->toArray())->render();
        $view = preg_replace('/\s+/', ' ', $view);

        return new HtmlString($view);
    }

    public function toArray(): array
    {
        return array_merge($this->publicProperties(), [
            'langs' => $this->langs,
            'images' => $this->images,
        ]);
    }

    private function prepare(): void
    {
        if ($this->page > 1) {
            $this->title .= __(' - :page. Sayfa', ['page' => $this->page]);
        }

        if ($this->withSiteName && $this->siteName && $this->title) {
            $this->title = "{$this->title} {$this->separator} {$this->siteName}";
        }
    }

    private function publicProperties(): array
    {
        $properties = (new ReflectionObject($this))->getProperties(ReflectionProperty::IS_PUBLIC);

        return collect($properties)
            ->mapWithKeys(
                fn ($property) => [$property->name => $this->{$property->name}]
            )->toArray();
    }
}
