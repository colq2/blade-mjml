# Blade Mjml
This project is about creating a port of mjml to blade (php and laravel). The goal is to have a running mjml version purely in php and blade.

Your task is to transform all necessary files from mjml which is written in javascript to php.

We want to get as close as possible to the original mjml.

## Coding Standards
* Use PHP v8.3 and php v8.4 features.
* Enforce strict types and array shapes via PHPStan.

## Comments
* All code and comments must be in english. This is very important, never deviate from this.

## Testing
* Use Pest PHP for all tests.
* Run composer lint after changes.
* Don’t remove tests without approval.
* All code must be tested.

## mjml components

* implement all mjml components as blade components
* the directory for the components is src/Components
* We have temporarly added mjml source code do src/js/mjml for better context
* We mapping some of the core mjml code to out folder:
* mjml-core/src/helper -> src/Helpers
* mjml-core/src/types -> src/Types
* We use php classes instaed of javascript functions. The name of the class is the same as the function name in javascript. The class contains the same methods as the javascript function.


## Relevant information for porting components

Instead this.attributes we must use $this->_attributes because blade components define their own attributes

Instead of render() we must use renderMjml() because we have to wrap the render function in parent component to be able to provide child context.

Instead of this.context we need to use $this->context() as function
The same counts for allowedAttributes and componentName: $this->allowedAttributes() and $this->componentName()

If we render the child we can just use {{ $slot }} because it is blade.

If we have a head component we can always use the renderMjml function instead of handler