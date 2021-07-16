# Laravel Filter Query String
#### Filter your queries based on url query string parameters like a breeze.

*Compatible with Laravel **5.x** **6.x** **7.x** **8.x***.

## Table of Content
- [Describing the Problem](#Describing-the-Problem)
- [Usage](#Usage)
    - [Installation](#Usage)
    - [Available Filters](#Available-Methods)
        - [Sort](#Sort)
        - [Comparisons](#Comparisons)
        - [In](#In)
        - [Like](#Like)
        - [Where clause](#Where-Clause-Default-Filter)
        - [Fields](#fields)
        - [Search](#search)
        - [Page](#page)
        - [Limit](#limit)
        - [Relationship](#relationship)
        - [With Trashed](#withtrashed)
        - [Order By](#orderby)
        - [Where](#where)
        - [Or Where](#or-where)
        - [Equal](#equal)
        - [Not Equal](#not-equal)
        - [Greater Than](#greater-than)
        - [Greater Than Equal](#greater-than-equal)
        - [Less Than](#less-than)
        - [Less Than Equal](#less-than-equal)
        - [Like](#like)
        - [Not Like](#not-like)
        - [Contain](#contain)
        - [Not Contain](#not-contain)
        - [Start With](#start-with)
        - [End With](#end-with)
        - [In](#in)
        - [Not In](#not-in)
        - [Between](#between)
        - [Not Between](#not-between)
        - [Is Null](#is-null)
        - [Is Not Null](#is-not-null)
    - [Custom Filters](#Custom-Filters)
    - [Conditional Filters](#Conditional-Filters)

## Describing the Problem

You have probably faced the situation where you needed to filter your query based on given parameters in url query-string and after developing the logics, You've had such a code:

```php
$users = User::latest();

if(request('username')) {
    $users->where('username', request('username'));
}

if(request('age')) {
    $users->where('age', '>', request('age'));
}

if(request('email')) {
    $users->where('email', request('email'));
}

return $users->get();

```

This works, But it's not a good practice.

When the number of parameters starts to grow, The number of these kind of `if` statements also grows and your code gets huge and hard to maintain.

Also it's against the Open/Closed principal of SOLID principles, Because when you have a new parameter, You need to get into your existing code and add a new logic (which may breaks the existing implementations).

So we have to design a way to make our filters logics separated from each other and apply them into the final query, which is the whole idea behind this package.

## Usage
1. First you need to install the package:

`$ composer require faridlab/laravel-grammatical-query`

2. Then you should `use` the `FilterQueryString` trait in your model, And define `$filters` property which can be consist of [available filters](#Available-Methods) or your [custom filters](#custom-filters).

```php
use GrammaticalQuery\FilterQueryString\FilterQueryString;

class User extends Model
{
    use FilterQueryString;

    protected $filters = [];

    ...
}
```
3. You need to use `filter()` method in your eloquent query. For example:

```php
User::select('name')->filter()->get();
```

### Available Methods
- [Sort](#Sort)
- [Comparisons](#Comparisons)
- [In](#In)
- [Like](#Like)
- [Where clause](#Where-Clause-Default-Filter)

**Filters**:
* [fields](#fields): `array ― optional`
* [search](#search): `string ― optional`
* [page](#page): `integer default(1) ― optional`
* [limit](#limit): `integer default(25) ― optional`
* [relationship](#relationship): `array ― optional`
* [withtrashed](#withtrashed): `boolean default(false) ― optional`
* [orderby](#orderby): `array ― optional`
* [fieldname[where]](#where): `string|array ― optional`
* [fieldname[orwhere]](#or-where): `string|array ― optional`
* [fieldname[eq]](#equal): `string|integer ― optional`
* [fieldname[notEq]](#not-equal): `string|integer ― optional`
* [fieldname[gt]](#greater-than): `string|integer ― optional`
* [fieldname[gtEq]](#greater-than-equal): `string|integer ― optional`
* [fieldname[lt]](#less-than): `string|integer ― optional`
* [fieldname[ltEq]](#less-than-equal): `string|integer ― optional`
* [fieldname[like]](#like): `string ― optional`
* [fieldname[notlike]](#not-like): `string ― optional`
* [fieldname[contain]](#contain): `string ― optional`
* [fieldname[notcontain]](#not-contain): `string ― optional`
* [fieldname[startwith]](#start-with): `string ― optional`
* [fieldname[endwith]](#end-with): `string ― optional`
* [fieldname[in]](#in): `array ― optional`
* [fieldname[notin]](#not-in): `array ― optional`
* [fieldname[between]](#between): `array ― optional`
* [fieldname[notbetween]](#not-between): `array ― optional`
* [fieldname[isnull]](#is-null): `string ― optional`
* [fieldname[isnotnull]](#is-not-null): `string ― optional`


| Query | Parameter | Note | SQL |
|---|---|---|---|
| AND | (where) | WHERE and | ...WHERE 1 = 1 *AND fieldname = {search}*... |
| OR | (orwhere) | WHERE or | ...WHERE 1 = 1 *OR fieldname = {search}*... |
| = | (eq) | EQual | ...WHERE *fieldname = {search}*... |
| > | (gt) | Greater Than | ...WHERE *fieldname > {search}*... |
| >= | (gtEq) | Greater Than EQual | ...WHERE *fieldname >= {search}*... |
| < | (lt) | Less Than | ...WHERE *fieldname < {search}*... |
| <= | (ltEq) | Less Than EQual | ...WHERE *fieldname <= {search}*... |
| != | (notEq) | NOT EQual | ...WHERE *fieldname != {search}*... |
| LIKE | (like) | LIKE | ...WHERE *fieldname LIKE {search}*... |
| LIKE %...% | (contain) | LIKE %...% | ...WHERE *fieldname LIKE %{search}%*... |
| LIKE startwith | (startwith) | LIKE startwith% | ...WHERE *fieldname LIKE {search}%*... |
| LIKE %endwith | (endwith) | LIKE %endwith | ...WHERE *fieldname LIKE %{search}*... |
| NOT LIKE | (notlike) | NOT LIKE | ...WHERE *fieldname NOT LIKE {search}*... |
| IN (...) | (in) | IN | ...WHERE *fieldname IN({search})*... |
| NOT IN (...) | (notin) | NOT IN | ...WHERE *fieldname NOT IN({search})*... |
| BETWEEN | (between) | BETWEEN | ...WHERE *fieldname BETWEEN {search} AND {search}*... |
| NOT BETWEEN | (notbetween) | NOT BETWEEN | ...WHERE *fieldname NOT BETWEEN {search} AND {search}*... |
| IS NULL | (isnull) | IS NULL | ...WHERE *fieldname IS NULL*... |
| IS NOT NULL | (isnotnull) | IS NOT NULL | ...WHERE *fieldname IS NOT NULL*... |
| ORDER BY | (orderby) | ORDER BY | ...ORDER BY *fieldname {orderby}*... |

For the purpose of explaining each method, Imagine we have such data in our `users` table:

| id  |   name   |           email            |  username  |  age | created_at
|:---:|:--------:|:--------------------------:|:----------:|:----:|:----------:|
|  1  | mehrad   | mehrad<i></i>@startapp.id  | mehrad123  |  20  | 2020-09-01 |
|  2  | reza     | reza<i></i>@startapp.id    | reza123    |  20  | 2020-10-01 |
|  3  | hossein  | hossein<i></i>@startapp.id | hossein123 |  22  | 2020-11-01 |
|  4  | dariush  | dariush<i></i>@startapp.id | dariush123 |  22  | 2020-12-01 |
|  5  | farid    | farid<i></i>@startapp.id   | faridlab   |  21  | 2021-03-12 |

And assume our query is something like this:

```php
User::filter()->get();
```

### Fields
```
fields: array|string ― optional
```
Convention:
```
> GET /api/v1/users?fields={fieldname}
> GET /api/v1/users?fields[]={fieldname1}
> GET /api/v1/users?fields[]={fieldname2}

> GET /api/v1/users?fields=name
> GET /api/v1/users?fields[]=name&fields[]=email
```

In Users.php
```php
protected $filters = ['fields'];
```
**Example**:
`https://startapp.id/api/v1/users?fields[]=name&fields[]=email`

### Search
```
search: string ― optional
```

Convention:
```
> GET /api/v1/users?search={fieldname}

> GET /api/v1/users?search=faridlab
```

In Users.php
```php
protected $filters = ['search'];
```
**Example**:
`https://startapp.id/api/v1/users?search=faridlab`

| id  |   name   |           email            |  username  |  age | created_at
|:---:|:--------:|:--------------------------:|:----------:|:----:|:----------:|
|  5  | farid    | farid<i></i>@startapp.id   | faridlab   |  21  | 2021-03-12 |

### Page
```
page: integer default(1) ― optional
```
Convention:
```
> GET /api/v1/users?page={page}

> GET /api/v1/users?page=1
```

In Users.php
```php
protected $filters = ['page'];
```
**Example**:
`https://startapp.id/api/v1/users?page=1`

### Limit
```
limit: integer default(25) ― optional
```
Convention:
```
> GET /api/v1/users?limit={limit}

> GET /api/v1/users?limit=25
```

In Users.php
```php
protected $filters = ['limit'];
```
**Example**:
`https://startapp.id/api/v1/users?limit=25`
### Relationship
```
relationship: array|string ― optional
```
Convention:
```
> GET /api/v1/users?relationship={relation}
> GET /api/v1/users?relationship[]={relation1}
> GET /api/v1/users?relationship[]={relation2}

> GET /api/v1/users?relationship=role
> GET /api/v1/users?relationship[]=role
> GET /api/v1/users?relationship[]=permissions
```

In Users.php
```php
protected $filters = ['relationship'];
```
**Example**:
`https://startapp.id/api/v1/users?relationship=role`

`https://startapp.id/api/v1/users?relationship[]=role&relationship[]=permissions`
### Withtrashed
```
withtrashed: boolean default(false) ― optional
```
Convention:
```
> GET /api/v1/users?withtrashed=true

> GET /api/v1/users?withtrashed=true
```

In Users.php
```php
protected $filters = ['withtrashed'];
```
**Example**:
`https://startapp.id/api/v1/users?withtrashed=true`

### Orderby
```
orderby: array|string ― optional
```
Orderby is the equivalent to `order by` sql statement which can be used flexible in `FilterQueryString`:

Conventions:
```bash
> GET /api/v1/users?orderby={fieldname}
> GET /api/v1/users?orderby[{fieldname}]={asc|desc}&orderby[{fieldname}]={asc|desc}

> GET /api/v1/users?orderby=name
> GET /api/v1/users?orderby[id]=desc&orderby[name]=asc
> GET /api/v1/users?orderby[id]=desc&orderby[name]=asc&orderby[email]=asc
```

In Users.php
```php
protected $filters = ['orderby'];
```
**Single `sort`**:

`https://startapp.id/api/v1/users?orderby=created_at`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@startapp.id  | mehrad123  |  20  | 2020-09-01 |
| reza     | reza<i></i>@startapp.id    | reza123    |  20  | 2020-10-01 |
| hossein  | hossein<i></i>@startapp.id | hossein123 |  22  | 2020-11-01 |
| dariush  | dariush<i></i>@startapp.id | dariush123 |  22  | 2020-12-01 |
| farid    | farid<i></i>@startapp.id   | faridlab   |  21  | 2021-03-12 |

- **Note** that when you're not passing parameter as array instead of string, it will be used as field name and order by 'asc' by default.

**Multiple `sort`s**:

`https://startapp.id/api/v1/users?orderby[name]=asc&orderby[email]=desc`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| dariush  | dariush<i></i>@startapp.id | dariush123 |  22  | 2020-12-01 |
| farid    | farid<i></i>@startapp.id   | faridlab   |  21  | 2021-03-12 |
| hossein  | hossein<i></i>@startapp.id | hossein123 |  22  | 2020-11-01 |
| mehrad   | mehrad<i></i>@startapp.id  | mehrad123  |  20  | 2020-09-01 |
| reza     | reza<i></i>@startapp.id    | reza123    |  20  | 2020-10-01 |

**Bare in mind** that `orderby` parameter with invalid values will be ignored from query and has no effect to the result.


### Where
```
fieldname[where]: string|array ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}={searchtext}
> GET /api/v1/users?{fieldname}[]={searchtext}
> GET /api/v1/users?{fieldname}[where]={searchtext}

> GET /api/v1/users?username=faridlab
> GET /api/v1/users?username[]=faridlab
> GET /api/v1/users?username[where]=faridlab
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username=faridlab`

`https://startapp.id/api/v1/users?username[]=faridlab`

`https://startapp.id/api/v1/users?username[where]=faridlab`

### Or where
```
fieldname[orwhere]: string|array ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[orwhere]={searchtext}
> GET /api/v1/users?{fieldname}[orwhere][]={searchtext}
> GET /api/v1/users?{fieldname}[orwhere][]={searchtext}

> GET /api/v1/users?username[where]=faridlab
> GET /api/v1/users?username[where][]=faridlab
> GET /api/v1/users?username[where][]=mehrad123
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[where]=faridlab`

`https://startapp.id/api/v1/users?username[where][]=faridlab`

`https://startapp.id/api/v1/users?username[where][]=mehrad123`

### Equal
```
fieldname[eq]: string|integer ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[eq]={searchtext}
> GET /api/v1/users?{fieldname2}[eq]={searchtext}

> GET /api/v1/users?username[eq]=faridlab&email[eq]=farid@startapp.id
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[eq]=faridlab&email[eq]=farid@startapp.id`

### Not Equal
```
fieldname[notEq]: string|integer ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[notEq]={searchtext}
> GET /api/v1/users?{fieldname2}[notEq]={searchtext}

> GET /api/v1/users?username[notEq]=faridlab&email[notEq]=farid@startapp.id
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[notEq]=faridlab&email[notEq]=farid@startapp.id`

### Greater Than
```
fieldname[gt]: string|integer ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[gt]={searchtext}

> GET /api/v1/users?id[gt]=10
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?id[gt]=10`

### Greater Than Equal
```
fieldname[gtEq]: string|integer ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[gtEq]={searchtext}

> GET /api/v1/users?id[gtEq]=10
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?id[gtEq]=10`
### Less Than
```
fieldname[lt]: string|integer ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[lt]={searchtext}

> GET /api/v1/users?id[lt]=10
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?id[lt]=10`

### Less Than Equal
```
fieldname[ltEq]: string|integer ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[ltEq]={searchtext}

> GET /api/v1/users?id[ltEq]=10
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?id[ltEq]=10`

### Like
```
fieldname[like]: string ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[like]={searchtext}

> GET /api/v1/users?username[like]=faridlab
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[like]=faridlab`

### Not Like
```
fieldname[notlike]: string ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[notlike]={searchtext}

> GET /api/v1/users?username[notlike]=faridlab
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[notlike]=faridlab`

### Contain
```
fieldname[contain]: string ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[contain]={searchtext}

> GET /api/v1/users?username[contain]=farid
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[contain]=farid`

### Not Contain
```
fieldname[notcontain]: string ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[notcontain]={searchtext}

> GET /api/v1/users?username[notcontain]=farid
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[notcontain]=farid`

### Start With
```
fieldname[startwith]: string ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[startwith]={searchtext}

> GET /api/v1/users?username[startwith]=farid
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[startwith]=farid`

### End With
```
fieldname[endwith]: string ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[endwith]={searchtext}

> GET /api/v1/users?username[endwith]=lab
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[endwith]=lab`

### In
```
fieldname[in]: array ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[in][]={searchtext}&{fieldname}[in][]={searchtext2}

> GET /api/v1/users?username[in][]=faridlab&username[in][]=farid
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[in][]=faridlab&username[in][]=farid`

### Not In
```
fieldname[notin]: array ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[notin][]={searchtext}&{fieldname}[notin][]={searchtext2}

> GET /api/v1/users?username[notin][]=faridlab&username[notin][]=farid
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?username[notin][]=faridlab&username[notin][]=farid`

### Between
```
fieldname[between]: array ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[between][]={searchtext}&{fieldname}[between][]={searchtext2}

> GET /api/v1/users?id[between][]=1&id[between][]=10
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?id[between][]=1&id[between][]=10`

### Not Between
```
fieldname[notbetween]: array ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[notbetween][]={searchtext}&{fieldname}[notbetween][]={searchtext2}

> GET /api/v1/users?id[notbetween][]=1&id[notbetween][]=10
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?id[notbetween][]=1&id[notbetween][]=10`

### Is Null
```
fieldname[isnull]: string ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[isnull]={null|''}

> GET /api/v1/users?deleted_at[isnull]=null
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?deleted_at[isnull]=null`

`https://startapp.id/api/v1/users?deleted_at[isnull]`

### Is Not Null
```
fieldname[isnotnull]: string ― optional
```
Convention:
```
> GET /api/v1/users?{fieldname}[isnotnull]={null|''}

> GET /api/v1/users?deleted_at[isnotnull]=null
```

In Users.php
```php
protected $filters = [];
```
**Example**:
`https://startapp.id/api/v1/users?deleted_at[isnotnull]=null`

`https://startapp.id/api/v1/users?deleted_at[isnotnull]`

### Where Clause (default filter)
Generally when your query string parameters are not one of previous available methods, It'll get filtered by the default filter which is the `where` sql statement. It's the proper filter when you need to directly filter one of your table's columns.

Conventions:

```
?field=value
?field1=value&field2=value
?field1[0]=value1&field1[1]=value2
?field1[0]=value1&field1[1]=value2&field2[0]=value1&field2[1]=value2
```

Assuming we want to filter `name`, `username` and `age` database columns, In Users.php
```php
protected $filters = ['name', 'username', 'age'];
```
**Example**:

`https://startapp.id?name=mehrad`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@startapp.id  | mehrad123  |  20  | 2020-09-01 |


**Example**:

`https://startapp.id?age=22&username=dariush123`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| dariush  | dariush<i></i>@startapp.id | dariush123 |  22  | 2020-12-01 |


**Example**:

`https://startapp.id?name[0]=mehrad&name[1]=dariush`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@startapp.id  | mehrad123  |  20  | 2020-09-01 |
| dariush  | dariush<i></i>@startapp.id | dariush123 |  22  | 2020-12-01 |

**Example**:

`https://startapp.id?name[0]=mehrad&name[1]=dariush&username[0]=mehrad123&username[1]=reza1234`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@startapp.id  | mehrad123  |  20  | 2020-09-01 |

**Bare in mind** that `default` filter parameter with invalid values will be ignored from query and has no effect to the result.

### Custom Filters
By custom filters you can define your own methods as filters. This helps with the Open/Closed of SOLID principles, Hence each time a new filter is needed, you don't have to edit previous filters and you can just write a separate method for it.

Let's create a custom filter. Assuming you want to create a filter named `all_except` which retrieves all users except the one that is specified:

In Users.php
```php
protected $filters = ['all_except'];

public function all_except($query, $value) {
    return $query->where('name', '!=', $value);
}
```
To test our newly added filter:

`https://startapp.id?all_except=mehrad`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| reza     | reza<i></i>@startapp.id    | reza123    |  20  | 2020-10-01 |
| hossein  | hossein<i></i>@startapp.id | hossein123 |  22  | 2020-11-01 |
| dariush  | dariush<i></i>@startapp.id | dariush123 |  22  | 2020-12-01 |

**Note** that your custom defined filters have the most priority which means you can even override available filters.

For example lets change `in` filter in a way that only accepts 3 values:

In Users.php
```php
protected $filters = ['in'];

public function in($query, $value) {

    $exploded = explode(',', $value);

    if(count($exploded) != 4) {
        // throwing an exception or whatever you like to do
    }

    $field = array_shift($exploded);

    return $query->whereIn($field, $exploded);
}
```

**Another** good example for custom filters are when you don't want to expose your database table's column name. For example assume we don't want to expose that we have a column named `username` in `users` table:

In Users.php
```php
protected $filters = ['by'];

public function by($query, $value) {
    return $query->where('username', $value);
}
```

`https://startapp.id?by=dariush123`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| dariush  | dariush<i></i>@startapp.id | dariush123 |  22  | 2020-12-01 |

#### Minor Tip
In order to prevent your model to get messy or populated with filter methods, You can create a trait for it and put everything about filters inside the trait.

### Conditional Filters
The `$filters` property in your model is acting kind of global for that model. It means when you use `filter()` method on your eloquent query, it'll always performs all the `$filters` filters.

There might be situations that based on a condition you need to specify which filters exactly you wish to be filtered.

To achieve this you can specify your desired filters as arguments in `filter()` method.

Example:

In your query:
```php
User::filter('in')->get();
```

`in=name,mehrad,reza&like=name,mehrad`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@startapp.id  | mehrad123  |  20  | 2020-09-01 |
| reza     | reza<i></i>@startapp.id    | reza123    |  20  | 2020-10-01 |

If the `in` argument was not specified, The result of query would be only one record (`mehrad`).

Another example:

In your query:
```php
User::filter('like', 'name')->get();
```

`like=name,mehrad,reza,dariush,hossein&name[0]=mehrad&name[1]=hossein&username=mehrad`

Output:

|   name   |           email            |  username  |  age | created_at
|:--------:|:--------------------------:|:----------:|:----:|:----------:|
| mehrad   | mehrad<i></i>@startapp.id  | mehrad123  |  20  | 2020-09-01 |
| hossein  | hossein<i></i>@startapp.id | hossein123 |  22  | 2020-11-01 |

### Manually Passing Filter Array (Livewire)
When using Livewire to filter data, subsequent query string changes do not trigger new requests. We can work around this by manually passing an array of filters.

Example:
```php
User::filter(['username' => 'mehrad123'])->get();
```

Another example:
```php
User::filter([
    'username' => [
        'contain' => 'medhrad',
    ],
    'email' => [
        'contain' => 'startapp.id',
     ]
])->get();
```

You can also combine this with conditional filters:
```php
User::filter([
    'username' => 'mehrad123',
    'email' => [
        'contains' => 'startapp.id'
    ]
], 'username')->get();
```

The above would only query the username (not the email) since only the username was included as a conditional.

**Note that the filter array must be passed before the conditionals.**
