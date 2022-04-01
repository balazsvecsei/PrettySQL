# PrettySQL
Fast and nice mysql query builder for php.


## Statements
- [x] Select 
- [x] Create
- [ ] Insert
- [x] Delete 
- [x] Drop 
- [ ] Update 
- [ ] Alter 

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
