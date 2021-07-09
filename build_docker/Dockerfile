FROM php:7.4-alpine

ADD ./orca.phar /opt/orca.phar
ADD ./README.md /opt/README.md
ADD ./run.sh /run.sh

RUN chmod 755 /*.sh && \
    mkdir /opt/project

WORKDIR /opt

CMD sh /run.sh