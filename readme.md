<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## SQL tasks
1. Get all statuses, not repeating, alphabetically ordered
```php
SELECT DISTINCT status
FROM tasks
ORDER BY status;
```
2. Get the count of all tasks in each project, order by tasks count descending\
```php
SELECT projects.id as project, COUNT(tasks.id) AS task_quantity 
FROM tasks RIGHT JOIN projects ON tasks.project_id = projects.id 
GROUP BY project 
ORDER BY task_quantity DESC
```
3. Get the count of all tasks in each project, order by projects names
```php
SELECT projects.name as project, COUNT(tasks.id) AS task_quantity 
FROM tasks RIGHT JOIN projects ON tasks.project_id=projects.id 
GROUP BY project 
ORDER BY project
```
4. Get the tasks for all projects having the name beginning with “N” letter
```php
SELECT projects.name as project, tasks.name as task 
FROM tasks INNER JOIN projects ON tasks.project_id=projects.id 
WHERE tasks.name LIKE 'N%'
```
5. Get the list of all projects containing the ‘a’ letter in the middle of the name, and
   show the tasks count near each project. Mention that there can exist projects without
   tasks and tasks with project_id=NULL
```php
SELECT projects.name as project, COUNT(tasks.id) AS task_quantity 
FROM projects LEFT JOIN tasks ON tasks.project_id = projects.id 
WHERE projects.name LIKE '_%a%_' 
GROUP BY projects.id
```
6. Get the list of tasks with duplicate names. Order alphabetically
```php
SELECT name as repeated 
FROM tasks
GROUP BY name
HAVING COUNT(*)>1
```
7. Get the list of tasks having several exact matches of both name and status, from
   the project ‘Garage’. Order by matches count.
```php
SELECT tasks.name, tasks.status, COUNT(tasks.name) as counter 
FROM tasks INNER JOIN ( 
    SELECT * FROM tasks 
) as duplicate ON tasks.id = duplicate.id 
WHERE tasks.project_id = ( 
    SELECT id FROM projects WHERE name = 'Garage' 
) 
AND tasks.name = duplicate.status 
GROUP BY tasks.name, tasks.status 
ORDER BY counter
```
8. Get the list of project names having more than 10 tasks in status ‘completed’. Order
   by project_id
```php
SELECT projects.name as project, COUNT(tasks.id) as quantity  
FROM tasks INNER JOIN projects ON projects.id = tasks.project_id 
WHERE tasks.status = 'completed' 
GROUP BY project 
HAVING COUNT(quantity)>10 
ORDER BY project
```