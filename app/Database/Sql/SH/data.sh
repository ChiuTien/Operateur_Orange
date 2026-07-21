cd ../../../../

rm writable/database.db

sqlite3 writable/database.db < app/Database/Sql/data.sql