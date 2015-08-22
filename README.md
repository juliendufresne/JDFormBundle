# JD Form Bundle

## Installation

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require juliendufresne/form-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new JD\FormBundle\JSFormBundle(),
        );

        // ...
    }

    // ...
}
```

## Project Status

[![Latest Stable Version](https://poser.pugx.org/juliendufresne/form-bundle/version)](https://packagist.org/packages/juliendufresne/form-bundle) [![Latest Unstable Version](https://poser.pugx.org/juliendufresne/form-bundle/v/unstable)](//packagist.org/packages/juliendufresne/form-bundle) [![Total Downloads](https://poser.pugx.org/juliendufresne/form-bundle/downloads)](https://packagist.org/packages/juliendufresne/form-bundle)

| Project Version     | Build                                   | Code coverage                                  | Code Quality                                  |
|:-------------------:|:---------------------------------------:|:----------------------------------------------:|:---------------------------------------------:|
| [Master][100]       | [![Travis][110]][111]                   | [![coveralls][120]][121]                       | [![scrutinizer][130]][131] [![Insight][1]][2] |


[1]: https://insight.sensiolabs.com/projects/194bd583-92a2-499a-add9-c6b3717fc4d2/mini.png
[2]: https://insight.sensiolabs.com/projects/194bd583-92a2-499a-add9-c6b3717fc4d2

[100]: https://github.com/juliendufresne/form-bundle
[110]: https://travis-ci.org/juliendufresne/JDFormBundle.svg?branch=master
[111]: https://travis-ci.org/juliendufresne/JDFormBundle
[120]: https://coveralls.io/repos/juliendufresne/JDFormBundle/badge.svg?service=github&branch=master
[121]: https://coveralls.io/github/juliendufresne/JDFormBundle?branch=master 
[130]: https://scrutinizer-ci.com/g/juliendufresne/JDFormBundle/badges/quality-score.png?b=master
[131]: https://scrutinizer-ci.com/g/juliendufresne/JDFormBundle/?branch=master
