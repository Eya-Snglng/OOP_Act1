<?php
class Database
{
    private $host = "localhost";
    private $db_name = "school";
    private $username = "root";
    private $password = "";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

class Student
{
    private $conn;
    private $table = "students";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addStudent($data)
    {
        $sql = "INSERT INTO {$this->table} (name, email) VALUES (:name, :email)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function getStudents()
    {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStudent($data, $conditions)
    {
        $sql = "UPDATE {$this->table} SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array_merge($data, $conditions));
    }

    public function deleteStudent($conditions)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($conditions);
    }
}

class Attendance
{
    private $conn;
    private $table = "attendance";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addAttendance($data)
    {
        $sql = "INSERT INTO {$this->table} (student_id, date) VALUES (:student_id, :date)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function getAttendance()
    {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAttendance($data, $conditions)
    {
        $sql = "UPDATE {$this->table} SET date = :date WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array_merge($data, $conditions));
    }

    public function deleteAttendance($conditions)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($conditions);
    }
}

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);
$attendance = new Attendance($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_student'])) {
        $student->addStudent(['name' => $_POST['name'], 'email' => $_POST['email']]);
        echo "<p>Student added successfully!</p>";
    }

    if (isset($_POST['update_student'])) {
        $student->updateStudent(
            ['name' => $_POST['name'], 'email' => $_POST['email']],
            ['id' => $_POST['id']]
        );
        echo "<p>Student updated successfully!</p>";
    }

    if (isset($_POST['delete_student'])) {
        $student->deleteStudent(['id' => $_POST['id']]);
        echo "<p>Student deleted successfully!</p>";
    }

    if (isset($_POST['add_attendance'])) {
        $attendance->addAttendance([
            'student_id' => $_POST['student_id'],
            'date' => $_POST['date']
        ]);
        echo "<p>Attendance added successfully!</p>";
    }
}

$students = $student->getStudents();
$attendances = $attendance->getAttendance();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CRUD Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 60%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Student and Attendance Management</h1>

    <h2>Add Student</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="email" name="email" placeholder="Student Email" required>
        <button type="submit" name="add_student">Add Student</button>
    </form>

    <h2>Update Student</h2>
    <form method="POST">
        <input type="number" name="id" placeholder="Student ID" required>
        <input type="text" name="name" placeholder="New Name" required>
        <input type="email" name="email" placeholder="New Email" required>
        <button type="submit" name="update_student">Update Student</button>
    </form>

    <h2>Delete Student</h2>
    <form method="POST">
        <input type="number" name="id" placeholder="Student ID" required>
        <button type="submit" name="delete_student">Delete Student</button>
    </form>

    <h2>Add Attendance</h2>
    <form method="POST">
        <select name="student_id" required>
            <option value="">-- Select Student --</option>
            <?php foreach ($students as $s): ?>
                <option value="<?= $s['id'] ?>"><?= $s['id'] . " - " . $s['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="date" name="date" required>
        <button type="submit" name="add_attendance">Add Attendance</button>
    </form>

    <h2>All Students</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        <?php foreach ($students as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= $s['name'] ?></td>
                <td><?= $s['email'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Attendance Records</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Student ID</th>
            <th>Date</th>
        </tr>
        <?php foreach ($attendances as $a): ?>
            <tr>
                <td><?= $a['id'] ?></td>
                <td><?= $a['student_id'] ?></td>
                <td><?= $a['date'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>


</html>
