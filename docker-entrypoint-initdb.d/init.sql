-- PostgreSQL Database Dump
-- Converted from MySQL for vulnmarket

BEGIN;

-- --------------------------------------------------------

--
-- Structure de la table `applications`
--

DROP TABLE IF EXISTS applications CASCADE;
CREATE TABLE IF NOT EXISTS applications (
  id SERIAL PRIMARY KEY,
  job_id INTEGER DEFAULT NULL,
  user_id INTEGER DEFAULT NULL,
  cv_path VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Déchargement des données de la table `applications`
--

INSERT INTO applications (job_id, user_id, cv_path, created_at) VALUES
(2, 1, 'dummy_cv_path', '2025-07-24 12:31:19');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

DROP TABLE IF EXISTS jobs CASCADE;
CREATE TABLE IF NOT EXISTS jobs (
  id SERIAL PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  user_id INTEGER DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS flag CASCADE;
CREATE TABLE IF NOT EXISTS flag (
  id SERIAL PRIMARY KEY,
  flag_name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO flag (flag_name, created_at) VALUES
('spider{Hell0_W3b_Flag_1110}', NOW());

--
-- Déchargement des données de la table `jobs`
--

-- Déchargement des données de la table jobs
INSERT INTO jobs (title, description, user_id, created_at) VALUES
('Frontend Developer', 'Build responsive UIs.', 1, '2025-07-24 12:28:50'),
('Backend Developer', 'Maintain APIs and business logic.', 1, '2025-07-24 12:29:05'),
('Full Stack Engineer', 'Work on both frontend and backend.', 1, NOW()),
('DevOps Engineer', 'Automate deployment pipelines.', 1, NOW()),
('Cybersecurity Analyst', 'Monitor and protect systems.', 1, NOW()),
('Data Scientist', 'Analyze and visualize data.', 1, NOW()),
('UX Designer', 'Improve user experience.', 1, NOW()),
('QA Engineer', 'Test and ensure quality.', 1, NOW()),
('Mobile Developer', 'Develop Android/iOS apps.', 1, NOW()),
('Cloud Architect', 'Design scalable infrastructure.', 1, NOW()),
('AI Engineer', 'Implement machine learning models.', 1, NOW()),
('Database Administrator', 'Manage relational databases.', 1, NOW()),
('IT Support Specialist', 'Help users resolve tech issues.', 1, NOW()),
('Technical Writer', 'Create product documentation.', 1, NOW()),
('Project Manager', 'Coordinate development teams.', 1, NOW()),
('Product Owner', 'Define and prioritize product features.', 1, NOW()),
('Scrum Master', 'Facilitate Agile ceremonies.', 1, NOW()),
('Game Developer', 'Create game mechanics and logic.', 1, NOW()),
('Network Engineer', 'Design and monitor networks.', 1, NOW()),
('System Administrator', 'Maintain system uptime and security.', 1, NOW());


-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS messages CASCADE;
CREATE TABLE IF NOT EXISTS messages (
  id SERIAL PRIMARY KEY,
  sender_id INTEGER NOT NULL,
  receiver_id INTEGER NOT NULL,
  subject VARCHAR(255) DEFAULT NULL,
  body TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_sender_id ON messages(sender_id);
CREATE INDEX idx_receiver_id ON messages(receiver_id);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS users CASCADE;
CREATE TYPE user_role AS ENUM ('user', 'admin');
CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role user_role DEFAULT 'user',
  bio TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  profile_pic VARCHAR(255) DEFAULT NULL,
  confirmed SMALLINT NOT NULL DEFAULT 0
);

--
-- Déchargement des données de la table `users`
--

INSERT INTO users (username, password, email, role, bio, created_at, profile_pic, confirmed) VALUES
('JohnDoe', '0192023a7bbd73250516f069df18b500', 'john@example.com', 'user', 'Just a regular user.', '2025-07-24 12:00:00', NULL, 1),
('Jinu', '$2a$12$5to4CkEbNxM24VhlX8Qyle28HqSizsihfzMNBwEsHhrN8gLuONnsO', 'spider100@gmail.com', 'admin', 'admin', '2025-07-24 12:59:36', NULL, 1);


--
-- Contraintes pour les tables
--
ALTER TABLE messages
  ADD CONSTRAINT messages_sender_fk FOREIGN KEY (sender_id) REFERENCES users (id),
  ADD CONSTRAINT messages_receiver_fk FOREIGN KEY (receiver_id) REFERENCES users (id);

COMMIT;
