# Contributing

First of all, **thank you** for contributing, **you are awesome**!

This project uses the fork & pull model of development. This means that in order to contribute
you need to submit a [pull request](https://help.github.com/articles/using-pull-requests/).

Please make an issue about what you intent to make before you create the pull request and reference that issue from your pull request.

Here are a few rules to follow in order to ease code reviews and discussions before
maintainers accept and merge your work:

* [Consider versioning](#versioning)
* [Follow the coding standards](#coding-standards)
* [Run and update the tests](#running-and-updating-test-suite)
* [Document your work](#documenting-your-work)

Please [rebase your branch](http://git-scm.com/book/en/Git-Branching-Rebasing)
before submitting your Pull Request. One may ask you to [squash your
commits](http://gitready.com/advanced/2009/02/10/squashing-commits-with-rebase.html)
too. This is used to "clean" your Pull Request before merging it (we don't want
commits such as `fix tests`, `fix 2`, `fix 3`, etc.).

## Versioning
We use semver, please take that into account. Randomly breaking BC is not an option. 
Please use the [Symfony BC promise](http://symfony.com/doc/current/contributing/code/bc.html) as a guideline of we consider BC.

## Coding standards
You MUST follow the [PSR-1](http://www.php-fig.org/psr/1/), 
[PSR-2](http://www.php-fig.org/psr/2/).

To fix your code according to the project standards, you can run
[PHP-CS-Fixer tool](http://cs.sensiolabs.org/) before commit: 
```bash
php-cs-fixer fix --level psr2 .
```

## Running and updating test suite
* You MUST run the test suite.
* You SHOULD write (or update) unit tests for any other non-trivial functionality.

Test suite can be run using the following command:
```bash
vendor/bin/phpunit
```

## Documenting your work
You SHOULD write documentation for the code you add.

Also, please, write [commit messages that make
sense](http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html).
While creating your Pull Request on GitHub, you MUST write a description
which gives the context and/or explains why you are creating it.

Thank you!
