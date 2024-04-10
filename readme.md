# Friendzone

### File Structure

The repository includes the following PHP files:

1. **index.php**
   - **Description:** The main landing page of the application, displaying posts, search functionality, and user login/register options.
   - **Dependencies:** Requires `db.php`, `add-comment.php`, `create-post.php`, `dashboard.php`, `login.php`, `register.php`, `update-profile.php`, `view-profile.php`, and Bootstrap library.

2. **login.php**
   - **Description:** Handles user login functionality.
   - **Dependencies:** Requires `db.php`.
   - **Security Measures:**
     - Implements password hashing using `password_verify()` to secure user passwords.
     - Utilises session management to ensure secure user sessions.

3. **register.php**
   - **Description:** Manages user registration and account creation.
   - **Dependencies:** Requires `db.php`.
   - **Security Measures:**
     - Implements password hashing using `password_hash()` to secure user passwords.
     - Validates and sanitises user inputs to prevent SQL injection.

4. **update-profile.php**
   - **Description:** Allows users to update their profile information.
   - **Dependencies:** Requires `db.php`.
   - **Security Measures:**
     - Validates and sanitises user inputs to prevent potential security vulnerabilities.

5. **view-profile.php**
   - **Description:** Displays user profiles and their information.
   - **Dependencies:** Requires `db.php`.
   - **Security Measures:**
     - Ensures proper authorisation to view user profiles.
     - Validates and sanitises user inputs.

6. **add-comment.php**
   - **Description:** Manages the addition of comments to posts.
   - **Dependencies:** Requires `db.php`.
   - **Security Measures:**
     - Validates and sanitises user inputs to prevent potential security vulnerabilities.

7. **create-post.php**
   - **Description:** Handles the creation of new posts.
   - **Dependencies:** Requires `db.php`.
   - **Security Measures:**
     - Validates and sanitises user inputs.
     - Ensures proper authorisation to create posts.

8. **dashboard.php**
   - **Description:** User dashboard displaying user-specific information and options.
   - **Dependencies:** Requires `db.php`.
   - **Security Measures:**
     - Ensures proper authorisation for dashboard access.
     - Validates and sanitises user inputs.

9. **db.php**
   - **Description:** Contains database connection details. Used by various PHP files.
   - **Security Measures:**
     - Encourages the use of parameterised queries to prevent SQL injection.

### Setup and Configuration

1. Ensure you have a PHP environment set up.
2. Import the database using the provided SQL script (`friendzonedb.sql`).
3. Update the database connection details in `db.php` with your database credentials.

### Marker Login Details
1. Username: stud_keele
2. Email: stud@keele.ac.uk
3. Password: stud_keele*!12

### Other Login Details
1. Username: Borat
2. Email: boratsagdiyev@keele.ac.uk
3. Password: GreatSuccess2024!

1. Username: Rick Astley
2. Email: ricky@keele.ac.uk
3. Password: NeverGonnaGiveYouUp1!
