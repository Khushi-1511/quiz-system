# Architecture Documentation

## Overview

The Quiz System is built on Laravel 12 following MVC architecture with a dedicated Service Layer for evaluation logic. The system is designed to be extensible — adding a new question type requires minimal changes in a single place.

## Database Design

### Tables

**quizzes** — Stores quiz title and description.

**questions** — Belongs to a quiz. Has a type enum field (binary, single, multiple, number, text), supports image_path, video_url, marks, and order.

**options** — Belongs to a question. Stores option text, optional image, and is_correct flag. Used for choice-based questions AND as the correct answer store for text/number questions.

**attempts** — Records each quiz attempt with participant name and total score.

**answers** — Links an attempt to each question answered.

**answer_values** — Stores the actual answer given:
- option_id for choice-based questions (binary, single, multiple)
- text_value for text/number questions

### Key Design Decision: Unified Answer Storage

Instead of separate tables per question type, answer_values handles all types uniformly. This avoids schema changes when adding new question types.

## Evaluation Engine — Strategy Pattern

The core of the system is the QuizEvaluationService which uses the Strategy Pattern to evaluate answers.

Each evaluator implements the QuestionEvaluator interface:

public function evaluate(Question $question, Answer $answer): int;

### Why Strategy Pattern?

Without this pattern, evaluation would look like:

if ($type === 'binary') { ... }
elseif ($type === 'single') { ... }
elseif ($type === 'multiple') { ... }
// adding new type = editing this file everywhere

With the strategy pattern, adding a new type means adding ONE line to the evaluators array in QuizEvaluationService. No existing code needs to change.

## Adding a New Question Type (Future Extensibility)

To add a new question type (e.g. rating):

1. Add rating to the type enum in the migration
2. Create app/Services/Evaluators/RatingEvaluator.php implementing QuestionEvaluator
3. Register it in QuizEvaluationService evaluators array
4. Add the UI case in the Blade views

No existing code needs to change. This satisfies the Open/Closed Principle.

## Directory Structure

app/
- Http/Controllers/
  - QuizController.php
  - QuestionController.php
  - AttemptController.php
- Models/
  - Quiz, Question, Option, Attempt, Answer, AnswerValue
- Services/
  - QuizEvaluationService.php
  - Evaluators/
    - QuestionEvaluator.php (interface)
    - BinaryEvaluator.php
    - SingleChoiceEvaluator.php
    - MultipleChoiceEvaluator.php
    - NumberEvaluator.php
    - TextEvaluator.php

## Design Principles Applied

- Strategy Pattern — Evaluation logic per question type
- Single Responsibility — Each evaluator handles one type only
- Open/Closed Principle — Open for extension, closed for modification
- MVC + Service Layer — Business logic kept out of controllers
