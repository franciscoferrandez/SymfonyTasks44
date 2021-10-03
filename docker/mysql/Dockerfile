FROM mysql:8.0

ARG UID
EXPOSE $UID

RUN adduser -u ${UID} --disabled-password --gecos "" appuser

RUN mkdir /home/appuser/.ssh
RUN chown -R appuser:appuser /home/appuser/

COPY ./mysqldump.sql /home/appuser/mysqldump.sql


