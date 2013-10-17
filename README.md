# Moved from Google Code

This project has been moved from [it's google code repository](https://code.google.com/p/dojocake/). The google repository is only there for legacy reasons, and because a lot of published articles still point to it.

## Introduction

DojoCake is a library of Helpers and Components for the PHP framework [CakePHP](http://cakephp.org). It was originally planned to just be a JavaScript helper to replace the built-in Prototype Framework support. When CakePHP released v1.3.x, they added support for JavaScript Engines. Seeing the potential to be much more than just a JavaScript Engine, DojoCake was changed to a library to support the entire Ajax experience using the Dojo Toolkit and the CakePHP framework. DojoCake now has support for Response Protocols, XHR Requests, Complete Dojo dependency management, and Dojo Widgets.


## Getting Started

The requirements to get the core of DojoCake up and running has be reduced down to 3 simple steps:

1. #### Step 1

   The first one is, of course, to copy the engine file (Helpers/dojo_engine.php) into your app's helper folder (app/views/helpers). 

2. #### Step 2
   
   Configure your controllers to use the JsEngine. You must place this code in what ever controllers you want to use the Engine. If you want all controllers to use the Engine (recommended), then place this code in your app_controller.php file:
   ```php
    $helpers = array('Js'=>array('Dojo'));
   ```

3. #### Step 3
   
   Start up the Engine. In all the layouts you wish to use the Engine in, place this line of code in the header, specifying configuration including the Dijit theme you wish to use. The default theme is Tundra. *NOTE: IT MUST BE THE FIRST CODE YOU CALL IN THE HEADER, AFTER THE TITLE.*
    ```php
    <head>
         <title>Title Here</title>
         <?php
              $this->Js->start(array('theme'=>'soria'));
         ?>
    </head>
    ```



## Dojo.require()

The **dojo.require()** function is a heavily used function to import Dojo classes to a page. You use this function every time you want to use a widget or any other functionality of Dojo not included in the core file. Using CakePHP, you could end up having script tags scattered all across your page, reducing optimization and making it hard to sift through all the HTML. DojoCake solves this problem beautifully.

### DojoCake's Solution
DojoCake solved this problem with the ```$js->req()``` function. By passing the required module as a string to this function, DojoCake automatically writes up the script block and places it in a buffer. This buffer is then written to the ```$scripts_for_layout``` variable. This allows you to control where these are outputted to. And, just in case you want the function to return the script block to you, you can pass **true** as a second argument.

### Examples

In a view file:
```php
<?php $js->req('dijit.form.Button'); ?>
<button dojoType="dijit.form.Button">Click Me!</button>
```

In your Layout:
```php
<html>
     <head>
          <title>DojoCake Examples</title>
          <?php echo $js->start(array('theme'=>'soria')); ?>
          <?php echo $scripts_for_layout; ?>
     </head>
     <body>
          <?php echo $content_for_layout; ?>
     </body>
</html>
```



## Finished!
That's it! Now you can start using the DojoCake core. But the core is only half the library. By copying over all the helpers and components, you can harness the full potential of DojoCake!