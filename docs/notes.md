# Technical Notes

## The biggest Docker problem I faced
Pulling the MySQL image kept failing with network timeouts. I solved it by retrying the pull until all layers were downloaded (Docker caches completed layers). Another issue was the database: the project had no .sql file, so I exported the database from phpMyAdmin and imported it automatically through docker-entrypoint-initdb.d. I also changed DB_HOST from localhost to the compose service name "db".

## Most important Git/GitHub lesson
Making small, separate commits with meaningful messages, and using a feature branch with a Pull Request instead of pushing everything to main.
