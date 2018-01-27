[![Build Status](https://travis-ci.org/sqe-galerie/bildergalerie.svg?branch=develop)](https://travis-ci.org/sqe-galerie/bildergalerie)
[![Coverage](https://sonarcloud.io/api/badges/measure?key=sqe%3Abildergalerie&metric=coverage#.svg)](https://sonarcloud.io/dashboard?id=sqe%3Abildergalerie)
 [![Coverage](https://sonarcloud.io/api/badges/measure?key=sqe%3Abildergalerie&metric=new_coverage#.svg)](https://sonarcloud.io/dashboard?id=sqe%3Abildergalerie)
 
 

# Getting started

First install required dependencies with composer:

    php composer.phar install
    
Then setup the database and set the correct parameters in the `.env` file (see [.env.sample](./.env.sample)
for details).

# Getting started as developer

To run the application you can use [vagrant](https://www.vagrantup.com/) to set up the development environment.
 So first intall vagrant. Then you can start the environment by simply executing the following command
 (in the project root directory):
 
    vagrant up
    
This launches a virtual machine containing all necessary dependencies (nginx web server, mysql database, composer, etc.).
When the VM is running it will automatically sync the complete project folder with the VM's app directory.

After VM has been started you can access the application with your browser at [http://5.5.5.5](http://5.5.5.5).

## Reset local testing environment

If you want to reset your testing environemnt (database / uploads directory) simply execute the `reset-db` npm script:

    npm run reset-db
