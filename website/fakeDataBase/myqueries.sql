CREATE TABLE courses(
courseID INT AUTO_INCREMENT PRIMARY KEY,
courseName VARCHAR(100) NOT NULL,
courseDescription TEXT,
courseDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
userID INT,
CONSTRAINT forUsers FOREIGN KEY (userID) REFERENCES users(userID)
ON DELETE SET NULL ON UPDATE CASCADE
);

//course insertion
INSERT INTO courses (courseName, courseDescription, userID)
VALUES
('Descriptive Analysis', 'Learn methods for summarizing and visualizing data.', NULL),
('Inferential Statistics', 'Learn methods for summarizing and visualizing data.', NULL),
('Machine Learning', 'Learn methods for summarizing and visualizing data.', NULL);

$enrolledCourses = [];
$stmt = $conn->prepare("
    SELECT c.courseID, c.courseName, c.courseDescription, c.courseDate, c.coursePrice
    FROM enrollments e
    INNER JOIN courses c ON e.courseID = c.courseID
    WHERE e.userID = ?
");

// see who enrolled
SELECT u.firstName, u.lastName, c.courseName
FROM enrollments e
JOIN users u ON e.userID = u.userID
JOIN courses c ON e.courseID = c.courseID
WHERE c.courseID = 3;

-- all talbes
MariaDB [fakedata]> show tables;
+--------------------+
| Tables_in_fakedata |
+--------------------+
| courses            |
| enrollments        |
| users              |
+--------------------+
3 rows in set (0.001 sec)

MariaDB [fakedata]> select * from courses;
+----------+-----------------------------+-------------------------------------------------------------------------------+---------------------+--------+-------------+
| courseID | courseName                  | courseDescription                                                             | courseDate          | userID | coursePrice |
+----------+-----------------------------+-------------------------------------------------------------------------------+---------------------+--------+-------------+
|        1 | Descriptive Analysis        | Learn methods for summarizing and visualizing data.                           | 2025-04-29 23:25:56 |   NULL |     1499.99 |
|        2 | Inferential Statistics      | Learn methods for summarizing and visualizing data.                           | 2025-04-29 23:25:56 |   NULL |      999.00 |
|        3 | Machine Learning            | Learn methods for summarizing and visualizing data.                           | 2025-04-29 23:25:56 |   NULL |     1999.50 |
|        4 | Big Data Analytics          | Learn how to process and analyze massive datasets using modern tools.         | 2025-04-29 23:30:56 |   NULL |     1499.99 |
|        5 | Natural Language Processing | Learn techniques for processing and analyzing text data using NLP frameworks. | 2025-04-29 23:30:56 |   NULL |      999.00 |
|        6 | Cloud Computing for Data    | Explore cloud platforms for scalable data storage and processing.             | 2025-04-29 23:30:56 |   NULL |     1999.50 |
|        7 | Data Cleaning               | Master techniques for handling missing, inconsistent, or inaccurate data.     | 2025-04-29 23:30:56 |   NULL |     1499.99 |
|        8 | Data Visualization          | Use tools to create compelling visual representations of data.                | 2025-04-29 23:30:56 |   NULL |      999.00 |
|        9 | Regression Analysis         | Understand and apply linear and logistic regression models.                   | 2025-04-29 23:30:56 |   NULL |     1999.50 |
|       10 | Python for Data Science     | Learn Python programming tailored for data analysis and machine learning.     | 2025-04-29 23:30:56 |   NULL |     1499.99 |
|       11 | Time Series Analysis        | Explore techniques for analyzing data that changes over time.                 | 2025-04-29 23:30:56 |   NULL |      999.00 |
|       12 | Neural Networks             | Understand the basics of deep learning and how neural networks work.          | 2025-04-29 23:30:56 |   NULL |     1999.50 |
+----------+-----------------------------+-------------------------------------------------------------------------------+---------------------+--------+-------------+
12 rows in set (0.001 sec)

MariaDB [fakedata]> select * from enrollments;
+--------------+--------+----------+---------------------+
| enrollmentID | userID | courseID | enrollmentDate      |
+--------------+--------+----------+---------------------+
|            1 |      1 |        1 | 2025-05-10 01:25:35 |
+--------------+--------+----------+---------------------+
1 row in set (0.001 sec)

MariaDB [fakedata]> select * from users;
+--------+-----------+----------+-----------+---------------------------+--------------------------------------------------------------+
| userID | firstName | lastName | keyName   | email                     | keyPass                                                      |
+--------+-----------+----------+-----------+---------------------------+--------------------------------------------------------------+
|      1 | Jefferson | Samson   | jefferson | jeffersonsamson@gmail.com | 123456789                                                    |
|      2 | Gil       | Tuazon   | gil12345  | giltuazon@gmail.com       | $2y$10$7si32u1fTmo0sqD7Os5Y4e8e5ovcMPRldb3q.cLrCh.w9n/Bmjrfu |
|      3 | karl      | palomo   | karlito   | karlpalomo@gmail.com      | $2y$10$J3ZcFFQR0TanrmVaAFS8deHgmcR.igvCiAxKX24raVF7eBRdfZZDa |
|      4 | asdasdas  | asdasd   | NULL      | asdas@gmail.com           | $2y$10$H9LxMMCmrmdrec8Fg.LfNuUzYGDCRdAt7QHqqnIwrN1Qr7zvfxNJK |
+--------+-----------+----------+-----------+---------------------------+--------------------------------------------------------------+
4 rows in set (0.001 sec)