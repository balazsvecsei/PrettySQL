# PrettySQL
Fast and nice mysql query builder for php.



## Initialize
You must first initialize an instance in your namespace. In the first argument, you need to inject the database interface and then optionally the table. (If you want to use your instance with only 1 table)

### Initialize with only 1 table
```php
new PSql(Database $database, 'users');
```
Example for select the first row, and insert another:
```php
new PSql(Database $database, 'users');

$firstUser = psql::select()->first();

psql::insert()->row([
    "name"=>"Cloe Hilton",
    "email"=>"cloehilton@gmail.com"
]);
```
### Initialize for multytable usage
```php
new Psql(Database $database);
```
In this case, the table name must be defined in the statement argument. 

Example for select the first row, and insert another:
```php
new PSql(Database $database);

$firstUser = psql::select("users")->first();

psql::insert("users")->row([
    "name"=>"Cloe Hilton",
    "email"=>"cloehilton@gmail.com"
]);
```

## Insert
The static statement: `psql::insert()`
Parameterizing the query:
#### row()
Passing 1 row to table
```php
psql::insert()->row(["column"=>"value", "column"=>"value"]);
```
#### collection()
Passing more row to table
```php
psql::insert()->collection([
    ["column"=>"value", "column"=>"value"],
    ["column"=>"value", "column"=>"value"],
    ...
]);
```

## Select
The static statement: `psql::select()`

General example of listing products in a webshop
```php

psql::select()
        ->orderBy("uploaded_time", "ASC")
        ->selectColumns(["name", "image", "price"])
        ->whereIs("in_stock", true)
        ->and("quantity" ">=" 20)
        ->or("available" "==" true)
    
```

Parameterizing the query:

#### whereId()
Select by id
```php
psql::select()->whereId(3);
```

#### first()
Select the first item in table
```php
psql::select()->first();
```

#### latest()
Select the last item in table
```php
psql::select()->last();
```
#### orderBy()
Ordering and sorting the results by column. First argument `column` (default: id) second `sort`(default: ASC)
```php
psql::select()->orderBy("name", "DESC");
```

#### selectColumns()
Select columns
```php
psql::select()->selectColumns(["id", "firstname", "lastname", "image"]);
```

#### setLimit()
Set the quantity of rows
```php
psql::select()->setLimit(100);
```
