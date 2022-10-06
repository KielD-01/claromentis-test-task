# Claromentis CSV Uploader

## Requirements
- Git
- PHP 7.4+
- BCMath (php-bcmath extension; we are working with floats here; so, we want to have as precise as possible)
- Docker (optional)
- A pair of hands
- Laptop (Mac or any other generic) or a PC
- Battery or an Electricity (applies only if Your battery is dead; You have only a PC)
- A cuppa of a tea (optional; applies only for Docker installation)

## How to run it?

### Required : Clone the project or Download a ZIP
Make sure, that no other applications are running port 80.

#### Clone  
```shell
git clone git@github.com:KielD-01/claromentis-test-task.git
```

#### [Download Zip](https://github.com/KielD-01/claromentis-test-task/archive/refs/heads/master.zip)   
```shell
wget -O claromentis.zip https://github.com/KielD-01/claromentis-test-task/archive/refs/heads/master.zip
```

### Docker  
Make sure, that You have a valid [Docker](https://docs.docker.com/get-started/) installation.   
Optional: I do not recommend running Docker under WSL2 on Windows. Works at its worst, trust me.

Then within the root of the project run:    

```shell
docker-compose up -d
```

Enjoy Your cuppa of a tea and then open [this page](http://localhost/) to visit a project.

### PHP Server
```shell
php -S 127.0.0.1 -t ./public
```

Enjoy!