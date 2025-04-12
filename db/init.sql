-- Таблица пользователей
CREATE TABLE users (
                       id SERIAL PRIMARY KEY,
                       email VARCHAR(255) UNIQUE NOT NULL,
                       password VARCHAR(255) NOT NULL,
                       name VARCHAR(255),
                       role VARCHAR(20) CHECK (role IN ('employer', 'jobseeker')),
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица вакансий
CREATE TABLE jobs (
                      id SERIAL PRIMARY KEY,
                      user_id INTEGER REFERENCES users(id),
                      title VARCHAR(255) NOT NULL,
                      description TEXT,
                      salary INTEGER,
                      experience_required VARCHAR(100),
                      category VARCHAR(100),
                      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
