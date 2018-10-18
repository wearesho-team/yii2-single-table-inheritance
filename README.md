# Yii2 Single Table Inheritance
[![Build Status](https://travis-ci.org/wearesho-team/yii2-single-table-inheritance.svg?branch=master)](https://travis-ci.org/wearesho-team/yii2-single-table-inheritance)
[![codecov](https://codecov.io/gh/wearesho-team/yii2-single-table-inheritance/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/yii2-single-table-inheritance)

This library allows you to implement several models that refer to single table
(f.e. table - contact, models - phone, email, skype etc.).

## Setup

```bash
composer require wearesho-team/yii2-single-table-inheritance
```
 
## Usage

Create base model that implements table`s representation

```php
<?php

use Wearesho\Yii\SingleTableInheritance;

/**
 * Class Contact
 * @property string $type
 * @property string $value
 */
class Contact extends SingleTableInheritance\ActiveRecord
{
    public const PHONE = 'phone';
    public const EMAIL = 'email';

    protected static $inheritanceField = 'type';

    public function rules(): array
    {
        return [
            [
                ['type', 'value',],
                'required',
            ],
            [
                ['value',],
                'string',
            ],
        ];
    }
}

```

Then you need to declare this model's children and override `$inheritanceFieldValue` in each

```php
<?php

class Phone extends Contact
{
    protected static $inheritanceFieldValue = Contact::PHONE;
}
```

```php
<?php

class Email extends Contact
{
    protected static $inheritanceFieldValue = Contact::EMAIL;
}
```

Then you can create representations' instances, and property that is declared in `$inheritanceField`,
will be set automatically according to instance's declaration

```php
<?php

$email = new Email(['value' => 'test@gmail.com']);

assert($email->type === Contact::EMAIL);

``` 

## License
[MIT](./LICENSE)

