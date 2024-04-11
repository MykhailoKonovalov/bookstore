# BookStore

A pet project that is an imitation of a bookstore website.

### How to setup project in local environment:

* Run `cp .env .env.local` and fill in the required data
* Run `make build`

#### You can also use the following commands from the Makefile:

* `make up` - To run the containers without executing build scripts.
* `make down` - To stop containers
* `make consume` - To run messenger workers   
* `make redis_flush` - To flush all Redis databases
* `make load_fixtures` - To load with mock data to DB