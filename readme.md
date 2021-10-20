# XNABE API 

Hi! I'm Junior, a PHP developer and welcome to my secret project!

## Main Goal

Implement the xnabe API as simple as I could

## The Project Architecture 

I decided not to use any framework in order to have more freedom to show the architecture I planned in a more raw way.

Still, I used some third-party libraries to help me out.

- [FastRoute](https://github.com/nikic/FastRoute) to handle routes.
- [Symfony HttpFoundation](https://symfony.com/doc/current/components/http_foundation.html) handle http requests and responses
- [PHPUnit](https://github.com/sebastianbergmann/phpunit) to test code

My main focus was to decouple the layers of the system, so it could scale better and be safely maintained in the future.

For that I used the Repository-Service design pattern. The API data flow is:

> routes.php > Controller > Service > Repository > Database

I will let to give the full explanation of the code in the technical interview.

### Patterns

Some design patterns used:

- Repository-Service Pattern
- Dependency Injection
- Factory Method
- Data Transfer Object (DTO)
- Data Mapper
- Singleton

### Code Quality

To ensure code quality I used the following tools:

[PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer): Used to verify and apply the PSR12 standards.

    phpcs --standard=PSR12 /src
    phpcbf --standard=PSR12 /src

[PHP Mess Detector](https://github.com/phpmd/phpmd): Used to check potential problems with the code.

    phpmd src ansi cleancode,codesize,controversial,design,naming,unusedcode
    
[PhpStorm Code Inspections](https://www.jetbrains.com/help/phpstorm/code-inspection.html): Used to clean the code detecting unused imports, dead code, redundant variables, spelling problems and improve the overall code structure.

[SOLID Principles](https://en.wikipedia.org/wiki/SOLID): It's not a tool, but the code was written with these principles in mind.

## Thank you

Thanks for your time viewing my code. I look forward to talking with you guys.

[`#ItsPossible`](https://github.com/junior-neves/xnabe-api/)
