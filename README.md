# Farsi Request

[![Build Status](https://travis-ci.org/mdaliyan/farsi-request.svg?branch=master)](https://travis-ci.org/mdaliyan/farsi-request)
[![License](https://poser.pugx.org/mdaliyan/farsi-request/license)](https://packagist.org/packages/mdaliyan/farsi-request)

Farsi Request replaces arabic characters like **ي ك ة ٤ ٥ ٦** with Farsi
characters like **ی ک ه ۴ ۵ ۶** in all your requests parameters automatically.

If you are building a farsi website you might end up having some users 
who use Arabic keyboard. These users may cause problems to your content 
or experience some confusion while searching among your content. 

### Tested 
`farsi-request` is tested on laravel 5.x && 6.x

### Features
This package does two things for you:

1. __Replaces Arabic characters with farsi standard characters__

2. __Automatically Converts Farsi or English Numbers to each other__ in your desired 
request parameters to one another. For example:
    - Product names, like R2D2 should never have farsi numbers, right?
    - user's phone number

## Install

````bash
$ composer require mdaliyan/farsi-request
````

## Usage

#### 1. Auto-Replace arabic characters
Add this middleware to your kernel file `app/Http/Kernel.php`
````php
protected $middleware = [
    ...
   \Mdaliyan\FarsiRequest\Middleware\ReplaceArabicCharacters::class,
];
````

#### 2. Auto-Replace numbers in request parameters
Add this trait and two private properties to your Request Class. 
Then add the parameters that should have farsi or 
english numbers to the desired property. 
    
````php
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
````

Note: this feature ignores numbers inside HTML tags:

````html
    This line with the numbers 889 and an image: <img src="/media/media2.jpg">
    
     <!-- will be converted to: -->
    
    This line with the numbers ۸۸۹ and an image: <img src="/media/media2.jpg">
````
