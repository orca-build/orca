
## ***********************************************************************
##  DOCKER FILE
## ***********************************************************************

FROM ubuntu:18.04
MAINTAINER Christian Dangl

# remember build-date
RUN date >/build-date.txt

## ***********************************************************************
##  USER MANAGEMENT
## ***********************************************************************

# set easy root pwd for dev purpose
RUN echo "root:root" | chpasswd

# set password for www-data, and also
# avoid shell login (we have a separate user for that)
RUN echo 'www-data:www-data' | chpasswd \
    && usermod -s /usr/sbin/nologin www-data

RUN adduser --disabled-password --uid 5577 --gecos "" sample \
    && usermod -a -G www-data sample \
    && usermod -m -d /var/www sample \
    && echo "sample:sample" | chpasswd \
    && sed -i 's/sample:x:5577:5577:/sample:x:33:33:/g' /etc/passwd

## ***********************************************************************
## ADD RESOURCE FILES
## ***********************************************************************
ADD ./configs/README.md /var/www/README.m

## ***********************************************************************
## PHP
## ***********************************************************************

RUN apt-get install -y php7.3

 ## ***********************************************************************
## CUSTOM COMPONENTS
## ***********************************************************************

RUN curl -L -O https://artifacts.elastic.co/downloads/beats/filebeat/filebeat-5.4.0-amd64.deb \
    && dpkg -i filebeat-5.4.0-amd64.deb \
    && rm -f /filebeat-5.4.0-amd64.deb

RUN echo "coming from shared plugin"

## ***********************************************************************
##  CLEAN UP / POST BUILD
## ***********************************************************************

ADD entrypoint.sh /entrypoint.sh
RUN chmod 755 /*.sh

CMD ["/entrypoint.sh"]
