[![Join the chat at https://gitter.im/derRest/Lobby](https://badges.gitter.im/derRest/Lobby.svg)](https://gitter.im/derRest/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://travis-ci.org/derRest/derRest.svg?branch=master)](https://travis-ci.org/derRest/derRest)
[![Code Climate](https://codeclimate.com/github/derRest/derRest/badges/gpa.svg)](https://codeclimate.com/github/derRest/derRest)
[![Test Coverage](https://codeclimate.com/github/derRest/derRest/badges/coverage.svg)](https://codeclimate.com/github/derRest/derRest/coverage)
# derRest
## LICENSE
MIT or
````
/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* derRest wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return
* derRest
* ----------------------------------------------------------------------------
*/
````
##Type of application
This app will be a little maze game, where the user will be able to navigate through the maze to find the exit in lots of random generated levels.


## Tools and Frameworks

### Frontend

We are using <a href="http://materializecss.com"/>Marterial Design</a> as the overall design experience.
The Map-Design is going to be an own development.
For animations  the libary <a href="http://jquery.com/">jQuery</a> is used as are
Highscore and DOM-Manipulation

### Backend

PHP >= 7.0
We are using Composer for autoloading and Dependency management.  
We will use 
 - klein/klein as Router.  
 - catfan/medoo as Database Abstraction Layer.  
 - filp/whoops for nicer Error reporting.
 - sqlite as Database infrastructure.  

## Installation

1. clone repository
2. composer install
3. npm install
3. open the website in that folder

Alternatively you can access the game at https://lab.cben.co/derRest/


## Tests
###Verteilung

 - ✔ Höhe Breite überprüfen (3) Julia
 - ✔ Zeichen überprüfen (1) Jan
 - ✔ Lösbarkeit prüfen (1) Chris
 - ✔ Candys überprüfen (3) Flo
 - ✔ Unterschied zwischen 2 Laybrinthen prüfen (1) Matze
 - ✔ Highscore eintragen prüfen (1) Matze
 
###Ausführen der Tests
 1. composer install
 2. composer test
