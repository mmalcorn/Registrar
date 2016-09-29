<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";
    require_once "src/Course.php";

    $server = "mysql:host=localhost:8889;dbname=registrar_test";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetStudentName()
        {
            //Arrange
            $test_name = "Linda Ronstandt";
            $test_date = "2016-12-12";
            $test_student = new Student($test_name, $test_date);

            //Act
            $result = $test_student->getStudentName();

            //Assert
            $this->assertEquals($test_name, $result);

        }

        function testGetDate()
        {
            //Arrange
            $test_name = "Linda Ronstandt";
            $test_date = "2016-12-12";
            $test_student = new Student($test_name, $test_date);

            //Act
            $result = $test_student->getDate();

            //Assert
            $this->assertEquals($test_date, $result);

        }

        function testGetId()
        {
            //Arrange
            $test_name = "Linda Ronstandt";
            $test_date = "2016-12-12";
            $test_id = 1;
            $test_student = new Student($test_name, $test_date, $test_id);

            //Act
            $result = $test_student->getId();

            //Assert
            $this->assertEquals($test_id, $result);
        }


        function testSave()
        {
            //Arrange
            $test_name = "Linda Ronstandt";
            $test_date = "2016-12-12";
            $test_id = null;
            $test_student = new Student($test_name, $test_date, $test_id);

            //Act
            $test_student->save();

            //Assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $test_name_one = "Linda Ronstandt";
            $test_date_one = "2016-12-12";
            $test_id = null;
            $test_student_one = new Student($test_name_one, $test_date_one);
            $test_student_one->save();

            $test_name_two = "Pablo Picasso";
            $test_date_two = "2016-11-01";
            $test_id = null;
            $test_student_two = new Student($test_name_two, $test_date_two);
            $test_student_two->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student_one, $test_student_two], $result);
        }

        function testDeleteAll()
        {
            //Arrange
                    // Create test Student #1
            $test_name_one = "Linda Ronstandt";
            $test_date_one = "2016-12-12";
            $test_id = null;
            $test_student_one = new Student($test_name_one, $test_date_one);
            $test_student_one->save();
                    // Create test Student #1
            $test_name_two = "Pablo Picasso";
            $test_date_two = "2016-11-01";
            $test_id = null;
            $test_student_two = new Student($test_name_two, $test_date_two);
            $test_student_two->save();

            //Act
            Student::deleteAll();
            $result = Student::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function testFindStudent()
        {
            //Arrange
            $test_student_name = "Pochantas";
            $test_enrollment_date = "1986-09-01";
            $test_student = new Student($test_student_name, $test_enrollment_date);
            $test_student->save();

            $test_name_two = "Pablo Picasso";
            $test_enrollment_date_two = "2016-11-01";
            $test_student_two = new Student($test_name_two, $test_enrollment_date_two);
            $test_student_two->save();

            //Act
            $result = Student::find($test_student->getId());

            //Assert
            $this->assertEquals($test_student, $result);

        }
        function testGetCourse()
        {
            //Arrange
            $test_course_name = "Intro to Kundalini Awakening";
            $test_course_number = "KA101";
            $test_course = new Course($test_course_name, $test_course_number);
            $test_course->save();

            $test_course_name2 = "Intro to Computer Science";
            $test_course_number2 = "CSE101";
            $test_course2 = new Course($test_course_name2, $test_course_number2);
            $test_course2->save();

            $test_student_name = "Deirdra Rain";
            $test_enrollment_date = "2016-04-01";
            $test_student = new Student($test_student_name, $test_enrollment_date);
            $test_student->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);

            //Assert
            $this->assertEquals($test_student->getCourse(), [$test_course, $test_course2]);

        }

        function testAddCourse()
        {
            //Arrange
            $test_course_name = "Intro to Computer Science";
            $test_course_number = "CSE101";
            $test_course = new Course($test_course_name, $test_course_number);
            $test_course->save();

            $test_student_name = "Pochantas";
            $test_enrollment_date = "1986-09-01";
            $test_student = new Student($test_student_name, $test_enrollment_date);
            $test_student->save();

            //Act
            $test_student->addCourse($test_course);

            //Assert
            $this->assertEquals($test_student->getCourse(), [$test_course]);
        }





    }

?>
