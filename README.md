# Event Management Application

A PHP-based web application for managing events and venues. Built using the MVC (Model-View-Controller) structure and powered by MySQL as the database, this application provides a robust system for event management, including user authentication, role-based views for admin and regular users, and complete CRUD operations for managing events and venues.

## Project Overview

The **Event Management Application** allows administrators to manage events and venues while enabling users to view event details and register for events. With user login functionality, the app offers different views and features based on user roles (admin vs. regular user).

### Key Features

- **MVC Architecture**: Clean separation of concerns for efficient development and maintenance.
- **MySQL Database**: Stores and manages event, venue, and user data securely.
- **User Authentication**: Secure login for users with role-based access (admin and regular user).
- **CRUD Operations**: Full CRUD functionality for managing events and venues.
- **Role-Based Access**: Admin users can create, edit, and delete events and venues, while regular users have view-only permissions.
- **Apache Compatibility**: Designed to be run on an Apache server environment.

## Project Structure

The application follows an MVC structure:

- **Model**: Defines data structure and handles database interactions.
- **View**: Handles the UI and displays data to the user.
- **Controller**: Manages user requests and interactions, coordinating between the model and view.

### File Organization

