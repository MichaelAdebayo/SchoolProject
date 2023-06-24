CREATE TABLE role(
    role_id INT NOT NULL,
    position_name VARCHAR(255),
    PRIMARY KEY(role_id)
);

CREATE TABLE user_name(
    user_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45),
    verification INT(4) NOT NULL,
    entrydate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    role_id INT NOT NULL,
    PRIMARY KEY(user_id),
    FOREIGN KEY(role_id) REFERENCES role(role_id)
);

CREATE TABLE ledger(
  transaction_id INT NOT NULL,
  transaction_date DATE,
  total FLOAT NOT NULL,
  user_id INT NOT NULL,
  PRIMARY KEY(transaction_id),
  FOREIGN KEY(user_id) REFERENCES user_name(user_id)
);

CREATE TABLE operatories(
    op_id INT NOT NULL,
    name VARCHAR(250) NOT NULL,
    PRIMARY KEY(op_id)
);

CREATE TABLE patient(
    patient_id INT NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    PRIMARY KEY(patient_id)
);

CREATE TABLE app_type(
    app_type_id INT NOT NULL,
    app_name VARCHAR(255),
    app_description VARCHAR(255),
    PRIMARY KEY(app_type_id)
);

CREATE TABLE appointment(
    app_id INT NOT NULL,
    app_type_id INT NOT NULL,
    patient_id INT NOT NULL,
    user_id INT NOT NULL,
    op_id INT NOT NULL,
    transaction_id INT NOT NULL,
    app_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    PRIMARY KEY(app_id),
    FOREIGN KEY(app_type_id) REFERENCES app_type(app_type_id),
    FOREIGN KEY(patient_id) REFERENCES patient(patient_id),
    FOREIGN KEY(user_id) REFERENCES user_name(user_id),
    FOREIGN KEY(op_id) REFERENCES operatories(op_id),
    FOREIGN KEY(transaction_id) REFERENCES ledger(transaction_id)
)

CREATE TABLE provider_schedule(
    user_id INT NOT NULL,
    schedule_date DATE,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY(user_id) REFERENCES user_name(user_id)
);



/*CREATE TABLE Languages(
    LanguagesId INT NOT NULL,
    LanguageType VARCHAR(250),
    PRIMARY KEY(LanguagesId)
);*/ 
/*CREATE TABLE Job_Type(
    job_type_id INT NOT NULL,
    name VARCHAR(250),
    GraduatedFromSchool SMALLINT,
    Level INT(3),
    RegistrationNumber INT,
    PRIMARY KEY(job_type_id)
    
);
CREATE TABLE practitioner(
    practitioner_id INT NOT NULL,
    job_type_id INT,
    PracticingSince DATE,
    PlannedYearsLeft DATE,
    Level INT(3),
    PRIMARY KEY(practitioner_id),
    FOREIGN KEY(job_type_id) REFERENCES Job_Type(job_type_id)
); CREATE TABLE Practice(
    PracticeId INT NOT NULL,
    PracticeAdress VARCHAR(250),
    Employees INT,
    OperatoriesId INT,
    EstablishedDate DATE,
    HoursOfOperation DATETIME,
    PracticePostalCode VARCHAR(6),
    PRIMARY KEY(PracticeId)
); 
CREATE TABLE Team_Member(
  TeamMemberID INT NOT NULL,
  FirstName VARCHAR(250),
  LastName VARCHAR(250),
  MiddleName VARCHAR(250),
  PreferedName VARCHAR(250),
  OfficePhoneNumber VARCHAR(10),
  EmailAdress VARCHAR(250),
  teamBirthdate DATE,
  ProfilePicture BLOB,
  teamMember_Password VARCHAR(16),
  Biography VARCHAR(250),
  ContactDays DATE,
  ContactTime TIME,
  Pronouns VARCHAR(250),
  PracticeId INT,
  job_type_id INT,
  LanguagesId INT,
    PRIMARY KEY(TeamMemberID),
    FOREIGN KEY(LanguagesId) REFERENCES Languages(LanguagesId),
    FOREIGN KEY(job_type_id) REFERENCES Job_Type(job_type_id),
    FOREIGN KEY(PracticeId) REFERENCES Practice(PracticeId)
); */
