#!/bin/sh

# デプロイ後、環境変数を設定する
export SCHEMASPY_OUTPUT="/output"
export DB_TYPE="mysql"
export DB_HOST="localhost"
export DB_PORT=3366
export DB_NAME="tennis-track_db"
export DB_SCHEMA="tennis-track_db"
export DB_USER="tennis-track_user"
export DB_PASS="password"

[ -d $SCHEMASPY_DRIVERS ] && export DRIVER_PATH=$SCHEMASPY_DRIVERS || export DRIVER_PATH=/drivers_inc/
echo -n "Using drivers:"
ls -Ax $DRIVER_PATH | sed -e 's/  */, /g'
exec java -jar /usr/local/lib/schemaspy/schemaspy*.jar \
    -dp $DRIVER_PATH \
    -o $SCHEMASPY_OUTPUT \
    -t $DB_TYPE \
    -host $DB_HOST \
    -port $DB_PORT \
    -db $DB_NAME \
    -u $DB_USER \
    -s $DB_SCHEMA \
    -p $DB_PASS \
    -connprops useSSL\\=false \
    -debug
