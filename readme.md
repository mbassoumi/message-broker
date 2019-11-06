![http://souktel.com/](http://www.souktel.com/cached_uploads/fit/350/233/default-image.png) 

# About Souktel
- **Website:** ***[souktel.com](http://www.souktel.com/).***
- **LinkedIn:** ***[Souktel](https://www.linkedin.com/company/souktel).***
- **Facebook:** ***[Souktel Digital Solutions](https://www.facebook.com/souktel).***
- **Twitter:** ***[Souktel](https://twitter.com/Souktel).***


# About The Project

implementation of Message Broker to support communication between microservices through messages

# Installation
```composer
 composer require souktel/message-broker
```
In Laravel:
 - publish config and migrations files from vendor
 ```php
php artisan vendor:publish --provider="Souktel\MessageBroker\SouktelMessageBrokerServiceProvider"
```

In Lumen:
- copy config file from vendor
- copy migration files from vendor


# configuration

in config file

| variable  | description | 
| ------------- | ------------- |
| database  | if enable = true, all published messages will be stored in database. you can change tables name before run migration command.   |
| log  | if enable = true, there will be some output logs through channel name in config file   | |
| settings  | Message Broker settings  |