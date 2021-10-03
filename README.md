# SymfonyTasks44
Curso Symfony VR

## Instalación
```
make build
make run
make composer-install
cat ./docker/mysql/mysqldump.sql | docker exec -i symfony-tasks-db /usr/bin/mysql -u root --password=root symfony_tasks_db
```
