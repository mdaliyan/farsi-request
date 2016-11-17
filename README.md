# Farsi Request

As an Iranian developer you might end up having some users who use 
Arabic keyboard. These users may cause problems to your content 
or experience some confusion while searching among your
content. This package does two things for you:

- Replaces Arabic characters like ي ك ة ٤ ٥ ٦ with Farsi
characters like ی ک ه ۴ ۵ ۶, in all your requests parameters automatically.

- Makes you able to define which request parameters must have
Farsi numbers which must have English numbers. <br/><br/> For example, Product names like R2D2 should never have farsi numbers, right?

## Installation

You can install the package via composer:
``` bash
$ composer require mdaliyan/farsi-request
```

## Usage

##### Automatic character replacement
To achieve this, you should add this middleware to the kernel.
```php
// app/Http/Kernel.php

...
protected $middleware = [
    ...
   \Mdaliyan\FarsiRequest\Middleware\ReplaceArabicCharacters::class,
];
```

##### Define language characters for request parameters
To achieve this, you should add a trait and two private properties to your Request Class.
Then add your parameters to these properties.

```php
use Mdaliyan\FarsiRequest\Traits\ReplaceNumbers;

class SomeRequest extends FormRequest
{
    use ReplaceNumbers;

    private $mustHaveEnglishNumbers = ['id','email'];
    private $mustHaveFarsiNumbers = ['post_content','author_name'];

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
```
This functionality skips characters inside HTML tags.
<br/>for example, if your "post_content" has something like
\<img src="/media/media2.jpg"\>, it won't change the number.


