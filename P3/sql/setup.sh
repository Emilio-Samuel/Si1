#!/bin/bash

echo -e "\033[31m¡OJO: ejecutar desde P3/sql!\033[0m"

dropdb -U alumnodb si1
createdb -U alumnodb si1

echo "Inicializando base de datos: dump_v1.2.sql..."
psql si1 < dump_v1.2.sql
echo "Aplicando parches iniciales: actualiza.sql..."
psql si1 < actualiza.sql
echo "Actualizando orderdetail: setPrice.sql..."
psql si1 < setPrice.sql
