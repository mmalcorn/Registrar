<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";
    require_once "src/Course.php";

    $server = 'mysql:host=localhost:8889;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetCourseName()
        {
            //Arrange
            $test_course_name = "Intro to Computer Science";
            $test_course_number = "CSE101";
            $test_course = new Course($test_course_name, $test_course_number);

            //Act
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals($test_course_name, $result);

        }

        function testGetCourseNumber()
        {
            //Arrange
            $test_course_name = "Intro to Computer Science";
            $test_course_number = "CSE101";
            $test_course = new Course($test_course_name, $test_course_number);

            //Act
            $result = $test_course->getCourseNumber();

            //Assert
            $this->assertEquals($test_course_number, $result);

        }

        function testGetId()
        {
            //Arrange
            $test_course_name = "Intro to Computer Science";
            $test_course_number = "CSE101";
            $test_id = 1;
            $test_course = new Course($test_course_name, $test_course_number, $test_id);

            //Act
            $result = $test_course->getId();

            //Assert
            $this->assertEquals($test_id, $result);
        }

        function testSave()
        {
            //Arrange
            $test_name = "Intro to Computer Science";
            $test_course_number = "CSE101";
            $test_id = null;
            $test_course = new Course($test_name, $test_course_number, $test_id);

            //Act
            $test_course->save();

            //Assert
            $result = Course::getAll();
            $this->assertEquals($test_course, $result[0]);
        }

        function testGetAll()
        {
            $test_course_name = "Intro to Computer Science";
            $test_course_number = "CSE101";
            $test_id = null;
            $test_course = new Course($test_course_name, $test_course_number, $test_id);
            $test_course->save();

                    //Create test Course #2
            $test_course_name2 = "Biology";
            $test_course_number2 = "BIO101";
            $test_id = null;
            $test_course2 = new Course($test_course_name2, $test_course_number2, $test_id);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
                    //Create test Course #1
            $test_course_name = "Intro to Computer Science";
            $test_course_number = "CSE101";
            $test_id = null;
            $test_course = new Course($test_course_name, $test_course_number, $test_id);
            $test_course->save();

                    //Create test Course #2
            $test_course_name2 = "Biology";
            $test_course_number2 = "BIO101";
            $test_id = null;
            $test_course2 = new Course($test_course_name2, $test_course_number2, $test_id);
            $test_course2->save();

            //Act
            Course::deleteAll();
            $result = Course::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testGetStudent()
        {
            //Arrange
            $test_student_name = "Pochantas";
            $test_enrollment_date = "1986-09-01";
            $test_student = new Student($test_student_name, $test_enrollment_date);
            $test_student->save();

            $test_student_name2 = "John Smith";
            $test_enrollment_date2 = "1986-09-01";
            $test_student2 = new Student($test_student_name, $test_enrollment_date);
            $test_student2->save();

            $test_course_name = "Intro to Kundalini Awakening";
            $test_course_number = "KA101";
            $test_course = new Course($test_course_name, $test_course_number);
            $test_course->save();

            //Act
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            //Assert
            $this->assertEquals($test_course->getStudent(), [$test_student, $test_student2]);
        }

        function testAddStudent()
        {
            //Arrange
            $test_student_name = "Jilly Jives";
            $test_enrollment_date = "1976-07-14";
            $test_student = new Student($test_student_name, $test_enrollment_date);
            $test_student->save();

            $test_course_name = "Intro to Kundalini Awakening";
            $test_course_number = "KA101";
            $test_course = new Course($test_course_name, $test_course_number);
            $test_course->save();

            //Act
            $test_course->addStudent($test_student);

            //Assert
            $this->assertEquals($test_course->getStudent(), [$test_student]);
        }

    }

?>
