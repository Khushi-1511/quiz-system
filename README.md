# Quiz System — Laravel

A flexible, extensible quiz system built with Laravel that supports multiple question types, media uploads, and automated evaluation.

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+
- Laravel 12.x

## Setup Instructions

### 1. Clone the repository
git clone your-repo-url
cd quiz-system

### 2. Install dependencies
composer install

### 3. Configure environment
cp .env.example .env
php artisan key:generate

Edit .env and set your database credentials:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quiz_system
DB_USERNAME=root
DB_PASSWORD=your_password

### 4. Create the database
CREATE DATABASE quiz_system;

### 5. Run migrations
php artisan migrate

### 6. Link storage for media uploads
php artisan storage:link

### 7. Start the server
php artisan serve

Visit http://localhost:8000

## Features

- Create quizzes with title and description
- 5 question types: Binary, Single Choice, Multiple Choice, Number Input, Text Input
- Image upload for questions and options
- Video URL support (YouTube etc.)
- Rich text and HTML in question descriptions
- Automated score evaluation using Strategy Pattern
- View all responses per quiz with scores and percentage

## Project Structure

app/
- Http/Controllers/ — QuizController, QuestionController, AttemptController
- Models/ — Quiz, Question, Option, Attempt, Answer, AnswerValue
- Services/ — QuizEvaluationService and Evaluators (Strategy Pattern)

resources/views/
- layouts/app.blade.php
- quizzes/ — index, create, show, responses
- questions/ — create
- attempts/ — start, result

## Timeline Estimate

| Phase | Task | Time |
|-------|------|------|
| 1 | Setup and Configuration | 1 hour |
| 2 | Database Design and Migrations | 2 hours |
| 3 | Models and Relationships | 1 hour |
| 4 | Evaluation Engine | 2 hours |
| 5 | Controllers and Routes | 2 hours |
| 6 | Blade Views and UI | 3 hours |
| 7 | Testing and Documentation | 1 hour |
| Total | | 12 hours (1.5 days) |

I arrived at this estimate by breaking the project into its core concerns: data modeling, business logic (evaluation), and UI. The evaluation engine was given extra time because extensibility was a key requirement of the assignment.
