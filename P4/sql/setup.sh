#!/bin/bash

dropdb si1 -U alumnodb
createdb si1 -U alumnodb
echo "Inicializando base de datos: dump_v1.1-P4.sql..."
psql si1 < dump_v1.1-P4.sql -U alumnodb
