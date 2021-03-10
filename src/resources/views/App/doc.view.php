<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Showcase - Simple and powerful</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Showcase documentation for an easy use">
    <meta name="author" content="MOURCHID Mohamed Kamal">    
    <link rel="shortcut icon" href="@{{images}}favicon.ico"> 
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome JS-->
    <script defer src="@{{Assets}}/assets/fontawesome/js/all.min.js"></script>
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.2/styles/atom-one-dark.min.css">

    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="@{{Assets}}/assets/css/theme.css">

</head> 

<body class="docs-page">    
    <header class="header fixed-top">	    
        <div class="branding docs-branding">
            <div class="container-fluid position-relative py-2">
                <div class="docs-logo-wrapper">
					<button id="docs-sidebar-toggler" class="docs-sidebar-toggler docs-sidebar-visible mr-2 d-xl-none" type="button">
	                    <span></span>
	                    <span></span>
	                    <span></span>
	                </button>
	                <div class="site-logo"><a class="navbar-brand" href="/"><img class="logo-icon mr-2" src="@{{Assets}}assets/images/coderdocs-logo.svg" alt="logo"><span class="logo-text">Showcase<span class="text-alt">Docs</span></span></a></div>    
                </div><!--//docs-logo-wrapper-->
	            <div class="docs-top-utilities d-flex justify-content-end align-items-center">
	                <div class="top-search-box d-none d-lg-flex">
		                <form class="search-form">
				            <input type="text" placeholder="Search the docs..." name="search" class="form-control search-input">
				            <button type="submit" class="btn search-btn" value="Search"><i class="fas fa-search"></i></button>
				        </form>
	                </div>
	
					<ul class="social-list list-inline mx-md-3 mx-lg-5 mb-0 d-none d-lg-flex">
						<li class="list-inline-item"><a href="https://github.com/MohKamal/php-Showcase-template"><i class="fab fa-github fa-fw"></i></a></li>
			            <li class="list-inline-item"><a href="https://twitter.com/MOURCHIDKamal"><i class="fab fa-twitter fa-fw"></i></a></li>
		                <li class="list-inline-item"><a href="#"><i class="fab fa-slack fa-fw"></i></a></li>
		                <li class="list-inline-item"><a href="#"><i class="fab fa-product-hunt fa-fw"></i></a></li>
		            </ul><!--//social-list-->
		            <a href="https://github.com/MohKamal/php-Showcase-template" class="btn btn-primary d-none d-lg-flex">Download</a>
	            </div><!--//docs-top-utilities-->
            </div><!--//container-->
        </div><!--//branding-->
    </header><!--//header-->
    
    <div class="docs-wrapper">
	    <div id="docs-sidebar" class="docs-sidebar">
		    <div class="top-search-box d-lg-none p-3">
                <form class="search-form">
		            <input type="text" placeholder="Search the docs..." name="search" class="form-control search-input">
		            <button type="submit" class="btn search-btn" value="Search"><i class="fas fa-search"></i></button>
		        </form>
            </div>
		    <nav id="docs-nav" class="docs-nav navbar">
			    <ul class="section-items list-unstyled nav flex-column pb-3">
				    <li class="nav-item section-title"><a class="nav-link scrollto active" href="#section-1"><span class="theme-icon-holder mr-2"><i class="fas fa-map-signs"></i></span>Introduction</a></li>
				    <li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-2"><span class="theme-icon-holder mr-2"><i class="fas fa-arrow-down"></i></span>Installation</a></li>
				    <li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-3"><span class="theme-icon-holder mr-2"><i class="fas fa-box"></i></span>Routing</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-3-1">Routes</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-3-2">Response</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-3-3">Json resource</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-3-4">URL</a></li>
				    <li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-4"><span class="theme-icon-holder mr-2"><i class="fas fa-cogs"></i></span>Database</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-4-0">Migration</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-4-1">Models</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-4-2">Controllers</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-4-3">Queries</a></li>
				    <li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-5"><span class="theme-icon-holder mr-2"><i class="fas fa-tools"></i></span>Security</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-5-1">Authentication</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-5-2">CSRF Guard</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-5-3">Validator</a></li>
				    <li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-6"><span class="theme-icon-holder mr-2"><i class="fas fa-laptop-code"></i></span>Views</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-6-1">Functions inside views</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-6-2">Variables from Controllers to View</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-6-3">Styles & Javascript & other Files</a></li>
				    <li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-7"><span class="theme-icon-holder mr-2"><i class="fas fa-laptop-code"></i></span>Storage</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-7-1">Files, folders and download</a></li>
				    <li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-8"><span class="theme-icon-holder mr-2"><i class="fas fa-tablet-alt"></i></span>Debug</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-8-1">File</a></li>
				    <li class="nav-item"><a class="nav-link scrollto" href="#item-8-2">Console</a></li>
				    <li class="nav-item section-title mt-3"><a class="nav-link scrollto" href="#section-9"><span class="theme-icon-holder mr-2"><i class="fas fa-book-reader"></i></span>Run It!</a></li>
			    </ul>

		    </nav><!--//docs-nav-->
	    </div><!--//docs-sidebar-->
	    <div class="docs-content">
		    <div class="container">
			    <article class="docs-article" id="section-1">
				    <header class="docs-header">
					    <h1 class="docs-heading">Introduction <span class="docs-time">Last updated: 08-01-2021</span></h1>
					    <section class="docs-intro">
						    <p>The Showcase was created when i was looking to create a simple web page, with no complex back-end. And also i need to be light, and easy to edit and customize.</p>
						    <p>So, i did only used the Native php, because, all other frameworks are big and complex, need time to setup and run.</p>
						    <p>After that, i started creating this framework and i call it: Showcase ! Simple</p>
						    <p>In this page, you will have all the components of Showcase, for an easy and fast use.</p>
						</section><!--//docs-intro-->
				    </header>
			    </article>
			    
			    <article class="docs-article" id="section-2">
				    <header class="docs-header">
					    <h1 class="docs-heading">Installation</h1>
					    <section class="docs-intro">
						    <p>To use and install Showcase, Go to <a href="https://github.com/MohKamal/php-Showcase-template">Github</a> and download the project</p>
						    <p>Move the files from showcase folder to your custom folder and start the magic</p>
				    </header>
			    </article><!--//docs-article-->
			    
			    
			    <article class="docs-article" id="section-3">
				    <header class="docs-header">
					    <h1 class="docs-heading">Routing</h1>
					    <section class="docs-intro">
						    <p>The routing system used in showcase is simple, in this section, will learn how to create routes, and how to responde to request.</p>
						</section><!--//docs-intro-->
				    </header>
				     <section class="docs-section" id="item-3-1">
						<h2 class="section-heading">Routes</h2>
						<p>For now, Showcase support two methods, GET and POST.</p>
                        <p>To create a route, go to web file in route folder, and add new folder with method you need.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
$router->get('/path', function () {
    /* Code to execute */
    return $this->response()->redirect('login');
    /* Another */
    return HomeController::Home();
});

$router->post('/path',  function ($request) {
    return HomeController::Contact($request);
});
                        </code></pre>
						</div><!--//docs-code-block-->
					</section><!--//section-->
					
					<section class="docs-section" id="item-3-2">
						<h2 class="section-heading">Response</h2>
						<p>The response object is used inside controllers to return a proper response to a request. It support returning: a view, redirect to an url, json or a http code (some with html page).</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Return the welcome view
*/
static function Index(){
    return self::response()->view('App/main');
}
                        </code></pre>
                        </div><!--//docs-code-block-->
						<h4>Response View</h4>
						<p>To return a view, use view response</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Return the welcome view
*/
static function Index(){
    return self::response()->view('App/main');
}
                        </code></pre>
                        </div><!--//docs-code-block-->
						<h4>Response Redirect</h4>
						<p>To redirect a user to an url, use a redirect response</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Redirect to contact
*/
static function Index(){
    return self::response()->redirect('/contact-us');
}
                        </code></pre>
                        </div><!--//docs-code-block-->
						<p>You can redirect with a message using the same function</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Redirect to contact
*/
static function Index(){
    return self::response()->redirect('/contact-us', 'please fill all inputs', 'error'); // there is 4 types : info, error, warning and success
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <div class="callout-block callout-block-info">
                            
                            <div class="content">
                                <h4 class="callout-title">
	                                <span class="callout-icon-holder mr-1">
		                                <i class="fas fa-info-circle"></i>
		                            </span><!--//icon-holder-->
	                                Note
	                            </h4>
                                <p>there are 4 types of messages to return : info, error, warning and success</p>
                            </div><!--//content-->
                        </div><!--//callout-block-->
						<p>if you want to redirect the user to the last url, use back function, it take a message and message type only</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Redirect to contact
*/
static function Index(){
    return self::response()->back('please fill all inputs', 'error'); // there is 4 types : info, error, warning and success
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Response codes and error pages</h4>
						<p>To return codes and error pages use :</p>
						<ul>
						    <li><strong class="mr-1">404 :</strong> <code>response()->notFound()</code></li>
						    <li><strong class="mr-1">405 :</strong> <code>response()->notAllowed()</code></li>
						    <li><strong class="mr-1">200 :</strong> <code>response()->OK() //no page is returned</code></li>
						    <li><strong class="mr-1">403 :</strong> <code>response()->unauthorized()</code></li>
						    <li><strong class="mr-1">500 :</strong> <code>response()->internal()</code></li>
						</ul>
                        <h4>Response Download</h4>
						<p>To download a file, use the function download</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Download file
*/
static function Index(){
    $file = "/path/to/file";

    return self::response()->download($file);
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Response Json</h4>
						<p>To return any object as json response, use response json, it take the data as first parametre, and a status code as optionnal parametre, by default it's set to 200.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Redirect to contact
*/
static function Index(){
    $data = DB::factory()->model('User')->select()->where('active', 1)->get();

    return self::response()->json($data, 200);
}
                        </code></pre>
                        </div><!--//docs-code-block-->
						<p>To custumize the models return json, use the Json Resource object.</p>
					</section><!--//section-->
					
					<section class="docs-section" id="item-3-3">
						<h2 class="section-heading">Json resource</h2>
                        <p>When return a model as json, the hidden properties aslo are send out there, to prevent that from happening, you can use JsonResource object.</p>
                        <p>To create one, call the make:jsonresource command :</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
php showcase make:jsonresource resource_Name
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <div class="callout-block callout-block-info">
                            
                            <div class="content">
                                <h4 class="callout-title">
	                                <span class="callout-icon-holder mr-1">
		                                <i class="fas fa-info-circle"></i>
		                            </span><!--//icon-holder-->
	                                Note
	                            </h4>
                                <p>The new file is saved under app/JsonResources.</p>
                            </div><!--//content-->
                        </div><!--//callout-block-->
                        <p>And then, in the handle function, specify the data returned, or leave it blank, only the database columns will be returned.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\HTTP\Resources\JsonResource;
class UserResource extends JsonResource{       

    /**
        * Init the resource with model
        * @return json
        */
    public function __construct($obj){
        JsonResource::__construct($obj);
    }

    /**
        * Set the properties to return
        * @return array
        */
    function handle(){
        return [
            'Identification' => $this->id,
            'user_email' => $this->email,
            'parent_id' => "er15cc52",
        ];
    }
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>Use the new Json Resource in a controller like this: </p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\JsonResources\UserResource;

class HomeController extends BaseController{
    static function Index(){
        $user = DB::factory()->model('User')->select()->where('id', 5)->first();
        return self::response()->json(new UserResource($user));
    }
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>This will return json like: </p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="json hljs">
{
    "Identification":"5",
    "user_email":"email@gmail.com",
    "parent_id":"er15cc52"
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>To get only the values without the keys, you can use the withoutKeys() function : </p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\JsonResources\UserResource;

class HomeController extends BaseController{
    static function Index(){
        $user = DB::factory()->model('User')->select()->where('id', 5)->first();
        $json = new UserResource($user);
        return self::response()->json($json->withoutKeys());
    }
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>This will return json like: </p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="json hljs">
{
    "5",
    "email@gmail.com",
    "er15cc52"
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Json Resource for array</h4>
                        <p>To return an array of object as json, mapped datan you use the static function array of JsonResource.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\JsonResources\UserResource;

class HomeController extends BaseController{
    static function Index(){
        $users = DB::factory()->model('User')->select()->limit(15)->get();
        return self::response()->json(UserResource::array($users));
    }
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>This will return json like: </p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="json hljs">
[
    {
        "Identification":"1",
        "user_email":"email@gmail.com",
        "parent_id":"er15cc52"
    },
    {
        "Identification":"2",
        "user_email":"another@gmail.com",
        "parent_id":"er15cc52"
    },
    {
        "Identification":"3",
        "user_email":"rtrtrtrt@email.com",
        "parent_id":"er15cc52"
    },
    {
        "Identification":"7",
        "user_email":"jao@gmail.com",
        "parent_id":"er15cc52"
    }
]
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>To get only the values without the keys, you can use the boolean parametre in array() function : </p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
                            use \Showcase\JsonResources\UserResource;

class HomeController extends BaseController{
    static function Index(){
        $users = DB::factory()->model('User')->select()->limit(15)->get();
        return self::response()->json(UserResource::array($users, false));
    }
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>This will return json like: </p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="json hljs">
[
    {
        "1",
        "email@gmail.com",
        "er15cc52"
    },
    {
        "2",
        "another@gmail.com",
        "er15cc52"
    },
    {
        "3",
        "rtrtrtrt@email.com",
        "er15cc52"
    },
    {
        "7",
        "jao@gmail.com",
        "er15cc52"
    }
]
                        </code></pre>
                        </div><!--//docs-code-block-->
                    </section><!--//section-->
                    					
					<section class="docs-section" id="item-3-4">
						<h2 class="section-heading">URL</h2>
                        <p>URL object regroup most of the http functions, used in views, responses and more.</p>
                        <p>In here we will see the function of the URL object</p>
                        <ul>
						    <li><strong class="mr-1">redirectWithMessage($url, $message, $message_type) :</strong> <code>Redirect to a page with a message, there is four message types : info, success, warning and error </code></li>
						    <li><strong class="mr-1">redirect($url, $permanent) :</strong> <code>Redirect to an url, by default its not permanent, its set to false, but you can't changes </code></li>
						    <li><strong class="mr-1">base() :</strong> <code>Get the base app url (www.example.com)</code></li>
						    <li><strong class="mr-1">download($filepath) :</strong> <code>Send a file to user browser for downlaod </code></li>
                        </ul>
                    </section><!--//section-->
			    </article><!--//docs-article-->
			    
			    <article class="docs-article" id="section-4">
				    <header class="docs-header">
					    <h1 class="docs-heading">Database</h1>
					    <section class="docs-intro">
                            <p>Please use Good Frameworks for huge projects, for more security and easy project management.</p>
						</section><!--//docs-intro-->
                    </header>

                    <section class="docs-section" id="item-4-0">
						<h2 class="section-heading">Migration</h2>
                        <p>Migration is a blueprint of your models in the database.</p>
                        <p>Showcase use SQLite/MySql database, you can set-up at appsettings.json.</p>   
                        <p>Database will not be initialized if not set to 'true' at appsettings.json file (USE_DB parametre).</p> 
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="json hljs">
{
    "USE_DB": "true",
    "DB_HOST": "your_file_name.db",
    "DB_TYPE": "SQLite",
}

{
    "USE_DB": "true",
    "DB_HOST": "localhost",
    "DB_TYPE": "MySql",
    "DB_NAME": "showcase_db",
    "DB_USERNAME": "root",
    "DB_PASSWORD": "",
    "DB_PORT": "3306",
}
                        </code></pre>
                        </div><!--//docs-code-block-->  
                        <p>To create a migration you need to use the commande line on the root folder.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
php showcase make:migration migration_name
                        </code></pre>
                        </div><!--//docs-code-block-->  
                        <p>A file will be created at app/Database/Migrations.</p>
                        <p>To edit the columns, you open the migration file and edit it.</p>
                        <p>Column Type :</p>
                        <ul>
						    <li><strong class="mr-1">int()</strong></li>
						    <li><strong class="mr-1">string()</strong></li>
						    <li><strong class="mr-1">double()</strong></li>
						    <li><strong class="mr-1">blob()</strong></li>
						    <li><strong class="mr-1">bool()</strong></li>
						    <li><strong class="mr-1">datetime()</strong></li>
                        </ul>
                        <p>Column conditions :</p>
                        <ul>
						    <li><strong class="mr-1">nullable()</strong></li>
						    <li><strong class="mr-1">autoIncrement()</strong></li>
						    <li><strong class="mr-1">primary()</strong></li>
						    <li><strong class="mr-1">notnull()</strong></li>
						    <li><strong class="mr-1">default($value)</strong></li>
                        </ul>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Migration details
*/
function handle(){
    $this->name = 'MigrationName';
    $this->column(
        Column::factory()->name('id')->int()
    );
    $this->column(
        Column::factory()->name('name')->string()
    );
    $this->column(
        Column::factory()->name('phone')->string()->nullable()
    );
    $this->timespan(); //created_at and updated_at columns
}
                        </code></pre>
                        </div><!--//docs-code-block--> 
                        <p>updated_at columns will be updated everytime you update your model.</p>
                        <h4>Soft delete</h4>
                        <p>To add soft delete columns, add the function softDelete().</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Migration details
*/
function handle(){
    $this->name = 'MigrationName';
    $this->column(
        Column::factory()->name('id')->int()
    );
    $this->column(
        Column::factory()->name('name')->string()
    );
    $this->column(
        Column::factory()->name('phone')->string()->nullable()
    );
    $this->timespan();
    //Soft delete columns will be added
    $this->softDelete();
}
                        </code></pre>
                        </div><!--//docs-code-block--> 
                        <p>To create those migration, you need to execute another command line.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
php showcase migrate
                        </code></pre>
                        </div><!--//docs-code-block--> 
                    </section><!--//section-->
                    
				     <section class="docs-section" id="item-4-1">
						<h2 class="section-heading">Models</h2>
                        <p>To create a new model use php command line.</p>                           
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
php showcase make:model Model_Name
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <div class="callout-block callout-block-warning">
                            <div class="content">
                                <h4 class="callout-title">
	                                <span class="callout-icon-holder mr-1">
		                                <i class="fas fa-bullhorn"></i>
		                            </span><!--//icon-holder-->
	                                Notice
	                            </h4>
                                <p>If you get the class not found, use the composer dump autoloder, so it add your new file/class.</p>
                                <p>composer dumpautoload -o</p>
                            </div><!--//content-->
                        </div><!--//callout-block-->
						<h3>Save model to database</h3>
                        <p>To create new object from model, simple :</p>  
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
$model = new Model();
$model->param = "value";
$model->param = 10;
$model->save();
                        </code></pre>
                        </div><!--//docs-code-block-->   
                        <p>When using the save function, the model data will be stored in the database.</p> 
						<h3>Update model to database</h3>
                        <p>To update an exisitng model in the database, you need to get it first :</p> 
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\Database\DB;
$model = DB::factory()->model('Model')->select()->where('id', 5)->first();
$model->param = "new value";
$model->save();
                        </code></pre>
                        </div><!--//docs-code-block-->     
                        <p>When using the save function on exising model in database, the new data will be updated in the database.</p> 
						<h3>Delete model from database</h3>
                        <p>To delete model, use the delete function :</p> 
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
$model = DB::factory()->model('Model')->select()->where('id', 5)->first();
$model->delete();
                        </code></pre>
                        </div><!--//docs-code-block-->  
                        <p>If you are using the soft delete columns, the row will not be removed from the database, only deleted_at and active will be updated.</p> 
                        <p>If you not using the soft delete columns, the row will removed for good.</p> 
                        <h4>Get by any Column</h4>
                        <p>To get one model from database by any columns/properties you need, use where function:</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
$model = DB::factory()->model('Model')->select()->where('column', $value)->first();
Log::print($model->paramName);
                        </code></pre>
                        </div><!--//docs-code-block--> 
                        <h4>Get Array of objects</h4>
                        <p>To get array of models, you gonna use the static function toList() :</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
$models = DB::factory()->model('Model')->select()->where('column', $value)->get();
Log::print($models[0]->paramName);
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Get Array of Objects with trash</h4>
                        <p>To get array of models, with one, or more conditions, you gonna use the static function toList() :</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
$models = DB::factory()->model('Model')->select()->where('column', $value)->withTrash()->get();
Log::print($models[0]->paramName);
                        </code></pre>
                        </div><!--//docs-code-block-->
					</section><!--//section-->
					
					<section class="docs-section" id="item-4-2">
						<h2 class="section-heading">Controllers</h2>
                        <p>To create a new controller use php command line.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
php showcase make:controller Controller_Name
                        </code></pre>
                        </div><!--//docs-code-block-->  
                        <p>Controllers are added to app/Controllers</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
class HomeController extends BaseController{
    static function Index(){
        return self::response()->view("App/welcome");
    }
}
                        </code></pre>
                        </div><!--//docs-code-block--> 
					</section><!--//section-->
					
					<section class="docs-section" id="item-4-3">
						<h2 class="section-heading">Queries</h2>
						<p>For an easy search and query build, use the DB object.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\Database\DB;
use \Showcase\Framework\IO\Debug\Log;

$users = DB::factory()->model('User')->select()->where('email', '%@gmail%', 'LIKE')->get();
foreach($users as $user)
    Log::print($user->email . " | " . $user->username);
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>To select from a table, use table function, and give the table name</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
$users = DB::factory()->model('users')->select()->where('email', '%@gmail%', 'LIKE')->get();
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>This will return an array of data.</p>
                        <p>To get an array of object for a model, use the model function, and give the model Name</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
$users = DB::factory()->model('User')->select()->where('email', '%@gmail%', 'LIKE')->get();
                        </code></pre>
                        </div><!--//docs-code-block-->
                    <div class="callout-block callout-block-info">
                            
                            <div class="content">
                                <h4 class="callout-title">
	                                <span class="callout-icon-holder mr-1">
		                                <i class="fas fa-info-circle"></i>
		                            </span><!--//icon-holder-->
	                                Note
	                            </h4>
                                <p>To get an array of data use get() function, to get one object, use first() function</p>
                            </div><!--//content-->
                        </div><!--//callout-block-->
                        <h4>Function to use</h4>
                        <ul>
						    <li><strong class="mr-1">table($name) :</strong> <code>table name to select from </code></li>
						    <li><strong class="mr-1">model($name) :</strong> <code>model to convert data to after fetching it </code></li>
						    <li><strong class="mr-1">select($columns) :</strong> <code>you can specify the columns to select in case you are using the table function </code></li>
						    <li><strong class="mr-1">where($column, $value, $condition) :</strong> <code>add where condition to you query, the condition value is '=' by default </code></li>
						    <li><strong class="mr-1">orWhere($column, $value, $condition) :</strong> <code>add or condition to you query, the condition value is '=' by default </code></li>
						    <li><strong class="mr-1">raw($query) :</strong> <code>add raw sql query to the build, please be carful where you put the raw function in the build of your query </code></li>
						    <li><strong class="mr-1">limit($number) :</strong> <code>to limit the query result </code></li>
						    <li><strong class="mr-1">distinct($column) :</strong> <code>get distinct result for all columns by default, or to specific column </code></li>
						    <li><strong class="mr-1">count($expression) :</strong> <code>get all columns count by default, or an expression/column </code></li>
						    <li><strong class="mr-1">first() :</strong> <code>get the first result </code></li>
						    <li><strong class="mr-1">get() :</strong> <code>get an array of results </code></li>
						    <li><strong class="mr-1">withTrash() :</strong> <code>in case you are using soft delete, with this function, also the deleted records will be selected </code></li>
						    <li><strong class="mr-1">insert($columns) :</strong> <code>insert to model/table at database </code></li>
						    <li><strong class="mr-1">update($columns) :</strong> <code>update a model/table columns </code></li>
						    <li><strong class="mr-1">delete() :</strong> <code>delete a record in the database, this function don't take in concidiration the soft delete, to use the soft delete, use the delete function of the models </code></li>
						    <li><strong class="mr-1">run() :</strong> <code>call this function when using the insert, update, delete and count functions, it return the numbers of lines affected </code></li>
                        </ul>
                        <div class="callout-block callout-block-warning">
                            <div class="content">
                                <h4 class="callout-title">
	                                <span class="callout-icon-holder mr-1">
		                                <i class="fas fa-bullhorn"></i>
		                            </span><!--//icon-holder-->
	                                Warning
	                            </h4>
                                <p>If you are using model function instead of table, the select columns will be ignored.</p>
                            </div><!--//content-->
                        </div><!--//callout-block-->
                    </section><!--//section-->
			    </article><!--//docs-article-->
			    
			    <article class="docs-article" id="section-5">
				    <header class="docs-header">
					    <h1 class="docs-heading">Security</h1>
					    <section class="docs-intro">
                            <p>The showcase use a simple security to protected the data. Please use Good Frameworks for huge projects, for more security and easy project management</p>
						</section><!--//docs-intro-->
				    </header>
				     <section class="docs-section" id="item-5-1">
						<h2 class="section-heading">Authentication</h2>
						<p>To use Authentication, there is one simple mecanisme in showcase to use a simple user with password hashing and saving data in session. To create the model and controller with the views run the command :</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
php showcase auth
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>After, you have to run the migrate command to create the user table in the database.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
php showcase migrate
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>And finaly, add the Auth routes to the web file.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
namespace Showcase {

//Your routes

//Auth routes
Auth::routes($router);
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>Now you have, login and register controllers, with login and register view at Views/Auth.</p>
                        <p>You can use Auth object any where, to check if user is logged, or to get the current logged user.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
//Get the user object
Auth::user(); //return \Showcase\Models\User object

//Get the user username
Auth::username(); //return string

//you can change the property name to return from username() function
Auth::username('lastname'); //return string


//Check if the user is logged
if(Auth::check())
    Log::console("User logged " . Auth:: username());
else
    Log::console("Please login!!");

//Or
if(Auth::guest())
    Log::console("Please login!!");
else
    Log::console("User logged " . Auth:: username());
                        </code></pre>
                        </div><!--//docs-code-block-->
                    </section><!--//section-->
					
					<section class="docs-section" id="item-5-2">
						<h2 class="section-heading">CSRF Guard</h2>
						<p>For more security, csrf guard are required for every POST request. To inject the csrf to a form, use @csrf function.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;form action="/user/store" method="post"&gt;
    @&#8203;csrf
    &lt;input type="text" name="name" placeholder="your name" /&gt;
    &lt;button class="btn btn-success">Submit&lt;/button&gt;
&lt;/form&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
						<p>If you would inject all the forms in a page, without typing @csrf in every forms, use @csrfInject function.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;head&gt;
    &lt;!-- header --&gt;
&lt;/head&gt;
&lt;body&gt;
    @&#8203;csrfInject
    &lt;!-- page --&gt;
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>To use CSRF with Ajax, you use @&#8203;csrf and get the values of the inputs using Jquery.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="javascript hljs">
$.ajax({
    url: "/url",
    type: 'POST',
    data: {
        CSRFName: $('input[name$="CSRFName"]').val(),
        CSRFToken: $('input[name$="CSRFToken"]').val(),
        data: data
    },
    success: function(result) {
        // do something here
    },
    error: function(result) {
        // do something here
    }
});
                        </code></pre>
                        </div><!--//docs-code-block-->
						<p>If no CSRF was found in the post request, a 403 error is returned.</p>
                    </section><!--//section-->
                    <section class="docs-section" id="item-5-3">
						<h2 class="section-heading">Validator</h2>
						<p>To check if request body has a key, or any array has a key, use the validator.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Return the video single page
*/
static function Play($request){
if(Validator::validate($request->get(), ['id'])){
    $url = Search::searchVideoById($request->get()['id']);
    return self::response()->view('App/video', array([
        'url' => $url
        ]));
}

return self::response()->redirect('/errors/404');
}
                        </code></pre>
                        </div><!--//docs-code-block-->
						<p>To get more validation and verification use the function validation, it has options :</p>
                        <ul>
						    <li><strong class="mr-1">required</strong></li>
						    <li><strong class="mr-1">string</strong></li>
						    <li><strong class="mr-1">numeric</strong></li>
						    <li><strong class="mr-1">email</strong></li>
						    <li><strong class="mr-1">phone</strong></li>
						    <li><strong class="mr-1">min</strong> lenght</li>
						    <li><strong class="mr-1">max</strong> lenght</li>
                        </ul>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Store new user
*/
static function store($request){
    $errors = Validator::validation($request->get(), [
            'email' => 'required | email', 
            'password' => 'required | min:8', 
            'username' => 'required | min:3 | max:10 | string'
            ]);
    if (empty($errors)) {
        $user = new User();
        $user->bcrypt($request->get()['password']);
        $user->username = $request->get()['username'];
        $user->email = $request->get()['email'];
        $user->save();

        //Log the user
        Auth::loginWithEmail($user->email);
        return self::response()->redirect('/');
    }
    return self::response()->view('Auth/register', array('errors' => $errors));
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                    </section><!--//section-->
			    </article><!--//docs-article-->
			    
			    
		        <article class="docs-article" id="section-6">
				    <header class="docs-header">
					    <h1 class="docs-heading">Views</h1>
					    <section class="docs-intro">
                            <p>Every view is in the Views folder, you can create a subfolders and add your views files in there.</p>
                            <div class="callout-block callout-block-info">
                            
                            <div class="content">
                                <h4 class="callout-title">
	                                <span class="callout-icon-holder mr-1">
		                                <i class="fas fa-info-circle"></i>
		                            </span><!--//icon-holder-->
	                                Note
	                            </h4>
                                <p>Your views files need to end with .view.php, so they can be found, if not, you will get a 404 status.</p>
                            </div><!--//content-->
                        </div><!--//callout-block-->
						</section><!--//docs-intro-->
				    </header>
				     <section class="docs-section" id="item-6-1">
						<h2 class="section-heading">Functions inside view</h2>
						<h4>Include</h4>
                        <p>To include a view inside another, simply use @include tag.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- Include footer to page --&gt;
&lt;body&gt;
    @&#8203;include("App/footer")
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Extend</h4>
                        <p>Extend is used to call a layout page. for example, you have same nav and footer, so you create a page with nav and footer and html structure and you call it main.view.php</p>
                        <p>Every page you call gonna extend from the main view</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- Extend from main index --&gt;
@&#8203;extend("App/main")
&lt;div class="container"&gt;
&lt;/div&gt;

&lt;!-- main --&gt;
&lt;body&gt;
    @&#8203;render()
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <div class="callout-block callout-block-info">
                            
                            <div class="content">
                                <h4 class="callout-title">
	                                <span class="callout-icon-holder mr-1">
		                                <i class="fas fa-info-circle"></i>
		                            </span><!--//icon-holder-->
	                                Note
	                            </h4>
                                <p>You have to put the @render() tag inside the main view, in the position where you want the child view to be displayed.</p>
                            </div><!--//content-->
                        </div><!--//callout-block-->
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- main.view.php --&gt;
&lt;body>
    &lt;nav&gt;&lt;/nav&gt;
    @&#8203;render()
    &lt;footer&gt;&lt;/footer&gt;
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Section</h4>
                        <p>To display a piece of code only in same views, use section function, render the section in the view (like the main layout), and use the section function to define the code to be included.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- render section in main view --&gt;
&lt;body&gt;
    @&#8203;renderSection("Javascript")
&lt;/body&gt;

&lt;!-- section code in the home view --&gt;
&lt;body&gt;
    @&#8203;section("Javascript")
        &lt;script&gt;
            //Some script here will be only added to the main view if this view is added
        &lt;/script&gt;
    @&#8203;endsection
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <div class="callout-block callout-block-info">
                            
                            <div class="content">
                                <h4 class="callout-title">
	                                <span class="callout-icon-holder mr-1">
		                                <i class="fas fa-info-circle"></i>
		                            </span><!--//icon-holder-->
	                                Note
	                            </h4>
                                <p>You have to put the @renderSection("sectionName") tag inside the main view, in the position where you want the code to be displayed.</p>
                            </div><!--//content-->
                        </div><!--//callout-block-->
                        <h4>Execute php inside a view</h4>
                        <p>To execute a custom php insdie a view, you can use the php function.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- contact.view.php --&gt;
@&#8203;extend("App/main")
&lt;body&gt;
    @&#8203;php
        $var = 1;
        echo "this is a var $var"; //dont use @display inside a @php function
    @&#8203;endphp
    &lt;!-- You page Code --&gt;
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Foreach and for Loops</h4>
                        <p>To execute a loop without using the @php function, use the @foreach and @for loops.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- contact.view.php --&gt;
@&#8203;extend("App/main")
&lt;body&gt;
    &lt;!-- Foreach loop --&gt;
    @&#8203;foreach(\Showcase\Models\User::toList() as $user)
        @&#8203;if($user->isAdmin)
        &lt;p&gt; @&#8203;display $user->name @&#8203;enddisplay &lt;/p&gt;
        @&#8203;endif
    @&#8203;endforeach

    &lt;!-- For loop --&gt;
    @&#8203;for($i=0; $i < 5; $i++)
        @&#8203;display "number $i" @&#8203;enddisplay;
    @&#8203;endfor
    &lt;!-- You page Code --&gt;
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Condition If</h4>
                        <p>If you want to check a condition without the php function, use the @if function.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- contact.view.php --&gt;
@&#8203;extend("App/main")
&lt;body&gt;
    &lt;!-- Simple if --&gt;
    @&#8203;if($show)
        &lt;p&gt;Show it!&lt;/p&gt;
    @&#8203;endif

    &lt;!-- If with Else --&gt;
    @&#8203;if($show)
        &lt;p&gt;Show it!&lt;/p&gt;
    @&#8203;else
        &lt;p&gt;Not Showing it!&lt;/p&gt;
    @&#8203;endif
    &lt;!-- You page Code --&gt;
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Display to view</h4>
                        <p>To display a variable or a function result, use @&#8203;display function, inside @&#8203;php, @&#8203;foreach, @&#8203;for and @&#8203;if statement or in plain html.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- contact.view.php --&gt;
@&#8203;extend("App/main")
&lt;body&gt;
    @&#8203;if($show)
        &lt;!-- Display --&gt;
        @&#8203;display '&lt;p&gt;Show it!&lt;/p&gt;' @&#8203;enddisplay
    @&#8203;endif
    &lt;!-- Display --&gt;
    @&#8203;display '&lt;p&gt;Out Side!&lt;/p&gt;' @&#8203;enddisplay
    
    &lt;!-- Display --&gt;
    @&#8203;display $number + 5 @&#8203;enddisplay
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <h4>Display a variable</h4>
                        <p>To display a simple variable sent from controller, use the variable function {&#8203;{$var}}</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
return self::response()->view('App/welcome', array(
                                'title' => 'post 1',
                                ));
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- post.view.php --&gt;
@&#8203;extend("App/main")
&lt;body&gt;
    &lt;p&gt;{&#8203;{$title}}&lt;/p&gt;
&lt;/body&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
					</section><!--//section-->
					
					<section class="docs-section" id="item-6-2">
						<h2 class="section-heading">Variables from Controllers to View</h2>
                        <p>To send a variable from controller to a view, add an array to the view method of the controller.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
/**
* Return the video single page
*/
static function Play($request){
    if(Validator::validate($request->get(), ['id'])){
        $url = Search::searchVideoById($request->get()['id']);
        return self::response()->view('App/video', array([
            'url' => $url
            ]));
    }

    return self::response()->notFound();
}
                        </code></pre>
                        </div><!--//docs-code-block-->
					</section><!--//section-->
					
					<section class="docs-section" id="item-6-3">
							<h2 class="section-heading">Styles & Javascript & other Files</h2>
                        <p>To include files from the resources folder to your views, you need to use a tag :</p>
                        <ul>
						    <li><strong class="mr-1">Assets :</strong> <code>Main folder for all the resources, even images.</code></li>
						    <li><strong class="mr-1">Styles :</strong> <code>CSS folder.</code></li>
						    <li><strong class="mr-1">Scripts :</strong> <code>Javascript folder.</code></li>
						    <li><strong class="mr-1">Images :</strong> <code>Images folder.</code></li>
						    <li><strong class="mr-1">Base :</strong> <code>The main url of you web app.</code></li>
						    <li><strong class="mr-1">Bootsrap-Style :</strong> <code>Bootstrap css file.</code></li>
						    <li><strong class="mr-1">Bootsrap-Script :</strong> <code>Bootstrap js file.</code></li>
						    <li><strong class="mr-1">Jquery :</strong> <code>Jquery file.</code></li>
                        </ul>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="html hljs">
&lt;!-- Adding resources url to style --&gt;
&lt;link href="@&#8203;{&#8203;{Styles}}/main.min.css"&gt;

&lt;link href="@&#8203;{&#8203;{Bootsrap-Style}}"&gt;

&lt;!-- Adding resources url to image --&gt;
&lt;img src="@&#8203;{&#8203;{Images}}/logo.png" class="img-fluid" alt="logo"/&gt;
&lt;!-- Adding Base url to a link tag --&gt;
&lt;a href="@&#8203;{&#8203;{Base}}/Contact"&gt;Contact-Us&lt;/a&gt;
                        </code></pre>
                        </div><!--//docs-code-block-->
					</section><!--//section-->
			    </article><!--//docs-article-->

                <article class="docs-article" id="section-7">
				    <header class="docs-header">
					    <h1 class="docs-heading">Storage</h1>
					    <section class="docs-intro">
						    <p>Some users find it hard and repetitive in the files managing level, to make a bite easy to use showcase with file management, you can use the Storage Object.</p>
						</section><!--//docs-intro-->
				    </header>
				     <section class="docs-section" id="item-7-1">
						<h2 class="section-heading">Files, folders and download</h2>
						<p>To create, copy, move and save data to file, you can use the Storage following functions :</p>
						<p>First, you need to select the folder, there is 3 functions to that : </p>
                        <ul>
						    <li><strong class="mr-1">folder($name) :</strong> <code>The root of this is /storage folder, and you specify the sub folder name</code></li>
						    <li><strong class="mr-1">resources($folder) :</strong> <code>The root of this is /resources folder, and you specify the sub folder name.</code></li>
						    <li><strong class="mr-1">global() :</strong> <code>The root of this is the project root.</code></li>
                        </ul>
						<p>After that, you do your desired action : </p>
                        <ul>
						    <li><strong class="mr-1">put($filename, $content) :</strong> <code>Save the content in the file, if the file exist, it will be crushed.</code></li>
						    <li><strong class="mr-1">get($filename) :</strong> <code>Get a file content</code></li>
						    <li><strong class="mr-1">exists($filename) :</strong> <code>Check if a file exists</code></li>
						    <li><strong class="mr-1">copy($filename, $newfile) :</strong> <code>Copy file from the folder to another path</code></li>
						    <li><strong class="mr-1">move($filename, $newfile) :</strong> <code>Move file from the folder to another path</code></li>
						    <li><strong class="mr-1">remove($filename) :</strong> <code>Remove file from the folder.</code></li>
						    <li><strong class="mr-1">path($filename) :</strong> <code>Get the path to a file in the current folder</code></li>
						    <li><strong class="mr-1">url($filename) :</strong> <code>Get a url to download a file</code></li>
						    <li><strong class="mr-1">download($filename) :</strong> <code>Send the file to the user browser for download</code></li>
                        </ul>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\IO\Storage\Storage;
//Save to file
$page = "Hola";
Storage::folder("docs")->put('docs-page.html', $page);
//Get a file url
$file = "invoice.pdf";
$url = Storage::folder('app')->url($file); // give the url to downloads like this http://localhost:8000/download?file=1610656545_docs.zip

//Get a file path
$file = Storage::folder("app")->path($file); // return something like this D:\path\to\project\src\app\Framework\Storage/../../../storage/app/invoice.pdf
                        </code></pre>
                        </div><!--//docs-code-block-->
						<p>You can use the Storage object in the controllers without including it, use only storage() function : </p>
                        <ul>
						    <li><strong class="mr-1">storage($foldername) :</strong> <code>To use the /storage sub folders</code></li>
						    <li><strong class="mr-1">storageResources($foldername) :</strong> <code>To use the /resources sub folder</code></li>
						    <li><strong class="mr-1">storageGlobal() :</strong> <code>To use the root project</code></li>
                        </ul>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\HTTP\Controllers\BaseController;

class HomeController extends BaseController{

    /**
     * Return the welcome view
     */
    static function Index(){
        $file = "invoice.pdf";
        return self::storage("app")->download($file);
    }
}
                        </code></pre>
                        </div><!--//docs-code-block-->
                    </section><!--//section-->
                    
			    </article><!--//docs-article-->
			    
			    
			    <article class="docs-article" id="section-8">
				    <header class="docs-header">
					    <h1 class="docs-heading">Debug</h1>
					    <section class="docs-intro">
						    <p>To print out data to a log file, or terminal, use the Log Class. The data can be string or array only!</p>
						</section><!--//docs-intro-->
				    </header>
				     <section class="docs-section" id="item-8-1">
						<h2 class="section-heading">File</h2>
						<p>To log data to file log use the print function. The file log is created at Storage/logs, with the current day as name.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\IO\Debug\Log;

Log::print("Message to print in log file");
                        </code></pre>
                        </div><!--//docs-code-block-->
                    </section><!--//section-->
					
					<section class="docs-section" id="item-8-2">
						<h2 class="section-heading">Console</h2>
                        <p>To log data to console use the console function.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\IO\Debug\Log;

Log::console("Message to print in the console");
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>To color the console logs, you can use the four status : info, error, warning, sucess.</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\IO\Debug\Log;

Log::console("No File was Found!", 'error');
                        </code></pre>
                        </div><!--//docs-code-block-->
					
					<section class="docs-section" id="item-8-3">
						<h2 class="section-heading">var_dump</h2>
                        <p>To catch var_dump result and display it in the file or console use the var_dump function</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="php hljs">
use \Showcase\Framework\IO\Debug\Log;
$data = ['var1', 'var2', 'var3'];
Log::var_dump($data);
                        </code></pre>
                        </div><!--//docs-code-block-->
                    </section><!--//section-->
                    
			    </article><!--//docs-article-->
			    
			    
			    <article class="docs-article" id="section-9">
				    <header class="docs-header">
					    <h1 class="docs-heading">Run It!</h1>
					    <section class="docs-intro">
                            <p>To start the showcase web site/web app to the following:</p>
                            <p>go to the public folder with the command line</p>
                            <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
cd /public
                        </code></pre>
                        </div><!--//docs-code-block-->
                        <p>And run the php server</p>
                        <div class="docs-code-block">
							<pre class="shadow-lg rounded"><code class="bash hljs">
php -S localhost:8000
                        </code></pre>
                        </div><!--//docs-code-block-->
						</section><!--//docs-intro-->
				    </header>
			    </article><!--//docs-article-->

			    <footer class="footer">
				    <div class="container text-center py-5">
					    <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
				        <small class="copyright">Designed with <i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="theme-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>
				        <ul class="social-list list-unstyled pt-4 mb-0">
						    <li class="list-inline-item"><a href="https://github.com/MohKamal/php-Showcase-template"><i class="fab fa-github fa-fw"></i></a></li> 
				            <li class="list-inline-item"><a href="https://twitter.com/MOURCHIDKamal"><i class="fab fa-twitter fa-fw"></i></a></li>
				            <li class="list-inline-item"><a href="#"><i class="fab fa-slack fa-fw"></i></a></li>
				            <li class="list-inline-item"><a href="#"><i class="fab fa-product-hunt fa-fw"></i></a></li>
				            <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f fa-fw"></i></a></li>
				            <li class="list-inline-item"><a href="#"><i class="fab fa-instagram fa-fw"></i></a></li>
				        </ul><!--//social-list-->
				    </div>
			    </footer>
		    </div> 
	    </div>
    </div><!--//docs-wrapper-->
    
   
       
    <!-- Javascript -->          
    <script src="@{{Assets}}assets/plugins/jquery-3.4.1.min.js"></script>
    <script src="@{{Assets}}assets/plugins/popper.min.js"></script>
    <script src="@{{Assets}}assets/plugins/bootstrap/js/bootstrap.min.js"></script>  
    
    
    <!-- Page Specific JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/highlight.min.js"></script>
    <script src="@{{Assets}}assets/js/highlight-custom.js"></script> 
    <script src="@{{Assets}}assets/plugins/jquery.scrollTo.min.js"></script>
    <script src="@{{Assets}}assets/plugins/lightbox/dist/ekko-lightbox.min.js"></script> 
    <script src="@{{Assets}}assets/js/docs.js"></script> 

</body>
</html> 

