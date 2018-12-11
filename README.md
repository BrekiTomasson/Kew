# `BrekiTomasson/Kew`

## Step the First:

`~/your_projects/folder>` **`composer install brekitomasson/kew`**

## Step the Second:

```
<?php

use BrekiTomasson\Kew;

class StrategicallyNamedClassNameNamer extends HotDogEatingScheduleGenerator {

  public function getDefaultColorsListFunctionMethod()
  {
    $colorList = new Kew();
    $colorList->add('red', 'green', 'blue');
    return $colorList;
  }

}
```

## Step the Third:

```
$foo = new StrategicallyNamedClassNameNamer();
$bar = $foo->getDefaultColorsListFunctionMethod();
$bar->next();
> 'red'
$bar->next();
> 'red'
$bar->get();
> 'red'
$bar->get();
> 'green'
$bar->size();
> 1
$bar->add('yellow');
$bar->size();
> 2
$bar->next();
> 'blue'
$bar->last()
> 'yellow'
```

# Description & Syntax

> Note: I use the term "list" in several places in this document. In most cases,
> this just means an instantiation of the `Kew` object. However, since `Kew` can
> be used both as a Queue and as a Stack, I'm using the more generic 'list' for
> both.

All in all, this is an extremely straight-forward package. Simply instantiate a
new `Kew` (Yes, pronounced like "queue". I know, so very clever...) object into
a variable, and you will have the following methods at your disposal:

* `add()` - Adds one or more items to the list, in the order you list them.
* `push()` - Same as `add()`.
* `get()` - Gets the next item in line from the list, removing it from the list.
* `pop()` - Same as `get()`.
* `next()` - Shows you what the next value in the list is without removing it.
* `top()` - Same as `next()`.
* `size()` - Gives you the number of items in the list.
* `isEmpty()` - Returns true/false depending on if `size()` is `0` or not.
* `last()` - Shows you what the last value in the list is at this moment.
* `bottom()` - Same as `last()`.

# Philosophy & Limitation

- The only values you have access to are the first and last items on the list.
- You can only add new values to the end of the list.
- You can only remove values from the beginning of the list.
- You can only remove one value at a time from the list.
- You cannot add items to the list on creation, all lists are created empty.
- You can view the size of the list, but **not** its contents (except of course,
  the first and last items in the list).
- Values in the list must be of the same type, as determined by the first item
  added to the list.
- Rules are meant to be broken, so most of the things on the list above have an
  exception which you can access through the options.

# Stacks and Queues

Imagine the following two scenarios.

# Options

Despite lists being a fairly straight-forward data type, there are a couple of
things that you can change during construction of your list - **only** during
construction. To set any of these values, pass an associative array during
construction of the list containing one or more of these values:

- `typed` - Boolean (Default `true`). Enforces Type locking based on the first
  item added to the list. Passing `false` here will allow you to add items of
  different types to the list.
- `nextable` - Boolean (default `true`). Allows you to 'next()' the list, giving
  you the next item without removing it. Passing `false` here will disable the
  `next()` method.
- `lastable` - Boolean (default `true`). Allows you to 'last()' the list, giving
  you the last item without removing it. Passing `false` here will disable the
  `next()` method.
- `sizeable` - Boolean (default `true`). Allows you to `size()` the list.
  Passing `false` here will no longer allow you to see the size of the list.
- `stack` - Boolean (default `false`). Passing `true` reverses the order of
  processing, turning the list from **First** in, First out to **Last** in,
  First out.
- `readable` - Boolean (default `true`). Grouping of `nextable`, `lastable` and
  `sizeable`. Passing `false` here is like passing `false` to those three and
  will limit you to only `add` and `get` values.
