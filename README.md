# Leaderboard Laravel API

## Features
- Manage users with scores
- Leaderboard auto-sorts users by score
- View user details (name, age, points, address)
- Add/delete users
- Group users by score with average age
- Reset scores via artisan command
- Generate QR code of user address on creation (queued job)
- Scheduled job to get winner (every 5 mins)

## Setup Instructions

1. Clone the repo:
```bash
git clone https://github.com/dev-abhishek-dixit/leaderboard_laravel_api.git
cd leaderboard_laravel_api
```

2. Install dependencies:
```bash
composer install
```

3. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

4. Configure database in `.env`, then run migrations and seed:
```bash
php artisan migrate --seed
```
set QUEUE_CONNECTION = sqs or redis or database in .env for queue

5. Run the queue worker:
```bash
php artisan queue:work
```

6. cron sheduled on every 5 minute:
```bash
php artisan app:create-winner
```

7. Start the server:
```bash
php artisan serve
```

## API Endpoints

| Method | Endpoint                  | Description                         |
|--------|---------------------------|-------------------------------------|
| GET    | /api/user                | List all users ordered by score     |
| POST   | /api/user                | Create a new user(with Qr generation in queue)     |
| GET    | /api/user/{id}          | Get a user's details                |
| PATCH  | /api/user/{id}          | Increment or decrement user score (you may update other details of user also)  |
| DELETE | /api/user/{id}          | Delete a user                       |
| GET    | /api/group/points      | Users grouped by score with average age |

## Artisan Commands

- `php artisan reset:scores`: Resets all users' scores to 0.

## Testing

Run tests:
```bash
php artisan test --filter=UserTest
```

Note: i have attached postman collection: [LeaderboardCollection](Dashboard.postman_collection.json)
