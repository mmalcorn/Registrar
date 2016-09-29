<?php

    Class Course
    {
        private $name;
        private $course_number;
        private $id;

        function __construct($input_name, $input_course_number, $course_id = null)
        {
            $this->name = $input_name;
            $this->course_number = $input_course_number;
            $this->id = $course_id;
        }

        function getId()
        {
            return $this->id;
        }

        function setCourseName($input_course_name)
        {
            $this->name = (string) $input_course_name;
        }

        function getCourseName()
        {
            return $this->name;
        }

        function setCourseNumber($input_course_number)
        {
            $this->course_number = (string) strtoupper($input_course_number);
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number) VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = [];
            foreach($returned_courses as $course)
            {
                $name = $course['course_name'];
                $number = $course['course_number'];
                $id = $course['course_id'];
                $new_course = new Course($name, $number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$this->getId()}, {$student->getId()});");
        }

        function getStudent()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT students.* FROM courses
                JOIN courses_students ON (courses_students.course_id = courses.course_id)
                JOIN students ON (students.student_id = courses_students.student_id)
                WHERE courses.course_id = {$this->getId()};");
            $students = array();
            // var_dump($returned_students);
            foreach($returned_students as $student) {
                $name = $student['name'];
                $date = $student['date'];
                $id = $student['student_id'];
                $new_student = new Student($name, $date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }


    }



?>
