# IrishRail
This was inspired from someone who did this using the french compagny "SNCF" (which is known for its cancelations and delays).
The average sum of all delays for that compagny is around 1 week. This made me curious about how it was here in ireland.

Sadly the API for the Irish Rail is not as good, (they will only give you data about trains in motion or trains that have arrived
within the first 10 minutes / are departing within the next 10 minutes).

# Set up
This uses a docker image and docker compose.

To setup the environment run 
```
docker-compose build
```

then run 
```
docker-compose up
docker-compose down
```

To start and stop the containers.

# Usage
To get daily recaps of train delays you will then want to execute the script which stores data every 10 minutes and the other 
script daily. This can be done using crontab.

A script can be ran using the following command:
```
docker run -it --rm --name my-running-script -v "$PWD":/usr/src/myapp -w /usr/src/myapp php:7.2-cli php your-script.php
```

As a result, contabs may look like this:
```
//edit crontabs
crontab -e

// add to the file the above docker commands including info about when to execute them
*/10 * * * * docker run -it --rm --name my-running-script -v "$PWD":/usr/src/myapp -w /usr/src/myapp php:7.2-cli php api/StoreTrainData.php
0 12 * * * docker run -it --rm --name my-running-script -v "$PWD":/usr/src/myapp -w /usr/src/myapp php:7.2-cli php api/GetDelaysForPastDay.php

```
This consists of 2 scripts (which could be used as APIs). One stores data and another one uses that data to create a recap.

Information to create the required MySQL tables may be found in the directory 'migrations'.
For the script to work, mysqli will need to be enabled and the database logins changed to your credetials.
