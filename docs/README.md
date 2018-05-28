# Devliver

Your private self-hosted composer repository.

##  Requirements

* **PHP 7.0** or higher
* **MariaDB/MySQL**
* **git** installed on server
* the running web user has **access** to **private** git repositories over **ssh**.

##  Installation Instruction

### 1. Download

... the project from [github.com](https://github.com/shapecode/devliver/releases) to your web directory.  
The document root of your vhost have to point to the `public` directory.

### 2. Extract

Login into your terminal and run following command in the project directory.

`unzip release.zip -d ./`

### 3. Install

Now run `php bin/composer install --no-dev --optimize-autoloader` and follow instructions.

### 4. Database

Update your database structure.
 
```bash
php bin/console doctrine:schema:update --force
```

### 5. User

Create an admin user.

```bash
php bin/console fos:user:create --super-admin
```

Follow the instructions and your user will be created.


### 6. Other users

The packages.json is secured by basic http authentication. Add users in the Admin Panel with the role `ROLE_REPO`. These users have access to the packages.json and can download archives.

### 7. Cronjob

You have to run a background update task as a cronjob.  
The background task is executed with the `bin/console shapecode:cron:run` shell command.  

Just add a cronjob to your cron table that runs the command every 2 minutes like this to your cron table.  
`*/2 * * * * /path/to/your/project/bin/console shapecode:cron:run -q`

## Authentication

The repositories will usually be protected. 
There are 2 ways to allow devliver access to these repositories. 
You store an SSH key in the ssh directory in the home directory for the corresponding web server user. 
Or you can create an `auth.json` file in the `%document_root%/composer` directory. See the documentation on [getcomposer.org](https://getcomposer.org/doc/articles/http-basic-authentication.md).

## How to Use

To use your Devliver installation in Composer, there is one package repository you have to add to the composer.json in your projects.  
Composer will you ask for credentials to access the packages.json when you update your project.
  
This is your repository of private packages.

```json
    {
        "repositories": [
            {
                "type": "composer",
                "url": "https://yourdomain.url"
            }
        ]
    }
```

##  Update Instruction

Login into your terminal and run following commands.

```bash
php bin/console devliver:self-update
```

Follow the instructions.