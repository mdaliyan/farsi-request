# Farsi Request

This package does 2 things so far.

- Replaces invalid Arabic characters like ي ك ة ٤ ٥ ٦ with valid Farsi
characters like ی ک ه ۴ ۵ ۶, in all your requests automatically.
- Makes you able to define which request parameters should have
Farsi numbers which should have English numbers.

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
   \Mdaliyan\FarsiRequest\Middleware\PipeStrings::class,
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
    private $mustHavePersianNumbers = ['post_content','author_name'];

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


