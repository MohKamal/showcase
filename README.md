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
php Creator.php createController Controller_Name
```
Example

```bash
php Creator.php createController ContactController
```

To create a new model use php command line

```bash
php Creator.php createModel Model_Name
```
Example
```bash
php Creator.php createModel ContactModel
```

### Save model to database

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

## Migration

To create a migration you need to use the commande line on the root folder.

```bash
php Creator.php createMigration migration_name
```

A file will be created at Database\Migrations.

To edit the columns, you open the migration file and edit it.

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
php Creator.php migrate
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