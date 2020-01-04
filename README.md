# php-Showcase-template
A micro mini php framework to make one page or no back-end web site, like a presentation with no models

<h2>Routes</h2>
<code>    
    $router->get('/path', function () {
        //Code to exectue
        return URL::Redirect('login');
        //Another
        HomeController::Home();

    });

    $router->post('/path',  function ($request) {
        HomeController::Contact($request);
    });
</code>
