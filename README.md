# Farsi Request

As an Iranian developer you might end up having some users who use 
Arabic keyboard. These users may cause problems to your content 
or experience some confusion while searching among your
content. This package does two things for you:

1. __Replaces Arabic characters__ like ي ك ة ٤ ٥ ٦ with Farsi
characters like ی ک ه ۴ ۵ ۶, in all your requests parameters automatically.

2. __Automatically Converts Farsi or English Numbers__ in your desired 
request parameters to one another. For example:
    - Product names, like R2D2 should never have farsi numbers, right?
    - user's phone number


## Installation

You can install the package via composer:
``` bash
$ composer require mdaliyan/farsi-request
```

## Usage

#### 1. Auto-Replace arabic characters
To activate this, you should add this middleware to the kernel.
```php
// app/Http/Kernel.php

...
protected $middleware = [
    ...
   \Mdaliyan\FarsiRequest\Middleware\ReplaceArabicCharacters::class,
];
```

#### 2. Auto-Replace numbers in request parameters
To use this, you should add a trait and two private properties to your 
Request Class. Then add the parameters that should have farsi or 
english numbers to the desired property. 
    
```php
use Mdaliyan\FarsiRequest\Traits\ReplaceNumbers;

class SomeRequest extends FormRequest
{
    use ReplaceNumbers;

    private $mustHaveEnglishNumbers = ['id','email','phone_number'];
    private $mustHaveFarsiNumbers = ['post_content','author_name'];

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    ...
```

Note: The package ignores numbers inside HTML tags:

```html
    This line with the numbers 889 and an image: <img src="/media/media2.jpg">
    
     <!-- converts to: -->
    
    This line with the numbers ۸۸۹ and an image: <img src="/media/media2.jpg">
```
