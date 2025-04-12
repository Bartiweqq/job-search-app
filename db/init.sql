-- Создание таблицы пользователей
CREATE TABLE users (
                       user_id SERIAL PRIMARY KEY,
                       username VARCHAR(255) NOT NULL UNIQUE,
                       email VARCHAR(255) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       role VARCHAR(50) NOT NULL
);

-- Создание таблицы вакансий
CREATE TABLE jobs (
                      job_id SERIAL PRIMARY KEY,
                      title VARCHAR(255) NOT NULL,
                      description TEXT NOT NULL,
                      salary INTEGER NOT NULL,
                      employer_id INTEGER REFERENCES users(user_id)
);

-- Создание таблицы откликов
CREATE TABLE applications (
                              application_id SERIAL PRIMARY KEY,
                              job_id INTEGER REFERENCES jobs(job_id),
                              worker_id INTEGER REFERENCES users(user_id),
                              status VARCHAR(50) NOT NULL
);
