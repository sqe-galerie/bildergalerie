# Getting started

First install required dependencies with composer:

    php composer.phar install
    
Then setup the database and set the correct parameters in the local.php file (see [local_sample.php](./local_sample.php)
for details).

# Getting started as developer

To run the application you can use [vagrant](https://www.vagrantup.com/) to set up the development environment.
 So first intall vagrant. Then you can start the environment by simply executing the following command
 (in the project root directory):
 
    vagrant up
    
This launches a virtual machine containing all necessary dependencies (nginx web server, mysql database, composer, etc.).
When the VM is running it will automatically sync the complete project folder with the VM's app directory.

After VM has been started you can access the application with your browser at [http://5.5.5.5](http://5.5.5.5).