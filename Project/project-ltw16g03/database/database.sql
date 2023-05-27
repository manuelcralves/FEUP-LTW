DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Agent;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS Task;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Hashtag;
DROP TABLE IF EXISTS Ticket_Hashtag;
DROP TABLE IF EXISTS Faq;
DROP TABLE IF EXISTS Reply;

--Tables

CREATE TABLE User (
     id INTEGER PRIMARY KEY AUTOINCREMENT,
     username varchar(255) NOT NULL UNIQUE,
     firstName varchar(255) NOT NULL,
     lastName varchar(255) NOT NULL,
     email varchar(255) NOT NULL UNIQUE,
     password varchar(255) NOT NULL,
     id_department INTEGER DEFAULT NULL,
     is_agent BOOLEAN NOT NULL DEFAULT false,
     is_admin BOOLEAN NOT NULL DEFAULT false,
     CONSTRAINT id_departmentFK FOREIGN KEY(id_department) REFERENCES Department(id)
 );

CREATE TABLE Task (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title varchar(255) NOT NULL,
    description TEXT NOT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT False,
    id_user INTEGER,
    CONSTRAINT id_userFK FOREIGN KEY(id_user) REFERENCES User(id) ON DELETE CASCADE
);

CREATE TABLE Department (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name varchar(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Ticket (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title varchar(255) NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL,
    ticket_status VARCHAR (10)  NOT NULL DEFAULT 'Open' CHECK (ticket_status IN ('Open', 'Assigned', 'Closed')),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_user INTEGER, /* id do client que criou o ticket */
    id_agent INTEGER DEFAULT NULL, /* id do agent que está a tratar do ticket */
    id_department INTEGER, /* id do department do ticket */
    CONSTRAINT current_edit_date_ck CHECK (created_at <= updated_at),
    CONSTRAINT id_usertFK FOREIGN KEY(id_user) REFERENCES User(id),
    CONSTRAINT id_agentFK FOREIGN KEY(id_agent) REFERENCES User(id),
    CONSTRAINT id_departmentFK FOREIGN KEY(id_department) REFERENCES Department(id)
);

CREATE TABLE Hashtag (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tag varchar(255) NOT NULL UNIQUE
);

CREATE TABLE Ticket_Hashtag (
   id_ticket INTEGER,
   id_hashtag INTEGER,
   CONSTRAINT ticket_hashtagPK PRIMARY KEY(id_ticket, id_hashtag),
   CONSTRAINT id_ticketFK FOREIGN KEY(id_ticket) REFERENCES Ticket (id),
   CONSTRAINT id_hashtagFK FOREIGN KEY(id_hashtag) REFERENCES Hashtag (id)
);

CREATE TABLE Faq (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title varchar(255) NOT NULL UNIQUE,
    description text NOT NULL
);

CREATE TABLE Reply (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_ticket INTEGER,
    id_user INTEGER,
    content VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT id_ticketFK FOREIGN KEY(id_ticket) REFERENCES Ticket (id),
    CONSTRAINT id_userFK FOREIGN KEY(id_user) REFERENCES User (id)
);

INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (1, 'Rafa', 'Rafael', 'Alves', 'rafa@gmail.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', NULL, false, false); /*Pass*word1*/
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (2, 'Ze', 'José', 'Guedes', 'ze@outlook.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', 2, true, false); /*Pass*word1*/
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (3, 'Manuel', 'Manuel', 'Alves', 'manuel@outlook.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', 1, true, true); /*Pass*word1*/
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (4, 'Ana', 'Ana', 'Silva', 'ana@gmail.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', 6, true, false);
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (5, 'Luiz', 'Luiz', 'Fernandes', 'luiz@gmail.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', 2, true, false);
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (6, 'Marta', 'Marta', 'Santos', 'marta@gmail.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', 3, true, false);
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (7, 'Pedro', 'Pedro', 'Lima', 'pedro@gmail.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', 4, true, true);
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (8, 'Camila', 'Camila', 'Rocha', 'camila@gmail.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', 5, true, false);
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (9, 'Renato', 'Renato', 'Sousa', 'renato@gmail.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', NULL, false, false);
INSERT INTO User (id, username, firstName, lastName, email, password, id_department, is_agent, is_admin) VALUES (10, 'Juliana', 'Juliana', 'Barros', 'juliana@gmail.com', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d', NULL, false, false);

INSERT INTO Department (id, name) VALUES (1, 'General Support');
INSERT INTO Department (id, name) VALUES (2, 'Technical Support');
INSERT INTO Department (id, name) VALUES (3, 'Billing and Payments');
INSERT INTO Department (id, name) VALUES (4, 'Product Feedback');
INSERT INTO Department (id, name) VALUES (5, 'Marketing');
INSERT INTO Department (id, name) VALUES (6, 'Human Resources');
INSERT INTO Department (id, name) VALUES (7, 'Sales');
INSERT INTO Department (id, name) VALUES (8, 'Information Technology');
INSERT INTO Department (id, name) VALUES (9, 'Quality Assurance');
INSERT INTO Department (id, name) VALUES (10, 'Sports');
INSERT INTO Department (id, name) VALUES (11, 'Daily News');
INSERT INTO Department (id, name) VALUES (12, 'Technology');
INSERT INTO Department (id, name) VALUES (13, 'Culture');
INSERT INTO Department (id, name) VALUES (14, 'Cooking');
INSERT INTO Department (id, name) VALUES (15, 'Travel');
INSERT INTO Department (id, name) VALUES (16, 'Health');
INSERT INTO Department (id, name) VALUES (17, 'Science');
INSERT INTO Department (id, name) VALUES (18, 'Business');
INSERT INTO Department (id, name) VALUES (19, 'Entertainment');
INSERT INTO Department (id, name) VALUES (20, 'Education');
INSERT INTO Department (id, name) VALUES (21, 'Automotive');
INSERT INTO Department (id, name) VALUES (22, 'Politics');
INSERT INTO Department (id, name) VALUES (23, 'Fashion');
INSERT INTO Department (id, name) VALUES (24, 'Real Estate');
INSERT INTO Department (id, name) VALUES (25, 'Pets');
INSERT INTO Department (id, name) VALUES (26, 'Gaming');
INSERT INTO Department (id, name) VALUES (27, 'Family');
INSERT INTO Department (id, name) VALUES (28, 'Home');
INSERT INTO Department (id, name) VALUES (29, 'Shopping');
INSERT INTO Department (id, name) VALUES (30, 'Religion');
INSERT INTO Department (id, name) VALUES (31, 'Music');
INSERT INTO Department (id, name) VALUES (32, 'Movies');
INSERT INTO Department (id, name) VALUES (33, 'Books');
INSERT INTO Department (id, name) VALUES (34, 'Beauty');
INSERT INTO Department (id, name) VALUES (35, 'Fitness');
INSERT INTO Department (id, name) VALUES (36, 'Food');
INSERT INTO Department (id, name) VALUES (37, 'Art');
INSERT INTO Department (id, name) VALUES (38, 'Design');
INSERT INTO Department (id, name) VALUES (39, 'Photography');
INSERT INTO Department (id, name) VALUES (40, 'Others');



INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('See a ticket', 'I dont know how to see the status of my ticket', 'Open', 1, NULL, 1);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Payment issue', 'My payment is not going through', 'Assigned', 2, 7, 3);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Bug in software', 'There is a bug in your software', 'Closed', 5, 2, 2);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Shipping delay', 'My order is delayed in shipping', 'Open', 5, NULL, 5);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Product damaged', 'My product arrived damaged', 'Open', 6, NULL, 4);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Refund request', 'I would like to request a refund', 'Open', 1, NULL, 3);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Order status', 'I would like to know the status of my order', 'Assigned', 10, 3, 5);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Product question', 'I have a question about your product', 'Closed', 8, 6, 1);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Order issue', 'There is an issue with my order', 'Open', 10, NULL, 10);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Billing inquiry', 'I have a question about my bill', 'Assigned', 2, 6, 3);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Product missing', 'My order is missing a product', 'Open', 6, NULL, 4);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Cancellation request', 'I would like to cancel my order', 'Assigned', 7, 8, 3);
INSERT INTO Ticket(title, description, ticket_status, id_user, id_agent, id_department) VALUES ('Feature request', 'I would like to request a new feature', 'Open', 4, NULL, 4);

INSERT INTO Hashtag (tag) VALUES ('#trouble_ticket'); --1
INSERT INTO Hashtag (tag) VALUES ('#scam'); --2
INSERT INTO Hashtag (tag) VALUES ('#cant_pay'); --3
INSERT INTO Hashtag (tag) VALUES ('#help'); --4
INSERT INTO Hashtag (tag) VALUES ('#doesnt_work'); --5
INSERT INTO Hashtag (tag) VALUES ('#department'); --6
INSERT INTO Hashtag (tag) VALUES ('#urgent'); --7
INSERT INTO Hashtag (tag) VALUES ('#problem'); --8
INSERT INTO Hashtag (tag) VALUES ('#seen_better'); --9
INSERT INTO Hashtag (tag) VALUES ('#trash_product'); --10

INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (1,4);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (1,1);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (1,7);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (2,2);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (2,3);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (3,5);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (3,9);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (4,7);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (5,10);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (5,1);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (6,7);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (6,8);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (13,1);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (12,4);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (11,2);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (11,7);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (10,4);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (9,1);
INSERT INTO Ticket_Hashtag (id_ticket, id_hashtag) VALUES (8,1);

INSERT INTO Faq (id, title, description) VALUES (1, 'What is a trouble ticket?', 'A trouble ticket is a record of a customer reported problem or issue that needs to be addressed by technical support staff.');
INSERT INTO Faq (id, title, description) VALUES (2, 'How do I submit a trouble ticket?', 'You can submit a trouble ticket by filling out the ticket submission form.');
INSERT INTO Faq (id, title, description) VALUES (3, 'How long will it take for my ticket to be resolved?', 'The time it takes to resolve a ticket depends on the complexity of the issue and the volume of tickets currently being handled by our support team. We strive to resolve all tickets as quickly as possible, and we will keep you updated on the progress of your ticket throughout the process.');
INSERT INTO Faq (id, title, description) VALUES (4, 'Can I track the status of my ticket?', 'Yes, you can track the status of your ticket by checking the status of your ticket in the respective ticket page.');
INSERT INTO Faq (id, title, description) VALUES (5, 'What information should I include in my trouble ticket?', 'To help us quickly and accurately diagnose and resolve your issue, please include as much detail as possible in your ticket submission. This may include a description of the issue, any error messages or screenshots, and any steps you have already taken to try to resolve the issue.');
INSERT INTO Faq (id, title, description) VALUES (6, 'How do I cancel a ticket?', 'You can cancel a ticket by navigating to the ticket in question.');
INSERT INTO Faq (id, title, description) VALUES (7, 'What types of issues can I submit a trouble ticket for?', 'You can submit a trouble ticket for any technical issue or problem that you are experiencing with a product or service.');

INSERT INTO Reply (id, id_ticket, id_user, content) VALUES (1, 2, 7, 'Hello, I am sorry to hear that you are having trouble with your order. I will look into this issue and get back to you as soon as possible.');