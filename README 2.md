#Tastery 

Tastery, An we app is a rebranded website for Fresh Dish, where customers can book a chef for an occassion. Users will be charged with respect to their menu preferences and the type of the event. Its been developed in yii framework(php) v1.1.8.
Tastery, being backed by one of the known incubators called [Science Inc](http://www.science-inc.com) which currently serves to the customers in and around Los Angeles area.

##Installation prerequisites

* The source code to Tastery is managed via Git, a version control system developed by Linus Torvalds to host the Linux kernel. 
* GD/Imagemagik library for image processing on the hosting server( By default AWS servers comes with it)/ for local setup need to be installed. For mac we recommend homebrew to install gd library.

##Initial setup
### db : 
* Export tasterylive.sql file to the db, also the tasteryliveseed.sql file for initial seed data to get your project up and runnimg
* Change the setting in config/main.php to connect to the corresponding db (local/remote)

### Extensions :
* SMTPMail : Configured to use Mandrill app through smtp.
* PasswordHash : To Hash the password of the users
* EUploadedImage: Image uploading extension.
* IWI : To crop and resize images, supports GD or imagemagick library.

### Vendors:
    #### AWS SDK: 
    * Configure the AWS keys on config.inc.php file.
    * Image upload to the bucket 'tasteryimages' which has to be made publicy accesible.

    #### Stripe:
    * Stripe payment api's, to make an successful payment.
    * Keys can be configured in the db table settings. Name: StripeApi key: <apitestkey>/<apilivekey> as needed 
