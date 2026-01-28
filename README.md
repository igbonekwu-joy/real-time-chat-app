Realtime Chat Application

A realtime chat application built with Laravel, Livewire, Vite, Node.js, and WebSockets, featuring typing indicators, emoji support, file attachments, online presence, and unread message counts.

🚀 Features

Realtime messaging

Typing indicators

Emoji picker

File & document attachments

Online / offline status

Unread message count

Message timestamps

Friend blocking

Laravel + Livewire frontend

Node.js server for realtime events

🛠 Tech Stack

Backend: Laravel (PHP)

Frontend: Blade, Livewire, Vite

Realtime Server: Node.js + WebSockets

Database: MySQL

Package Managers: Composer, NPM

📦 Requirements

Make sure you have the following installed:

PHP ≥ 8.1

Composer

Node.js ≥ 18

NPM

MySQL

Git

⚙️ Installation & Setup

Follow these steps carefully.

1️⃣ Clone the Repository
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

2️⃣ Install Laravel Dependencies (Vendor Files)
composer install


If .env does not exist:

cp .env.example .env


Generate app key:

php artisan key:generate

3️⃣ Configure Environment Variables

Update your .env file:

APP_NAME=ChatApp
APP_ENV=local
APP_KEY=base64:generated-key
APP_DEBUG=true
APP_URL=http://localhost

DB_DATABASE=your_database
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

4️⃣ Run Database Migrations
php artisan migrate


(Optional seed data)

php artisan db:seed

5️⃣ Install Frontend Dependencies (Root)
npm install

6️⃣ Setup the Realtime Server

Move into the server directory:

cd server
npm install


Move back to the root directory:

cd ..

7️⃣ Start the Application

Run both Laravel + Vite + Node server together:

npm run dev


This will:

Start Vite for frontend assets

Start the Node.js realtime server with Nodemon

In another terminal, run Laravel:

php artisan serve

🌐 Access the App

Laravel app:
http://localhost:8000

Vite dev server (if separate):
http://localhost:5173
