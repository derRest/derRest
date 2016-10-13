<a target="_blank" href="https://gitter.im/derRest/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge"> ![Join the chat at https://gitter.im/derRest/Lobby](https://badges.gitter.im/derRest/Lobby.svg)</a>
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

## Tools and Frameworks

### Frontend

We are using <a href="http://materializecss.com"/>Marterial Design</a> as the overall design experience.
The Map-Design is going to be an own development.
For animations and physics the libary <a href="https://popmotion.io">PopMotion</a> will be used.
Highscore and DOM-Manipulation are going to made by some micro javascript framework

### Backend

PHP >= 7.0
We are using Composer for autoloading and Dependency management.  
We will use 
 - klein/klein as Router.  
 - catfan/medoo as Database Abstraction Layer.  
 - filp/whoops for nicer Error reporting.
 - sqlite as Database infrastructure.  

## Installation

1. clone it
2. composer install
3. open the website in that folder
