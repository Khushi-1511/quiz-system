cat > AI_USAGE.md << 'ENDOFFILE'
# AI Usage Documentation

## Tools Used

Claude (Anthropic) — Used throughout development for architecture guidance, code generation, and debugging.

## How AI Was Used

### 1. Architecture Planning
Prompt: I need to build a Laravel quiz system supporting multiple question types. The system must be extensible for future types. How should I design the database and evaluation logic?

AI suggested the Strategy Pattern for evaluation and a unified answer_values table to handle all answer types without schema changes per type.

Correction made: I added nullOnDelete() for option_id in answer_values since text/number answers do not use options.

### 2. Migration Files
Prompt: Generate Laravel migration files for quizzes, questions, options, attempts, answers, answer_values tables.

AI generated all 6 migration files with correct foreign keys and cascade deletes. No corrections needed.

### 3. Evaluation Engine
Prompt: Implement the Strategy Pattern in Laravel for quiz evaluation. Each question type needs its own evaluator implementing a common interface.

AI generated the QuestionEvaluator interface and all 5 evaluator classes plus QuizEvaluationService.

Correction made: MultipleChoiceEvaluator initially used == for array comparison which fails on ordering. Fixed to sort both arrays before comparing.

### 4. Debugging Scoring Bug
Prompt: My quiz always shows 0 score. Options are stored with is_correct=0 even when I mark the correct one.

AI identified the form was sending correct[] as index numbers but controller was reading is_correct[]. Fix was to rename the input field and update the controller.

Verified fix by running Option::all() in tinker and confirming is_correct=1 was saved.

### 5. Blade Views
Prompt: Generate Bootstrap 5 Blade views for quiz list, create, show, question create with dynamic options, attempt form, and result page.

AI generated all views. Correction made: Added Storage facade import to views using image paths which AI initially omitted.

## Summary

| Task | AI Used | Corrections Needed |
|------|---------|--------------------|
| Architecture | Yes | nullOnDelete fix |
| Migrations | Yes | None |
| Models | Yes | None |
| Evaluation engine | Yes | Array comparison fix |
| Controllers | Yes | is_correct field fix |
| Blade views | Yes | Storage facade import |
| Debugging | Yes | Guided process |

## Key Takeaway

AI was effective for boilerplate and architectural patterns but required human review for edge cases around form data binding and array comparison logic. Every suggestion was tested before being used.
ENDOFFILE