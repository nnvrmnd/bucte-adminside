D:
cd "D:\This_PC\Program_Files\XAMPP7\mysql\bin"
mysqldump -hlocalhost -uroot -p bucte_db > "D:\This_PC\Program_Files\XAMPP7\htdocs\bucte\admin\assets\hndlr\bucte_db_%date:~-10,2%%date:~-7,2%%date:~-4,4%_%time:~0,2%%time:~3,2%%time:~6,2%.sql"