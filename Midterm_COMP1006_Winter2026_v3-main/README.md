# Book Review Manager

## Overview

Using the **provided SQL** (to create the database table) and the **provided HTML form**, you will build a simple PHP + database CRUD application.

Users must be able to submit a book review, and an administrator must be able to manage all reviews. No authentication (i.e. login) is needed for this application. 

---

## Your Task

### 1) Create a New Repository

- Create a **new GitHub repository** for this exam question.
- Build your application inside that repository.
- When finished, submit the **link to your repository** on Blackboard as your answer. 

---

## Database

You will work with a table named:

`reviews`

Fields:

- `id` (Primary Key, Auto Increment)
- `title`
- `author`
- `rating`
- `review_text`
- `created_at`

You must connect to the database using PDO.

---

## Application Requirements

### 1. Submit a Book Review (Create) (5 marks) 

Using the provided HTML form:

- Accept user input
- Sanitize and validate the form data on the server
- If valid, store the review in the database
- If invalid, display an error message and do not insert the record

---

### 2. Admin Page (Read) (5 marks) 

Create an admin page that:

- Retrieves all book reviews from the database
- Displays them in a dynamically generated HTML table
- Includes Update and Delete options for each review

---

### 3. Update (5 marks) 

The admin must be able to:

- Select a review
- Load the existing data into a form
- Edit the values
- Save the changes to the database

---

### 4. Delete (5 marks) 

The admin must be able to:

- Delete a selected review from the database

---

## Validation Requirements

You must implement server-side validation. (3 marks) 

At minimum:

- Required fields must not be empty
- Numeric fields must contain valid numbers
- Data must be sanitized before storing
- Invalid data must not be inserted into the database

---

## Technical Requirements

Your solution must:

- Use PDO and prepared statements
- Include code comments explaining your logic (2 marks) 
- Avoid placing raw user input directly into SQL statements

---

## Submission

Submit the **GitHub repository link** as your answer to the question on Blackboard. 

**Total - 25 marks**
