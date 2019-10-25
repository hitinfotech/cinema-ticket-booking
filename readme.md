## Laravel Cinema ticket booking ##

### Installation ###

* `git clone https://github.com/hitinfotech/cinema-ticket-booking projectname`
* `cd projectname`
* `composer install`
* `php artisan key:generate`
* Create a database and inform *.env*
* `php artisan migrate` to create and populate tables
* Inform *config/mail.php* for email sends
* `php artisan serve` to start the app on http://localhost:8000/

### Features ###

* Single Page Application
* Booking a ticket
* Cancel a ticket
* Send Confirm Mail
