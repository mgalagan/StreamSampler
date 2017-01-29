# StreamSampler
Stream sampler picks random bites from input sources.
You could specify input source from command line.

## Installation
- Clone repository
- cd into cloned repo dir
- run 'composer install'

## Usage

### Command help 
php bin/console stream:sampler --help

### Values piped directly
Command: php bin/console stream:sampler -s 5 -t input

Example: echo 'asdasdasdasdasdasdasd' | php bin/console stream:sampler -s 5 -t input

### Values random generated
Command: php bin/console stream:sampler -s 5 -t random

### Get values by HTTP GET request
php bin/console stream:sampler --size=5 --type=url --url=URL

Example: php bin/console stream:sampler --size=5 --type=url --url='https://www.random.org/strings/?num=20&len=20&digits=off&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new'


## Unit tests
Run: php vendor/phpunit/phpunit/phpunit tests/Sampler/Command/
Note: I didn't write many tests. The unit tests above are showing that I can write it :) 
