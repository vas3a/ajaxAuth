Ajax Authentication Symfony Bundle
=============================

Instalation:
-----------------------------

### A) Add AjaxAuthBundle to your composer.json

```yaml
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/vas3a/ajaxAuth.git"
        }
    ],
}
```

### B) Enable the bundle

Enable the bundle in the kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Smth\AjaxAuthBundle\AjaxAuthBundle(),
    );
}
```

### C) Import the routing

Import the `redirect.xml` routing file in your own routing file.

```yaml
# app/config/routing.yml
ajax_auth:
    resource: "@AjaxAuthBundle/Resources/config/routing.yml"
    prefix:   /connect
```

**Note:**

> To prevent strange issues, this route should be imported before your custom ones.


Usage:
-----------------------------