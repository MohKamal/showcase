# Showcase Micro Framework

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

### include

To include a view inside another, simply use @include tag
```html

<!-- Include footer to page -->
<body>
    @include("App/footer")
</body>
```

### Extend

Extend is used to call a layout page. for example, you have same nav and footer, so you create a page with nav and footer and html structure and you call it main.view.php

Every page you call gonna extend from the main view

### Attention

You have to put the @render() tag inside the main view in the position where you with the child view would display



```html
<!-- main.view.php -->
<body>
    <nav></nav>
    @render()
    <footer></footer>
</body>

```


```html
<!-- contact.view.php -->
@extend("App/main")
<body>
    <!-- You page Code -->
</body>
```
