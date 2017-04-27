@C:\wamp64\bin\mysql\mysql5.7.17\bin\mysqldump.exe sistemabici -u root > "SistemaBMX.sql"
@"C:\Program Files\WinRAR\WinRAR.exe" a -r "SistemaBMX.rar" "SistemaBMX.sql"
@del "SistemaBMX.sql"
@move "SistemaBMX.rar" %CD% 