# php-Showcase-template
A micro mini php framework to make one page or no back-end web site, like a presentation with no models

## Routes
```php  
    $router->get('/path', function () {
        /* Code to execute */
        return URL::Redirect('login');
        /* Another */
        HomeController::Home();
    });

    $router->post('/path',  function ($request) {
        HomeController::Contact($request);
    });
```

## Views

Every view is in the Views folder, you can create a subfolders and add your views files in there. Example : 
Views 
|   Home
    |   Welcome.view.php
|   Contact
    |   Contact.view.php
    |   About.view.php

### Attention

Your views files need to end with .view.php, so they can be found, if not, you will get a 404 status

```html
<!-- Adding resources url to image -->
<img src="@{{Assets}}/images/logo.png" class="img-fluid" alt="logo"/>
<!-- Adding Base url to a link tag -->
<a href="@{{Base}}/Contact">Contact-Us</a>
```
