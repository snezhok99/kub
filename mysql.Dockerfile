FROM mysql:8.0.19
COPY ./dump/db2.sql /docker-entrypoint-initdb.d/init.sql