###### Default Timestamp problem in MySQL
**Problem:**  
1. Xampp use MariaDB Database  
2. CPanel user Mysql database  
3. Export database from xampp using additional option [MYSQL40] for compatibility with mysql  
4. When upload database to CPanel mysql default timestamp does not work, shows [0000-00-00 00:00:00]  

**Solution:**  
1. On CPanel change date field datatype 'DATETIME' to 'TIMESTAMP'  
2. On WHM Goto 'Main Page->Server Configuration->Server Time' and change Timezone to 'Asia/Dhaka'  