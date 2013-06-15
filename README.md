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

### D) Configure the bundle

Add the following parameters to your security.yml or config.yml:

```yaml
// app/security.yml

ajax_auth:
    default_redirect_path     : _default # where to redirect after login
    always_use_default_path   : false
    user_registration_handler : registration.handler # see explanation bellow
```

Usage:
-----------------------------

### 1) Define your Registration Handler

You need to define a registration handler, which will be called when a user tries to connect with Gacebook or GooglePlus.

First, add a service in your services.yml:

```yaml
// YourBundle/Resources/config/services.yml
parameters:
    registration.handler.class: Namespace\YourBundle\Authentication\UserRegisterHandler

services:
    registration.handler:
        class: "%registration.handler.class%"
        parent: ajax_auth.user_registration.handler
```
Then, define your handler:

```php
// YourBundle/Authentication/UserRegisterHandler.php

use Smth\AjaxAuthBundle\Security\Authentication\UserRegistrationHandler;

class UserRegisterHandler extends UserRegistrationHandler
{
    /**
    * $publicUser - user received from Facebook/Google
    */
    public function handleUser($publicUser){
        /**
        * handle the user: 
        *   register or authenticate him (
        *       use 
        *           $this->authenticateUser(UserInterface $user);
        *       or
        *           %this->authenticationFailed(string $errorMessage);
        *   )
        */
    }
}

```

### 2) Configure the front-end part.

In your twig template, use:

```twig
{{ AjaxAuthScript({'facebook':'your_facebook_app_id', 'google':'your_google_app_id'}) }}
```

**Note:**

> ** If you don't want to use either of the applications, simply don't provide an app_id

> ** Your login form should have the following proprieties:
>   - id: #ajax-login
>   - username input's name: _username
>   - password input's name: _password
>   - facebook button id: #ajax-fb-btn
>   - google   button id: #ajax-g-btn

**TODO:**
> Implement remember me service