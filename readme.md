# Laravel Module Structure

# Composer install

```javascript
{
    "repositories": [
	  {
	    "url": "https://github.com/MichaelMagomedov/structure",
	    "type": "git"
	  }
	],
	"require": {
	   "structure": "dev-master"
	},
}

```
# Add app.php
Remove laravel translition provider and add:
```javascript
 \Structure\Provider\TranslationServiceProvider::class,
 \Structure\Provider\StructureProvider::class
````
# Module config example 
```javascript                               

class Module extends BaseModule
{
    protected $config = [
        "name" => "test",
        "languages" => "resource/lang",
        "providers" => [
            TestServiceProvider::class
        ],
        "middlewares" => [
            "groups" => [
                "testGroup" => [
                    TestMiddleware::class
                ]
            ],
            "aliases" => [
                "test" => TestMiddleware::class
            ]
        ],
        "views" => "resource/view",
        "routes" => [
            "route/api.php"
        ],
        "repositories" => [
            TestRepository::class => TestRepositoryImpl::class
        ],
    ];
}
```
остальное смотреть в example
   

