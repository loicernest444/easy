<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_subdivision` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_option_id`, `school_id`, `session`) VALUES ('1', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_id`, `school_id`, `session`) VALUES ('1', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `school_id`, `session`) VALUES ('1', '3', '0', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_subdivision` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_option_id`, `school_id`, `session`) VALUES ('2', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_id`, `school_id`, `session`) VALUES ('2', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `school_id`, `session`) VALUES ('2', '3', '0', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_subdivision` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_option_id`, `school_id`, `session`) VALUES ('3', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_id`, `school_id`, `session`) VALUES ('3', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `school_id`, `session`) VALUES ('3', '3', '0', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_subdivision` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_option_id`, `school_id`, `session`) VALUES ('4', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_id`, `school_id`, `session`) VALUES ('4', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 05:34:51 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `school_id`, `session`) VALUES ('4', '3', '0', '1', '1', '1')
ERROR - 2021-11-25 05:42:40 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2123
ERROR - 2021-11-25 05:42:40 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Loico Best debercy', `coef` = '1'
WHERE `student_id` = '1'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:42:40 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2123
ERROR - 2021-11-25 05:42:40 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Karel de Bercy', `coef` = '1'
WHERE `student_id` = '2'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:42:40 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2123
ERROR - 2021-11-25 05:42:40 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Aicha Kem', `coef` = '1'
WHERE `student_id` = '3'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:42:40 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2123
ERROR - 2021-11-25 05:42:40 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Merveille', `coef` = '1'
WHERE `student_id` = '4'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:47:45 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2027
ERROR - 2021-11-25 05:47:45 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Aicha Kem', `coef` = '1'
WHERE `student_id` = '3'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:04 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2027
ERROR - 2021-11-25 05:51:04 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Aicha Kem', `coef` = '1'
WHERE `student_id` = '3'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:29 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2027
ERROR - 2021-11-25 05:51:29 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Aicha Kem', `coef` = '1'
WHERE `student_id` = '3'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:39 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2124
ERROR - 2021-11-25 05:51:39 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Loico Best debercy', `coef` = '1'
WHERE `student_id` = '1'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:39 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2124
ERROR - 2021-11-25 05:51:39 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Karel de Bercy', `coef` = '1'
WHERE `student_id` = '2'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:39 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2124
ERROR - 2021-11-25 05:51:39 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Aicha Kem', `coef` = '1'
WHERE `student_id` = '3'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:39 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2124
ERROR - 2021-11-25 05:51:39 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Merveille', `coef` = '1'
WHERE `student_id` = '4'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:45 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2124
ERROR - 2021-11-25 05:51:45 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Loico Best debercy', `coef` = '1'
WHERE `student_id` = '1'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:45 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2124
ERROR - 2021-11-25 05:51:45 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Karel de Bercy', `coef` = '1'
WHERE `student_id` = '2'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:45 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2124
ERROR - 2021-11-25 05:51:45 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Aicha Kem', `coef` = '1'
WHERE `student_id` = '3'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 05:51:46 --> Severity: Warning --> Division by zero /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 2124
ERROR - 2021-11-25 05:51:46 --> Query error: Unknown column 'NAN' in 'field list' - Invalid query: UPDATE `average_subject` SET `mark_obtained` = NAN, `name` = 'Merveille', `coef` = '1'
WHERE `student_id` = '4'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_id` IS NULL
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_subdivision` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_option_id`, `school_id`, `session`) VALUES ('1', '3', '0', '1', '2', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_id`, `school_id`, `session`) VALUES ('1', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `school_id`, `session`) VALUES ('1', '3', '0', '1', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_subdivision` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_option_id`, `school_id`, `session`) VALUES ('2', '3', '0', '1', '2', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_id`, `school_id`, `session`) VALUES ('2', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `school_id`, `session`) VALUES ('2', '3', '0', '1', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_subdivision` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_option_id`, `school_id`, `session`) VALUES ('3', '3', '0', '1', '2', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_id`, `school_id`, `session`) VALUES ('3', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `school_id`, `session`) VALUES ('3', '3', '0', '1', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_subdivision` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_option_id`, `school_id`, `session`) VALUES ('4', '3', '0', '1', '2', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `exam_id`, `school_id`, `session`) VALUES ('4', '3', '0', '1', '1', '1', '1')
ERROR - 2021-11-25 06:08:17 --> Query error: Unknown column 'subject_id' in 'field list' - Invalid query: INSERT INTO `average_division` (`student_id`, `class_id`, `section_id`, `subject_id`, `school_id`, `session`) VALUES ('4', '3', '0', '1', '1', '1')
ERROR - 2021-11-25 06:21:28 --> Query error: Unknown column 'exam_option_id' in 'where clause' - Invalid query: SELECT *
FROM `marks`
WHERE `student_id` = '1'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_option_id` = '2'
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 06:21:28 --> Severity: error --> Exception: Call to a member function num_rows() on bool /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 1895
ERROR - 2021-11-25 06:22:27 --> Query error: Unknown column 'exam_option_id' in 'where clause' - Invalid query: SELECT *
FROM `marks`
WHERE `student_id` = '1'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_option_id` = '1'
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 06:22:27 --> Severity: error --> Exception: Call to a member function num_rows() on bool /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 1895
ERROR - 2021-11-25 06:22:31 --> Query error: Unknown column 'exam_option_id' in 'where clause' - Invalid query: SELECT *
FROM `marks`
WHERE `student_id` = '2'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_option_id` = '1'
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 06:22:31 --> Severity: error --> Exception: Call to a member function num_rows() on bool /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 1895
ERROR - 2021-11-25 06:29:24 --> Query error: Unknown column 'exam_option_id' in 'where clause' - Invalid query: SELECT *
FROM `marks`
WHERE `student_id` = '1'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_option_id` = '1'
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 06:29:24 --> Severity: error --> Exception: Call to a member function num_rows() on bool /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 1905
ERROR - 2021-11-25 07:07:31 --> Query error: Unknown column 'subject_id' in 'where clause' - Invalid query: SELECT *
FROM `average_subdivision`
WHERE `student_id` = '1'
AND `class_id` = '3'
AND `section_id` = '0'
AND `subject_id` = '1'
AND `exam_option_id` = '2'
AND `school_id` = '1'
AND `session` = '1'
ERROR - 2021-11-25 07:07:31 --> Severity: error --> Exception: Call to a member function num_rows() on bool /Users/armel/Sites/localhost/easy/application/models/Crud_model.php 1904
ERROR - 2021-11-25 07:26:08 --> 404 Page Not Found: Superadmin/marksheet
ERROR - 2021-11-25 07:28:03 --> Severity: Warning --> include(superadmin/marksheet/index.php): failed to open stream: No such file or directory /Users/armel/Sites/localhost/easy/application/views/backend/index.php 40
ERROR - 2021-11-25 07:28:03 --> Severity: Warning --> include(): Failed opening 'superadmin/marksheet/index.php' for inclusion (include_path='.:/Applications/MAMP/bin/php/php7.3.24/lib/php') /Users/armel/Sites/localhost/easy/application/views/backend/index.php 40
ERROR - 2021-11-25 07:32:31 --> Severity: Warning --> include(superadmin/marksheet/index.php): failed to open stream: No such file or directory /Users/armel/Sites/localhost/easy/application/views/backend/index.php 40
ERROR - 2021-11-25 07:32:31 --> Severity: Warning --> include(): Failed opening 'superadmin/marksheet/index.php' for inclusion (include_path='.:/Applications/MAMP/bin/php/php7.3.24/lib/php') /Users/armel/Sites/localhost/easy/application/views/backend/index.php 40
ERROR - 2021-11-25 09:43:52 --> 404 Page Not Found: Apple-touch-icon-precomposedpng/index
ERROR - 2021-11-25 09:43:52 --> 404 Page Not Found: Apple-touch-iconpng/index
