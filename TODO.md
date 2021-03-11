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
* [ ] fieldname[notEq]: `string|integer ― optional`
<!-- LikeClauses -->
* [ ] fieldname[like]: `string ― optional`
* [ ] fieldname[contain]: `string ― optional`
* [ ] fieldname[startwith]: `string ― optional`
* [ ] fieldname[endwith]: `string ― optional`
* [ ] fieldname[notlike]: `string ― optional`
<!-- BetweenClauses -->
* [ ] fieldname[in]: `array ― optional`
* [ ] fieldname[notin]: `array ― optional`
* [ ] fieldname[between]: `array ― optional`
* [ ] fieldname[notbetween]: `array ― optional`
<!-- NullClauses -->
* [ ] fieldname[isnull]: `string ― optional`
* [ ] fieldname[isnotnull]: `string ― optional`