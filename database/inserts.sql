USE prescribex;

-- User 

INSERT INTO  `user` (
`userID` ,
`username` ,
`email` ,
`password`,
`role`, 
`firstname`,
`lastname`,
`addressline1`,
`addressline2`

)
VALUES 
(NULL ,  'patient',  'patientX@gmail.com',  '5d41402abc4b2a76b9719d911017c592', 'pat', 'Sam ',  'Sick',  '56 Church Road',  'Dublin'),
(NULL ,  'pharmacist',  'pharmacistX@gmail.com',  '5d41402abc4b2a76b9719d911017c592', 'pha', 'Margaret',  'Friendly', '40 Clinical Street ',  'Dublin'),
(NULL ,  'doctor',  'doctorxX@gmail.com',  '5d41402abc4b2a76b9719d911017c592', 'doc', 'Fred', 'Medicine',  '40 Clinical Street ',  'Dublin' ),
(NULL ,  'patient2',  'patient2@gmail.com',  '5d41402abc4b2a76b9719d911017c592', 'pat', 'Lisa', 'Unwell',  '10 Clontarf Road',  'Dublin 3' ),
(NULL ,  'patient3',  'patient3@gmail.com',  '5d41402abc4b2a76b9719d911017c592', 'pat', 'Mark', 'Meyr',  '20 Drumcondra Rad',  'Dublin 5' ),
(NULL ,  'patient4',  'patient4@gmail.com',  '5d41402abc4b2a76b9719d911017c592', 'pat', 'Fred', 'Meyr',  '20 Drumcondra Rad',  'Dublin 5' );

-- active ingredients
INSERT INTO `activeingredient` (
`activeingredientID` ,
`name`
)
VALUES 
(NULL ,  'Ibuprofen'), 
(NULL ,  'Ventolin'),
(NULL ,  'Betametason Dipropionate'),
(NULL ,  'Valium');

-- units
INSERT INTO  `units` (
`unitID`,
`name`
)
VALUES 
(NULL, 'mg'),
(NULL, 'ml'),
(NULL, 'µg'),
(NULL, '%'),
(NULL, 'units'),
(NULL, 'unit');


-- genericDrug
INSERT INTO  `genericDrug` (
`genericdrugID` ,
`activeingredientID` ,
`licenceNo` ,
`genericName`
)
VALUES 
(NULL ,  '1',  '12345678',  'Nurofen'),
(NULL ,  '1',  '12345678',  'Ibufix'),
(NULL ,  '1',  '12345678',  'Ibufox'),
(NULL ,  '2',  '12345678',  'BreatheEasix'),
(NULL ,  '2',  '12345678',  'Ventolan'),
(NULL ,  '3',  '12345678',  'Becotide'),
(NULL ,  '3',  '12345678',  'Betamax'),
(NULL ,  '4',  '12345678',  'Calmifix'),
(NULL ,  '4',  '12345678',  'Calmimax');



-- frequency values
INSERT INTO `frequencyunits` (`frequencyunitID`, `name`) 
VALUES 
(NULL,'per day'),
(NULL,'as needed'),
(NULL,'every x hours');

-- doctor
INSERT INTO  `doctor` (
`regNo` ,
`userID` ,
`practicename`
)
VALUES (
'123456',  '3', 'Clinical Street Medical'
);


-- pharmacist
INSERT INTO  `pharmacist` (
`regNo` ,
`pharmacy` ,
`userID`
)

VALUES (
'123455678', 'Margarets friendly pharmacy',  '2'
); 

-- patient
INSERT INTO  `patient` (
`dob` ,
`userID`
)
VALUES 
('1971-12-19',  '1'),
('1971-11-03',  '4'),
('1971-01-08',  '5'),
('1971-03-09',  '6');

-- Dosageform 

INSERT INTO `dosageform` (`dosageformid`, `name`) 
VALUES 
(NULL, 'Capsule'), 
(NULL, 'Injection'),
(NULL, 'Extended Release Capsule'),
(NULL, 'Tablet'), 
(NULL, 'Cream, topical'), 
(NULL, 'Ointment, topical'), 
(NULL, 'Syrup'), 
(NULL, 'Aerosol'), 
(NULL, 'Suspension'), 
(NULL, 'Liquid'),
(NULL, 'Other');

-- prescription

INSERT INTO `prescription` (
`prescriptionID`, `activeingredient`, `dosage`, `dosageunitID`, `dosageformID`, `frequency`, `frequencyunitID`, `prescriber`, `prescriptionExpiry`, `instructions`, `repeats`, `repeatsleft`, `active`, `patientID`,`date`) 
VALUES 
(NULL, '1', '10', '1', 1, '1', '1', '3', NULL, 'Take with food', '1', '5', '3', '1', '2014-11-04 12:08:48'),
(NULL, '2', '20', '1', 1, '1', '1', '3', NULL, 'Inhale', '1', '1', '1', '1','2012-11-04 12:08:48'),
(NULL, '1', '30', '1', 1, '1', '1', '3', NULL, 'Take with food', '1', '1', '1', '1', NULL),
(NULL, '1', '40', '1', 1, '1', '1', '3', NULL, 'Take with food', '1', '1', '1', '1', NULL),
(NULL, '1', '40', '1', 1, '1', '1', '3', NULL, 'Take with food', '1', '1', '0', '1', NULL)
;


-- dispensal

INSERT INTO `dispensal` (`dispensalID`, `prescriptionID`, `pharmacistID`, `genericID`, `strength`, `strengthunitID`, `pharmacistinstructions`, `date`) VALUES 
(NULL, '1', '2', '5', '30', '1', 'Don''t drive! ', '2014-12-04 12:08:48'),
(NULL, '1', '2', '2', '100', '1', 'Don''t drive', '2013-12-04 12:08:48'), 
(NULL, '1', '2', '2', '100', '1', 'Don''t drive', '2015-12-04 12:08:48'), 
(NULL, '2', '2', '4', '100', '1', 'Could kill you ', '2012-12-04 12:08:48');




