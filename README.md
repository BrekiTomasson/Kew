# `BrekiTomasson/Kew`

A simple little package to help you set up and handle Last In-First Out and Last In-Last Out scenarios.

## Step The First:

`~/your_projects/folder>` **`composer require brekitomasson/kew`**

## Step The Second:

```
$foo = new BrekiTomasson\Kew\Kew();
$foo->add('red');
$foo->add('blue');
$foo->add('green);
$foo->next();
> 'red'
$foo->next();
> 'red'
$foo->get();
> 'red'
$foo->get();
> 'green'
$foo->size();
> 1
$foo->add('yellow');
$foo->size();
> 2
$foo->next();
> 'blue'
$foo->last();
> 'yellow'
$foo->get();
'yellow'
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
* `push()` - Alias for "`add()`".
* `get()` - Gets the next item in line from the list, removing it from the list.
* `pop()` - Alias for "`get()`".
* `next()` - Shows you what the next value in the list is without removing it.
* `top()` - Alias for "`next()`".
* `last()` - Shows you what the last value in the list is at this moment.
* `bottom()` - Alias for "`last()`".
* `size()` - Gives you the number of items in the list.
* `isEmpty()` - Returns true/false depending on if `size()` is `0` or not.

Or, to visualize it a little differently:

- Creative: `add()` / `push()`.
- Destructive: `get()` / `pop()`.
- Non-destructive: `next()` / `top()` and `last()` / `bottom()`
- State: `size()` and `isEmpty()` 

# Philosophy & Limitations

- The only values you have access to are the first and last items on the list.
- You can only add new values to the end of the list.
- You can only remove values from the beginning of the list.
- You can only remove one value at a time from the list.
- You cannot add items to the list on creation, all lists are created empty.
- You can view the size of the list, but **not** its contents (except of course,
  the first and last items in the list).
- Values in the list must be of the same type, as determined by the first item
  added to the list. (See Options for an exception to this rule)

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

# Examples, AKA "Stacks and Queues"

Imagine the following two scenarios:

## Example 1 - Queue

You're building an app to automate the processing and prettification of user's
pictures before they post them to an online service. Unfortunately, despite the
fast network speeds that allow people to upload hundreds of pictures in just a
minute, the processing takes about a minute per picture. Instead of having to
wait for all pictures to be done, you want to make them available to the user 
as processing finishes each picture.

Enter `Kew`! To get this to work, you could do something like this:

- You've decided that only ten workers can be active at a time due to CPU/RAM
  available to you, so you set up an `isBusy()` method that returns `true` if
  there are ten active processing sessions available.
- You then refactor everything calling `startProcessing($image)` method to
  instead call the `addToProcessingQueue($image)` method. All it does, in 
  turn, is `add()` to its own `Kew` object.
- You then refactor the processing job to no longer be called from an outside
  method. Instead, it runs on a schedule, which fires once a second, calling
  code like:
  
```php
if ($this->isBusy()) {
    return false;
} else {
  if ($this->kewObject->isEmpty()) {
      return false;
  } else {
      $this->startProcessing($this->kewObject->get());
  }
}
```

... or, more simply:

``` 
if (!$this->isBusy() && !$this->kewObject->isEmpty()) {
    $this->startProcessing($this->kewObject->get());
}
```

## Example 2 - Stack

You're expanding the social aspects of your picture processing tool by allowing
people to navigate pictures posted by other users. It's easy to navigate to a
new user or new picture, of course, but you need some way for users to go back
in their navigation history ...

Enter `Kew`! Every time a user starts a session, they're assigned a new `Kew`
object, instantiated with the option `['stack' => true]`. Whenever they click
to another page in the app, the current page (the one that they are leaving, 
not the one that they are navigating to) is `add()`:ed to the stack. Then, if
they ever need to go back, all you need is to `get()` from the stack. If they
want to continue backwards, just continue to `get()` from the stack until they
are where they want to be.

# TODO / Future development

- [ ] Implement the stack functionality.
- [ ] Implement a 'max size' feature (off by default) with these options:
- [ ] If max size is reached, return exception.
- [ ] If max size is reached, bump item from queue/stack.
