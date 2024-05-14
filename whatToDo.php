Create a website in php as per give instructions .
make a Hostel Management System

step-1:
make two tables in the database:
1. Admin (id, username,email, password)
2. Students (id, roll_number, name, email,password, address, department, room_allocated, bill_paid)
here paid is a boolean yes/no or 1/0.
also provide query for dummy data insertion in both tables.

Step-2:
make a login page where the admin firstly login using the email and password (use admin table of database).
and student can login using the email and password (use student table of database).
store the admin's and Student's username in a session.

after successful login, the admin jumps on the 'Home.php'. where show the admin's name in the top
header and also shows the sign-out option using which the session is destroyed.

Step-3
on 'Home.php' the admin can see all the students in an HTML table,
and show data from the Student database table in two HTML tables
 (The admin should also be able to see the students who have paid their mess bill in one table and who have not paid their mess bill in another table), and add this functionlity that the admin can update each student's information and also mess bill status as whoever pays the bills, the admin can change bill_paid status from ‘No’ to ‘Yes’.

Now Add these functionlity to for admin:
The admin can also delete any student from the database.
The admin can also add a new student to the database.
The admin can alos update studet all information(all fields).
The admin can also search student by roll number.

when student get loggedin save his user name and password in session and 
his department in cookie
and show his name in the top header and also shows the sign-out option using which the session is destroyed.
and show his all information in the table.
