################################################################
# S.O 
################################################################

FROM ubuntu:18.04

RUN apt-get update && \
    apt-get install -y tzdata && \
    apt-get install -y gnupg2 && \
    apt-get install -y unixodbc && \
    apt-get install -y unixodbc-dev && \ 
    apt-get install -y git-all && \
    apt-get install -y unzip && \ 
    apt-get install -y curl && \ 
    apt-get install -y iputils-ping && \
    apt-get install -y software-properties-common && \
    rm -rf /var/lib/apt/lists/*RUN apt-get update && \
    apt-get install -y software-properties-common && \
    rm -rf /var/lib/apt/lists/*

################################################################
# PHP 
################################################################

RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get update && \
    apt-get install -y --allow-unauthenticated php && \
    apt-get install -y --allow-unauthenticated php-cli && \
    apt-get install -y --allow-unauthenticated php-dev && \
    apt-get install -y --allow-unauthenticated php-json && \
    apt-get install -y --allow-unauthenticated php-mysql && \
    apt-get install -y --allow-unauthenticated php-zip && \
    apt-get install -y --allow-unauthenticated php-gd && \
    apt-get install -y --allow-unauthenticated php-mbstring && \
    apt-get install -y --allow-unauthenticated php-curl && \
    apt-get install -y --allow-unauthenticated php-xml && \
    apt-get install -y --allow-unauthenticated php-pear && \
    apt-get install -y --allow-unauthenticated libapache2-mod-php && \
    apt-get install -y --allow-unauthenticated php-bcmath

################################################################
# COMPOSER
################################################################

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

################################################################
# CRONTAB
################################################################

RUN apt-get install cron
ADD docker/crontab /etc/cron.d/docker-crontab
RUN chmod 0644 /etc/cron.d/docker-crontab
RUN service cron start

################################################################
# APACHE
################################################################

RUN apt-get update
RUN apt-get install -y --allow-unauthenticated libapache2-mod-php 
RUN apt-get install -y --allow-unauthenticated apache2
RUN a2dismod mpm_event
RUN a2enmod mpm_prefork
RUN a2enmod rewrite
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ADD docker/apache/apache2.conf /etc/apache2/apache2.conf
ADD docker/apache/apache-virtual-hosts.conf /etc/apache2/sites-enabled/000-default.conf
##RUN a2enmod php8.0


################################################################
# SQL SERVER
################################################################

# https://docs.microsoft.com/en-us/sql/connect/php/installation-tutorial-linux-mac?view=sql-server-ver15

RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/ubuntu/18.04/prod.list > /etc/apt/sources.list.d/mssql-release.list
RUN apt-get update
RUN ACCEPT_EULA=Y apt-get install msodbcsql17
RUN ACCEPT_EULA=Y apt-get install mssql-tools
RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile
RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv


RUN add-apt-repository ppa:ondrej/php -y
RUN apt -y install php8.0 libapache2-mod-php8.0 
RUN phpenmod -v 8.0 sqlsrv pdo_sqlsrv
RUN apt-get -y install libapache2-mod-php8.0 apache2 
RUN a2dismod mpm_event
RUN a2enmod mpm_prefork
RUN service apache2 restart
RUN a2dismod php8.1
RUN a2enmod php8.0
ADD docker/sqlsrv.so /usr/lib/php/20200930/sqlsrv.so
ADD docker/pdo_sqlsrv.so /usr/lib/php/20200930/pdo_sqlsrv.so
RUN printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/8.0/mods-available/sqlsrv.ini
RUN printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/8.0/mods-available/pdo_sqlsrv.ini
RUN phpenmod -v 8.0 sqlsrv pdo_sqlsrv
RUN service apache2 restart
################################################################
# ADD THE DIRECTORY
################################################################

RUN mkdir -p /var/www/app
WORKDIR /var/www/app

################################################################
# BY DEFAULT START UP APACHE IN THE FOREGROUND
# OVERRIDE WITH /BIN/BASH FOR INTERATIVE.
################################################################

CMD /usr/sbin/apache2ctl -D FOREGROUND