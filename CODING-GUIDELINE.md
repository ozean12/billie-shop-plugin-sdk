# Coding Guideline for Plugin Developers

This guideline should be used by plugin developers to enforce a consistent coding style through all plugins using the Billie SDK/API.
The goal is to deliver fast-to-understand and easy-to-maintain code.

## General
- Unix-like newlines (Line Feed/LF, \n) (PSR-2)
- 4 spaces for indenting, not tabs (PSR-2)
- UTF-8 File encoding (PSR-1)

## PHP Coding Standard
Please use the following Coding Standards in your project:
- [PSR-1: Basic Coding Standard](http://www.php-fig.org/psr/psr-1/)
- [PSR-2: Coding Style Guide](http://www.php-fig.org/psr/psr-2/)

You can automatically check and fix the coding style with [php-cs-fixer](http://cs.sensiolabs.org/):
```
./vendor/bin/php-cs-fixer fix -v
```
The configuration for php-cs-fixer can be found in [/.php_cs.dist](.php_cs.dist).

### Class name resolution standard

For class name resolution, use the ::class keyword instead of a string literal for every class name reference outside of that class. This includes references to:

- Fully qualified class name
- Imported/non-imported class name
- Namespace relative class name
- Import relative class name

Examples:

```php
$this->get(ClassName::class);
```  

```php
$this->get(\Magento\Path\To\Class::class);
```
  
  
## Naming Conventions

In general, use whitelabelled names and prefixes in your namespaces, classes, variables and prefixes.
Please **refrain** from using your agency/company/organization name in your code.

- For **DATABASE** tables use the prefix: `billie_`  

- Use camelCase Notation for _variables_, _classes_ and _methods_ (e.g. `referenceId`, )
