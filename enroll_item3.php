<?php

class Student
{
    private $name;
    private $courses = [];
    private $courseFee = 1450;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addCourse($courseName)
    {
        if (!in_array($courseName, $this->courses)) {
            $this->courses[] = $courseName;
            echo "Course '$courseName' added successfully.\n";
        } else {
            echo "Course '$courseName' is already enrolled.\n";
        }
    }

    public function deleteCourse($courseName)
    {
        $key = array_search($courseName, $this->courses);
        if ($key !== false) {
            unset($this->courses[$key]);
            echo "Course '$courseName' removed successfully.\n";
        } else {
            echo "Course '$courseName' not found.\n";
        }
    }

    public function getTotalEnrollmentFee()
    {
        return count($this->courses) * $this->courseFee;
    }

    public function displayCourses()
    {
        echo "Enrolled courses for {$this->name}: " . implode(", ", $this->courses) . "\n";
    }
}

$student = new Student("Althea Sangalang");

$student->addCourse("Software Engineering 2 LEC");
$student->addCourse("Data Analysis for Computer Science");
$student->addCourse("CS Thesis Writing 1");

$student->displayCourses();

$student->deleteCourse("CS Thesis Writing 1");
$student->displayCourses();

$totalFee = $student->getTotalEnrollmentFee();
echo "Total Enrollment Fee: PHP $totalFee\n";
