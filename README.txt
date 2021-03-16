
README.txt

DATABASE CONFIG:

    1. CREATE TABLE AS DEMANDED
    2. TRIGGER ADDED TO UPDATE updated_at=TIMESTAMP
        "CREATE TRIGGER `update_time` BEFORE UPDATE ON `product`
        FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP"
    3. ALTER TABLE `product` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP; 
    4. ALTER TABLE `product` CHANGE `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP; 

This is a CRUD for a product table. It is ment for a job
aplication.

It is divided in classes:

    1- Controller- Attends the http request. (PHP)
    2- Service- Recives data through $_REQUEST and executes SQL (PHP)
    3- Repository+driver- Manages the database, based on PDO-mysqli
    4- Main resource (product.php)- It initializes an instance of the controller.

It has a unit test for each class. The deepest test is executed in driverDB,
driverDB prevents SQL injections and wrong data format but it does not prevent from content itself.
Name and description fields can be recorded with any data so the field is going to be recorded
as string.
Other test are softer, check comunications between classes.

To configure the database modify the file named "config.php".

REST API tested with Postman:

GET:localhost/ferrerMtest/public/product.php?id=60
POST:localhost/ferrerMtest/public/product.php?name=producto1&description=descripcion 1&price=100
PUT:localhost/ferrerMtest/public/product.php?name=producto1&description=descripcion 1&price=100&id=60
DELETE:localhost/ferrerMtest/public/product.php?id=60

all services respond well!!