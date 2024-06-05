# Mini Task Management Application

## Introduction

This Mini Task Management Application is built using PHP Laravel for the backend, Vue.js for the frontend, and MySQL for
the database. It allows users to register, create tasks with subtasks, and receive automatic reminder emails for tasks
marked as "in progress" but not completed within 24 hours.

## Pre-dependency
1. PHP version 8.1
2. Composer version 2.0
3. Mysql 9.0
4. Node version 20.0
5. Npm version 10.0

## Setup Instructions

1. Clone the repository from GitHub:
   ` git clone https://github.com/your_username/mini-task-management-app.git`

2. Navigate to the project directory:
   `cd mini-task-management-app`

3. Install PHP dependencies using Composer:
   `composer install`

4. Install JavaScript dependencies using npm or yarn:
   `npm install`

5. Create a copy of the `.env.example` file and rename it to `.env`. Update the database connection settings in
   the `.env` file.
   `cp .env.example .env`
6. Create a new database in MySQL and update the `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` fields in the `.env`
   file with the appropriate values.
7. Generate a new application key:
   `php artisan key:generate`
8. Migrate the database tables:
   `php artisan migrate`

9. Start the Laravel development server if you didn't create any virtual host:
   `php artisan serve`
10. Email setup: Update the `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, and `MAIL_FROM_ADDRESS`
    fields in the `.env` file with the appropriate values for sending reminder emails.
11. To build the frontend assets, run:
    `npm run dev`
12. Access the application in your web browser at `http://localhost:8000` or `http://127.0.0.1:8000
13. Register a new user account and start creating tasks with subtasks.
14. To run the cron-scheduler for sending reminder emails, run:
    `php artisan app:notify-task-progress`
15. To run the queue worker for processing reminder emails, run:
    `php artisan queue:work`
16. To stop the queue worker, press `Ctrl + C`.
17. To stop the Laravel development server, press `Ctrl + C`.
18. To run the Laravel development server on a custom port, use the `--port` option:
    `php artisan serve --port=8080`

## Design Choices and Explanations

- **User Authentication**: I opted to use Laravel Sanctum for user registration and authentication due to its simplicity
  and scalability.
- **Task Model**: I designed the task model to include a `parent_id` field to establish a hierarchical relationship
  between tasks and subtasks.
- **Queue System**: I utilized Laravel's queue capabilities to send reminder emails for tasks marked as "in progress"
  but not completed within 24 hours. This ensures timely notifications for users.
- **Frontend Framework**: Vue.js was chosen for the frontend development due to its reactive components and seamless
  integration with Laravel.

## Trade-offs and Challenges

- **Trade-offs**: One trade-off made was prioritizing functionality over aesthetics during the initial development phase
  to ensure core features were implemented efficiently. Refinement of the UI/UX design can be a future enhancement.
- **Challenges**: Implementing the hierarchical structure for tasks and subtasks required careful planning and thorough
  testing to ensure data integrity and proper display of task hierarchies.
  You can copy and paste this content into a README.md file in your project repository. This format will provide a clear
  and organized guide for setting up and running the application, as well as explanations of design choices and
  challenges encountered during development. Feel free to customize and expand upon this template according to your
  project's specific implementation and requirements.
