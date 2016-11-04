# Nginx-log-parser

 * This application provides a script as a service which parses nginx log and outputs an html grid.
 * It is possible to display only the IPs from a specific country. The country abbreviation is provided as a paramets to the service.
 * Sort and search functionalities, based on AngularJS, are also available in the html grid.
 * An example of Nginx log file is provided in **nginx-example.log** file.
 

## Installation & Usage
  > To run this application into a docker environment you need to install [Docker Engine](https://docs.docker.com/engine/installation/) in case that it is not already installed and to run the following command. If you don't use a docker environment, just skip step 5.
  
  1. After docker environment is installed follow next steps:
  2. run ``` git clone https://github.com/ovidiuj/Nginx-log-parser ```
  3. go to project folder ``` cd Nginx-log-parser ```
  4. run ``` docker-compose up -d ```
  5. run ``` composer update ```
  6. run ``` vendor/bin/phpunit ```
  7. go to ``` http://nginx-log.dev:8080/ ```

