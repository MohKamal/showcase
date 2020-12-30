# Showcase Micro Framework
<p align="center">
  <img src="https://github.com/MohKamal/php-showcase-template/blob/master/icon.png?raw=true">
</p>
A micro mini php framework to make one page or no back-end web site, like a presentation with no models

# PLEASE THIS PROJECT IS NOT SAFE FOR PRODUCTION, ONE PRESENTATION PAGE WITH NON DATA IS FINE, BUT DATABASE AND AUTH, PLEASE USE A FRAMEWORK LIKE Laravel, Symfony, Slim...

## Routes
```php  
    $router->get('/path', function () {
        /* Code to execute */
        return self::response()->redirect('login');
        /* Another */
        return HomeController::Home();
    });

    $router->post('/path',  function ($request) {
        return HomeController::Contact($request);
    });
```

## Validator
To check if request body has a key, or any array has a key, use the validator.

```php  
    /**
     * Return the video single page
     */
    static function Play($request){
        if(Validator::Validate($request->getBody(), ['id'])){
            $url = Search::searchVideoById($request->getBody()['id']);
            return self::response()->view('App/video', array([
                'url' => $url
                ]));
        }

        return self::response()->redirect('/errors/404');
    }
```

## Response
Response is an object used to make user responses more easier.
There is three response : view, redirect and json

### Response View
To return a view, use view response
```php  
    $router->get('/path', function () {
        return self::response()->view('App/welcome');
    });
```

### Response Redirect
To redirect a user, use a redirect response
```php  
    $router->get('/path', function () {
        return self::response()->redirect('/contact-us');
    });
```

### Response Json
To return any object as json response, use response json
```php  
    $router->get('/path', function () {
        $data = User::toList([
            'active' => 1
        ]);

        return self::response()->json($data);
    });
```

### Response codes
To return codes use :
* 404 : response()->notFound()
* 200 : response()->OK()
* 403 : response()->unauthorized()
* 500 : response()->internal()

## Views

Every view is in the Views folder, you can create a subfolders and add your views files in there. Example : 
* Views 
  - Home
    - Welcome.view.php
* Contact
  - Contact.view.php
    - About.view.php

### Attention

Your views files need to end with .view.php, so they can be found, if not, you will get a 404 status

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

### Execute php inside a view

To execute a custom php insdie a view, you can use the php function

```html
<!-- contact.view.php -->
@extend("App/main")
<body>
    @php
        $var = 1;
        display("this is a var $var");
    @endphp
    <!-- You page Code -->
</body>
```

### Foreach and for Loops
To execute a loop without using the @php function, use the @foreach and @for loops.
```html
<!-- contact.view.php -->
@extend("App/main")
<body>
    <!-- Foreach loop -->
    @foreach(\Showcase\Models\User::toList() as $user){
        if($user->isAdmin)
            display("<p>$user->name</p>");
    }@endforeach

    <!-- For loop -->
    @for($i=0; $i < 5; $i++){
        display("number $i");
    }@endfor
    <!-- You page Code -->
</body>
```

#### Note
Use natice php code inside the loops.
Don't forget the brakets '{}' inside the @foreach and @endforeach or the @for and @endfor, also @if and @else or @endif

### Condition If
If you want to check a condition without the php function, use the @if function.
```html
<!-- contact.view.php -->
@extend("App/main")
<body>
    <!-- Simple if -->
    @if($show){
        display("<p>Show it!</p>");
    }@endif

    <!-- If with Else -->
    @if($show){
        display("<p>Show it!</p>");
    }@else{
        display("<p>Not Showing it!</p>");
    }@endif
    <!-- You page Code -->
</body>
```

### Display to view
To display a variable or a function result, use @display function, inside @php, @foreach, @for and @if statement or in plain html.
```html
<!-- contact.view.php -->
@extend("App/main")
<body>
    @if($show){
        <!-- Display -->
        @display '<p>Show it!</p>' @enddisplay
    }@endif
    <!-- Display -->
    @display '<p>Out Side!</p>' @enddisplay
    
        <!-- Display -->
    @display $number = $number + 5 @enddisplay
</body>
```

To display a simple variable sent from controller, use only the variable name
```php
return self::response()->view('App/welcome', array(
                            'title' => 'post 1',
                            ));
```
```html
<!-- post.view.php -->
@extend("App/main")
<body>
    <p>$title</p>
</body>
```
## Send variables from Controller to view

To send a variable from controller to a view, add an array to the view method of the controller.

```php  
    /**
     * Return the video single page
     */
    static function Play($request){
        if(Validator::Validate($request->getBody(), ['id'])){
            $url = Search::searchVideoById($request->getBody()['id']);
            return self::response()->view('App/video', array([
                'url' => $url
                ]));
        }

        return self::response()->redirect('/errors/404');
    }
```

## Styles & Javascript & other Files

To include files from the resources folder to your views, you need to use a tag :

Assets : Main folder for all the resources, even images.

Styles : CSS folder.

Scripts : Javascript folder.

```html
<!-- Adding resources url to style -->
<link href="@{{Styles}}main.min.css">
```

```html
<!-- Adding resources url to image -->
<img src="@{{Assets}}images/logo.png" class="img-fluid" alt="logo"/>
<!-- Adding Base url to a link tag -->
<a href="@{{Base}}/Contact">Contact-Us</a>
```

## Controllers and Models

### Attention
Please use Good Frameworks for huge projects, for more security and easy project management

To create a new controller use php command line

```bash
php creator createController Controller_Name
```
Example

```bash
php creator createController ContactController
```

To create a new model use php command line

```bash
php creator createModel Model_Name
```
Example
```bash
php creator createModel ContactModel
```

### Save model to database

Showcase use SQLite/MySql database, you can set-up at appsettings.json.

Database will not be initialized if not set to 'true' at appsettings.json file (USE_DB parametre).

### Warning
MySql it not fully test, if you find any bugs or error, please repport them to be fixed.

```json
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
```

To create new object from model, simple : 

```php
$model = new Model();
$model->param = "value";
$model->param = 10;
$model->save();
```

When using the save function, the model data will be stored in the database.

### Update model to database

To update an exisitng model in the database, you need to get it first :

```php
$model = new Model();
$model->get(1); // get by id = 1
$model->param = "new value";
$model->save();
```

When using the save function on exising model in database, the new data will be updated in the database

### Delete model from database

To delete model, use the delete function : 

```php
$model = new Model();
$model->get(1)->delete(); // get by id = 1 and deleted
```
If you are using the soft delete columns, the row will not be removed from the database, only deleted_at and active will be updated.

If you not using the soft delete columns, the row will removed for good.

## Get model/Array of models from database

### By Id

To get one model from database, you create the object, and use the get function with the id:

```php
$model = new Model();
$model->get(1); // get by id = 1
print($model->paramName);
```

### By any column

To get one model from database by any columns/properties you need, use where function:

```php
$model = new Model();
$model->where([
    'column_name' => 'value',
    'column_name' => 'value'
]);
print($model->paramName);
```

### Get Array of objects

To get array of models, you gonna use the static function toList() : 

```php
$models = Model::toList();
print($models[0]->paramName);

```
### Get Array of Objects with conditions

To get array of models, with one, or more conditions, you gonna use the static function toList() : 

```php
if(empty($category))
    $data = Picture::toList();
else{
    $data = Picture::toList([
        'category' => $category
    ]);
}

```
## Migration

To create a migration you need to use the commande line on the root folder.

```bash
php creator createMigration migration_name
```

A file will be created at Database\Migrations.

To edit the columns, you open the migration file and edit it.

Column Type :  int(), string(), double(), blob(), bool(), datetime()
Column conditions : nullable(), autoIncrement(), primary(), notnull(), default($value)

```php
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
```
updated_at columns will be updated everytime you update your model.
### Soft delete

To add soft delete columns, add the function softDelete().

```php
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
```

To create those migration, you need to execute another command line.

```bash
php creator migrate
```

## Session

To display a message using $_SESSION, or to save a variable in the $_SESSION, to use it in different Controllers, you can use the session object

```php
    use \Showcase\Framework\Session\Session;
    //Store value
    Session::store('filter', 'drinks');

    //Get the value of filter
    echo Session::retrieve('filter'); //If filter dosen't exist, a null will be returned
```

## Session Alert

To display a message using $_SESSION, you can use the sessionAlert object

```php
    use \Showcase\Framework\Session\SessionAlert;
    //Store value
    SessionAlert::create('Email not found in the database', 'error');

    // There is four stats to the message : info, error, waring and success
    // info is the default

    //To remove the message
    SessionAlert::clear();

```
```html
<!-- To show the SessionAlert  -->
@sessionAlert()
<a href="@{{Base}}/Contact">Contact-Us</a>
```
## Authentication
To use Authentication, there is one simple mecanisme in showcase to use a simple user with password hashing and saving data in session.
To create the model and controller with the views run the command : 

```bash
php creator auth
```
After, you have to run the migrate command to create the user table in the database.

```bash
php creator migrate
```
And finaly, add the Auth routes to the web file.

```php
namespace Showcase {

    //Other includes here
    use \Showcase\Framework\HTTP\Gards\Auth;

    $router  = new Router(new Request);

    //Your routes

    //Auth routes
    Auth::routes($router);
}
```

Now you have, login and register controllers, with login and register view at Views/Auth.

You can use Auth object any where, to check if user is logged, or to get the current logged user.
```php
    //Get the user object
    Auth::user(); //return \Showcase\Models\User object

    //Get the user username
    Auth::username(); //return string

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

```
## Debug

To print out data to a log file, use the Log Class.

```bash
use \Showcase\Framework\IO\Debug\Log;

Log::print("Message to print in log file");
Log::console("Message to print in the console");
```

## Run it

go to the public folder with the command line

```bash
cd /public
```

And run the php server

```bash
php -S localhost:8000
```