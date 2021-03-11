TODO:
* [X] fields: `array ― optional`
* [X] search: `string ― optional`
* [X] page: `integer default(1) ― optional`
* [X] limit: `integer default(25) ― optional`
* [X] relationship: `array ― optional`
* [X] withtrashed: `boolean default(false) ― optional`
* [X] orderby: `array ― optional`

* [X] fieldname[where]: `string|array ― optional`
* [X] fieldname[orwhere]: `string|array ― optional`
<!-- ComparisonClauses -->
* [X] fieldname[eq]: `string|integer ― optional`
* [X] fieldname[gt]: `string|integer ― optional`
* [X] fieldname[gtEq]: `string|integer ― optional`
* [X] fieldname[lt]: `string|integer ― optional`
* [X] fieldname[ltEq]: `string|integer ― optional`
* [X] fieldname[notEq]: `string|integer ― optional`
<!-- LikeClauses -->
* [X] fieldname[like]: `string ― optional`
* [X] fieldname[notlike]: `string ― optional`
* [X] fieldname[contain]: `string ― optional`
* [X] fieldname[notcontain]: `string ― optional`
* [X] fieldname[startwith]: `string ― optional`
* [X] fieldname[endwith]: `string ― optional`
<!-- BetweenClauses -->
* [X] fieldname[in]: `array ― optional`
* [X] fieldname[notin]: `array ― optional`
* [X] fieldname[between]: `array ― optional`
* [X] fieldname[notbetween]: `array ― optional`
<!-- NullClauses -->
* [X] fieldname[isnull]: `string ― optional`
* [X] fieldname[isnotnull]: `string ― optional`