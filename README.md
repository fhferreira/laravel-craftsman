
# Laravel Craftsman

## Description
Laravel Craftsman (written using the awesome [Laravel-Zero](https://www.laravel-zero.com) CLI builder) provides a suite of crafting assets using a project agnostic CLI. 

You can quickly create `class`, `controller`, `factory`, `migration`, `model`, `seed` and `view` assets. 
In addition, you can create all assets with a single command, allowing you to quickly craft a new resource in seconds!

<h1 align="center">
	<img src="docs/images/laravel-craftsman.png" alt="Laravel Craftsman">
</h1>

## Installation

**Using Composer**

```bash
> composer global require codedungeon/laravel-craftsman 
```

**Using curl/wget**

```bash
> curl -o laravel-craftsman https://github.com/mikeerickson/laravel-craftsman/archive/master.zip

or

> wget https://github.com/mikeerickson/laravel-craftsman/archive/master.zip
```

## Usage

```bash
> laravel-craftsman <command> [options] [arguments]

> laravel-craftsman craft:all Post --model App/Models/Post --tablename posts --rows 50 --extends layouts.app --section content

> laravel-craftsman craft:class App/TestClass --constructor

> laravel-craftsman craft:controller PostController --model App/Models/Post

> laravel-craftsman craft:factory PostFactory --model App/Models/Post

> laravel-craftsman craft:migration create_posts_table --model App/Models/Post --tablename posts

> laravel-craftsman craft:model App/Models/Post --tablename posts 

> laravel-craftsman craft:seed PostTableSeeder --model App/Models/Post --rows 100

> laravel-craftsman craft:views authors --extends partials.master --section content

```

## Commands

The following commands are available in any Laravel project.  You can use the individual crafting routines which are similar to the Artisan commands, but the `craft:all` command is the most powerful of the bunch.

Using `craft:all` you can easily generate all assets (controller, factory, migration, model, and seed) for a given resource (ie Post, Customer, etc)

```
laravel-craftsman craft:all Contact --model App/Models/Contact --tablename contacts --rows 50 --fields fname:string,30^nullable, lname:string,50^nullable, email:string^unique
```

| Command              | Name / Option       | Description                                                          |
|----------------------|---------------------|----------------------------------------------------------------------|
| **craft:all**        | **base name**       | **Creates all assets (Controller, Factory, Migration, Model, Seed)** |
|                      | --model, -m         | Path to model (eg App/Models/Post)                                   |
|                      | --tablename, -t     | Tablename used in database (will set $tablename in Model)            |
|                      |                     | _If not supplied, default table will be pluralized model name_       |
|                      | --rows, -r          | Number of rows used by seed when using Factory                       |
|                      | --extends, -x       | View extends block (optional)                                        |
|                      | --section, -i       | View section block (optional)                                        |
|                      | --no-controller, -c | Do not create controller                                             |
|                      | --no-factory, -a    | Do not create factory                                                |
|                      | --no-migration, -g  | Do not create migration                                              |
|                      | --no-model, -o      | Do not create model                                                  |
|                      | --no-seed, -s       | Do not create seed                                                   |
|                      | --no-views, -e       | Do not create seed                                                   |
| **craft:class**      | **class name**      | **Creates empty class**                                              |
|                      | --constructor, -c   | Include constructor method                                           |
| **craft:controller** | **controller name** | **Create controller using supplied options**                         |
|                      | --model, -m         | Path to model (eg App/Models/Post)                                   |
|                      | --validation, -l    | Create validation blocks where appropriate                           |
|                      | --api, -a           | Create API controller (skips create and update methods)              |
|                      | --empty, -e         | Create empty controller                                              |
| **craft:factory**    | **factory name**    | **Creates factory using supplied options**                           |
|                      | --model, -m         | Path to model (eg App/Models/Post)                                   |
| **craft:migration**  | **migration name**  | **Creates migration using supplied options**                         |
|                      | --model, -m         | Path to model (eg App/Models/Post)                                   |
|                      | --tablename, -t     | Tablename used in database (will set $tablename in Model)            |
|                      |                     | _If not supplied, default table will be pluralized model name_       |
|                      | --fields, -f        | List of fields (option) _see syntax below_                           |
|                      | --down, -d          | Include down methods (skipped by default)                            |
| **craft:model**      | **model name**      | **Creates model using supplied options**                             |
|                      | --tablename, -t     | Tablename used in database (will set $tablename in Model)            |
|                      |                     | _If not supplied, default table will be pluralized model name_       |
| **craft:seed**       | **base seed name**  | **Creates seed file using supplied options**                         |
|                      | --model, -m         | Path to model (eg App/Models/Post)                                   |
|                      | --rows, -r          | Number of rows to use in factory call (Optional)                     |
| **craft:views**      | **base resource**   | **Creates view files**                                               |
|                      | --extends, -x       | Includes extends block using supplied layout                         |
|                      | --section, -s       | Includes section block using supplied name                           |
|                      | --no-create, -c     | Exclude create view                                                  |
|                      | --no-edit, -d       | Exclude edit view                                                    |
|                      | --no-index, -i      | Exclude index view                                                   |
|                      | --no-show, -w       | Exclude show view                                                    |

#### Field Option Syntax
When using the `--fields` option when building migrations, you should use the following syntax:

```
format:
fieldName:fieldType@fieldSize:option1:option2:option3

example:
email:string@80:nullable:unique 

--fields fname:string@25:nullable,lname:string@50:nullable,email:string@80:nullable:unique,dob:datetime,notes:text,deleted_at:timezone

    Schema::create('contacts', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->timestamps();
        $table->string('fname', 25)->nullable();
        $table->string('lname', 50)->nullable();
        $table->string('email', 80)->nullable()->unique();
        $table->datetime('dob');
        $table->text('notes');
        $table->timezone('deleted_at');
    });
```

## Tips
When executing any of the `laravel-craftsman` commands, if you wish to apply one or more switches (those options which do not require a corresponding value), you can use the standard CLI shorthands (this tip can be used in any CLI based tool, not just `laravel-craftsman` (well assuming the CLI actually supports shorthand).

For example:

Lets assume you wish to wish to create `views`, you can use the following command to skip creation of the create (-c), edit (-d) and show (-w) views (only creating the index view). The combination of `-cdw` is shorthand for `--no-create --no-edit --no-show`

```bash
> laravel-craftsman craft:views --extends layouts.app --section content -cdw

is same as

> laravel-craftsman craft:views --extends layouts.app --section content --no-create --no-edit --no-show
or
> laravel-craftsman craft:views --extends layouts.app --section content -c -d -w
```



## Custom Templates
Laravel Craftsman provides support for creating custom templates if you wish to change the syntax to match your personal style. The default templates use the standard Laravel syntax, but we like to allow ou have your own flair.  

### Customizing Templates
If you wish to create derivatives of the supported templates, you can customize the `config.php` located in the `laravel-craftsman` directory.
By default, this will be `~/.composer/vendor/codedungeon/laravel-craftsman`, but may be different depending on the method you chose to install laravel-craftsman.

```php
    'templates' => [
            'class' => 'user_templates/class.mustache',
            'api-controller' => 'user_templates/api-controller.mustache',
            'empty-controller' => 'user_templates/empty-controller.mustache',
            'controller' => 'user_templates/controller.mustache',
            'factory' => 'user_templates/factory.mustache',
            'migration' => 'user_templates/migration.mustache',
            'model' => 'user_templates/model.mustache',
            'seed' => 'user_templates/seed.mustache',
            'view-create' => 'user_templates/view-create.mustache',
            'view-edit' => 'user_templates/view-edit.mustache',
            'view-index' => 'user_templates/view-index.mustache',
            'view-show' => 'user_templates/view-show.mustache',
        ],
```
    
### List of available variables
The following variables can be used in any of the supported templates (review the `templates` directory for a basis of how to create custom templates)

| Variable Name  | Templates which variable is used                                                            |
|--------------- |---------------------------------------------------------------------------------------------|
| `fields`       | Used by `migration`                                                                         |
| `model`        | Used by `api-controller`, `class`, `controller`, `factory`, `migration`, `model` and `seed` |
| `model_path`   | Used by `api-controller`, `controller`, `factory`, `migration`, `seed`                      |
| `name`         | Used by `api-controller`, `controller` and `empty-controller`                               |
| `namespace`    | Used by `class`, `model`                                                                    |
| `num_rows`     | Used by `seed`                                                                              |
| `tablename`    | Used by `controller`, `migration`, `model`                                                  |
| `extends`      | Used by `views`                                                                             |
| `section`      | Used by `views`                                                                             |


## License

Copyright &copy; 2019 Mike Erickson
Released under the MIT license

## Credits

laravel-craftsman written by Mike Erickson

E-Mail: [codedungeon@gmail.com](mailto:codedungeon@gmail.com)

Twitter: [@codedungeon](http://twitter.com/codedungeon)

Website: [codedungeon.io](http://codedungeon.io)
