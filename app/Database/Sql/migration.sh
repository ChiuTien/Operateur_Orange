cd ../../../
# 1. Supprime l'ancienne base obsolète
rm writable/database.db

# 2. Recrée la base à partir de ton nouveau script SQL (sans la ligne -- Active)
sqlite3 writable/database.db < app/Database/Sql/base.sql